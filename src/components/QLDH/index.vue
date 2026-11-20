
<template>
  <div class="qldh-page">
    <!-- Tiêu đề -->
    <header class="page-header">
      <div>
        <h1>Quản lý đơn hàng</h1>
        <p>Theo dõi và xử lý đơn hàng của khách hàng</p>
      </div>

      <button class="btn btn-primary" @click="loadOrders" :disabled="loading">
        <span class="refresh-icon">↻</span>
        {{ loading ? 'Đang tải...' : 'Làm mới' }}
      </button>
    </header>

    <!-- Thông báo -->
    <div v-if="error" class="alert alert-error">{{ error }}</div>
    <div v-if="success" class="alert alert-success">{{ success }}</div>

    <!-- Thống kê -->
    <section class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon icon-blue">▤</div>
        <div>
          <p>Tổng đơn hàng</p>
          <h2>{{ orders.length }}</h2>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-orange">◷</div>
        <div>
          <p>Chờ xác nhận</p>
          <h2>{{ countStatus('ChoXacNhan') }}</h2>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-purple">➜</div>
        <div>
          <p>Đang giao</p>
          <h2>{{ countStatus('DangGiao') }}</h2>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-green">✓</div>
        <div>
          <p>Đã giao</p>
          <h2>{{ countStatus('DaGiao') }}</h2>
        </div>
      </div>
    </section>

    <!-- Danh sách đơn -->
    <section class="content-card">
      <div class="section-heading">
        <div>
          <h2>Danh sách đơn hàng</h2>
          <p>{{ filteredOrders.length }} đơn hàng phù hợp</p>
        </div>
      </div>

      <div class="toolbar">
        <div class="search-box">
          <span>⌕</span>
          <input
            v-model.trim="keyword"
            type="search"
            placeholder="Tìm mã đơn, tên khách, số điện thoại..."
          />
        </div>

        <select v-model="statusFilter" class="filter-select">
          <option value="">Tất cả trạng thái</option>
          <option
            v-for="status in statuses"
            :key="status.value"
            :value="status.value"
          >
            {{ status.label }}
          </option>
        </select>
      </div>

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Mã đơn</th>
              <th>Khách hàng</th>
              <th>Ngày đặt</th>
              <th>Tổng tiền</th>
              <th>Thanh toán</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>

          <tbody>
            <tr v-if="loading && orders.length === 0">
              <td colspan="7" class="empty-cell">Đang tải đơn hàng...</td>
            </tr>

            <tr v-else-if="filteredOrders.length === 0">
              <td colspan="7" class="empty-cell">
                Không tìm thấy đơn hàng phù hợp.
              </td>
            </tr>

            <tr v-for="order in filteredOrders" :key="order.MaDH">
              <td>
                <span class="order-code">#{{ order.MaDH }}</span>
              </td>

              <td>
                <div class="customer-name">{{ customerName(order) }}</div>
                <div class="sub-text">{{ customerPhone(order) }}</div>
              </td>

              <td class="date-cell">{{ formatDate(order.NgayDat) }}</td>

              <td class="price-cell">{{ formatMoney(order.TongTien) }}</td>

              <td>{{ order.PhuongThucThanhToan || '—' }}</td>

              <td>
  <span
    class="status-badge"
    :class="statusClass(order.TrangThaiDH)"
  >
    {{ statusLabel(order.TrangThaiDH) }}
  </span>

  <div
    v-if="order.TrangThaiDH === 'DaHuy' && order.LyDoHuy"
    class="cancel-reason-preview"
  >
    Lý do: {{ order.LyDoHuy }}
  </div>
</td>

              <td>
                <div class="action-buttons">
                  <button class="btn btn-detail" @click="viewOrder(order)">
                    Chi tiết
                  </button>

                  <button
                    v-if="nextStatus(order)"
                    class="btn btn-next"
                    :disabled="busyId === order.MaDH"
                    @click="updateStatus(order)"
                  >
                    {{ busyId === order.MaDH ? 'Đang xử lý...' : nextStatus(order).label }}
                  </button>

                  <button
                    v-if="order.TrangThaiDH === 'ChoXacNhan'"
                    class="btn btn-cancel"
                    :disabled="busyId === order.MaDH"
                    @click="cancelOrder(order)"
                  >
                    Hủy đơn
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Chi tiết đơn hàng -->
    <div
      v-if="selectedOrder"
      class="modal-overlay"
      @click.self="selectedOrder = null"
    >
      <section class="detail-modal">
        <header class="modal-header">
          <div>
            <h2>Chi tiết đơn hàng #{{ selectedOrder.MaDH }}</h2>
            <p>Thông tin đơn hàng và sản phẩm đã đặt</p>
          </div>

          <button
            class="close-button"
            aria-label="Đóng"
            @click="selectedOrder = null"
          >
            ×
          </button>
        </header>

        <div class="modal-status">
          <span class="status-badge" :class="statusClass(selectedOrder.TrangThaiDH)">
            {{ statusLabel(selectedOrder.TrangThaiDH) }}
          </span>
          <span class="date-cell">{{ formatDate(selectedOrder.NgayDat) }}</span>
        </div>

        <h3>Thông tin người nhận</h3>

        <div class="detail-grid">
          <div class="detail-item">
            <span>Tên người nhận</span>
            <strong>
              {{ selectedOrder.TenNguoiNhan || customerName(selectedOrder) }}
            </strong>
          </div>

          <div class="detail-item">
            <span>Số điện thoại</span>
            <strong>{{ selectedOrder.SoDienThoaiNhan || '—' }}</strong>
          </div>

          <div class="detail-item">
            <span>Email tài khoản</span>
            <strong>{{ customerEmail(selectedOrder) }}</strong>
          </div>

          <div class="detail-item">
            <span>Phương thức thanh toán</span>
            <strong>{{ selectedOrder.PhuongThucThanhToan || '—' }}</strong>
          </div>

          <div class="detail-item full-width">
            <span>Địa chỉ giao hàng</span>
            <strong>{{ selectedOrder.DiaChiGiaoHang || '—' }}</strong>
          </div>

          <div class="detail-item">
            <span>Mã giảm giá</span>
            <strong>{{ voucherName(selectedOrder) }}</strong>
          </div>
        </div>

        <!-- THÔNG TIN HỦY ĐƠN -->
<section
  v-if="selectedOrder.TrangThaiDH === 'DaHuy'"
  class="cancel-info-section"
>
  <h3>Thông tin hủy đơn</h3>

  <div class="detail-grid">
    <div class="detail-item full-width">
      <span>Lý do hủy</span>
      <strong>{{ selectedOrder.LyDoHuy || 'Chưa có lý do' }}</strong>
    </div>

    <div class="detail-item">
      <span>Người hủy</span>
      <strong>
        {{
          selectedOrder.NguoiHuy === 'Admin'
            ? 'Quản trị viên'
            : selectedOrder.NguoiHuy === 'KhachHang'
              ? 'Khách hàng'
              : '—'
        }}
      </strong>
    </div>

    <div class="detail-item">
      <span>Thời gian hủy</span>
      <strong>
        {{ formatDate(selectedOrder.ThoiGianHuy) }}
      </strong>
    </div>
  </div>
</section>

        <h3>Sản phẩm trong đơn hàng</h3>

        <div class="detail-products">
          <table>
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="(detail, index) in details(selectedOrder)"
                :key="detail.MaCTDH || `${selectedOrder.MaDH}-${detail.MaSP}-${index}`"
              >
                <td>
                  <div class="product-cell">
                    <img
                      v-if="productImage(detail)"
                      :src="productImage(detail)"
                      :alt="productName(detail)"
                      @error="imageErrors.add(productImage(detail))"
                    />
                    <span>{{ productName(detail) }}</span>
                  </div>
                </td>
                <td>{{ detail.SoLuong }}</td>
                <td>{{ formatMoney(detail.GiaBan) }}</td>
                <td class="price-cell">
                  {{ formatMoney(Number(detail.GiaBan || 0) * Number(detail.SoLuong || 0)) }}
                </td>
              </tr>

              <tr v-if="details(selectedOrder).length === 0">
                <td colspan="4" class="empty-cell">
                  Không có chi tiết sản phẩm.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <footer class="modal-total">
          <span>Tổng thanh toán</span>
          <strong>{{ formatMoney(selectedOrder.TongTien) }}</strong>
        </footer>

        <div class="modal-footer">
          <button class="btn btn-detail" @click="selectedOrder = null">
            Đóng
          </button>

          <button
            v-if="nextStatus(selectedOrder)"
            class="btn btn-primary"
            :disabled="busyId === selectedOrder.MaDH"
            @click="updateStatus(selectedOrder)"
          >
            {{ nextStatus(selectedOrder).label }}
          </button>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const API = 'http://127.0.0.1:8000/api'

const orders = ref([])
const loading = ref(false)
const busyId = ref(null)
const error = ref('')
const success = ref('')
const keyword = ref('')
const statusFilter = ref('')
const selectedOrder = ref(null)
const imageErrors = ref(new Set())

const statuses = [
  { value: 'ChoXacNhan', label: 'Chờ xác nhận' },
  { value: 'DaXacNhan', label: 'Đã xác nhận' },
  { value: 'DangGiao', label: 'Đang giao' },
  { value: 'DaGiao', label: 'Đã giao' },
  { value: 'DaHuy', label: 'Đã hủy' }
]

// Lấy token theo các tên đang có thể dùng trong dự án.
function getToken() {
  return localStorage.getItem('admin_token')
    || localStorage.getItem('adminToken')
    || localStorage.getItem('token')
}

function requestConfig() {
  const token = getToken()

  return {
    headers: token
      ? { Authorization: `Bearer ${token}` }
      : {}
  }
}

function apiMessage(err, fallback) {
  return err?.response?.data?.message
    || err?.message
    || fallback
}

async function loadOrders() {
  loading.value = true
  error.value = ''

  try {
    const response = await axios.get(
      `${API}/admin/don-hang/get-data`,
      requestConfig()
    )

    if (response.data?.status === false) {
      throw new Error(
        response.data.message || 'Không thể lấy danh sách đơn hàng.'
      )
    }

    orders.value = Array.isArray(response.data?.data)
      ? response.data.data
      : []
  } catch (err) {
    error.value = apiMessage(
      err,
      'Không tải được đơn hàng. Hãy kiểm tra đăng nhập và API backend.'
    )
  } finally {
    loading.value = false
  }
}

const filteredOrders = computed(() => {
  const search = keyword.value.toLocaleLowerCase('vi')

  return orders.value.filter(order => {
    const id = String(order.MaDH ?? '').toLowerCase()
    const name = customerName(order).toLocaleLowerCase('vi')
    const phone = customerPhone(order).toLowerCase()
    const address = String(order.DiaChiGiaoHang || '').toLocaleLowerCase('vi')

    const matchKeyword = !search
      || id.includes(search)
      || name.includes(search)
      || phone.includes(search)
      || address.includes(search)

    const matchStatus = !statusFilter.value
      || order.TrangThaiDH === statusFilter.value

    return matchKeyword && matchStatus
  })
})

function countStatus(status) {
  return orders.value.filter(order => order.TrangThaiDH === status).length
}

// Hỗ trợ tên quan hệ JSON Laravel dạng snake_case và camelCase.
function customerInfo(order) {
  return order?.nguoi_dung || order?.nguoiDung || {}
}

function customerName(order) {
  return order?.TenNguoiNhan
    || customerInfo(order).HoTen
    || `Khách hàng #${order?.MaND ?? ''}`
}

function customerPhone(order) {
  return String(
    order?.SoDienThoaiNhan
    || customerInfo(order).SoDienThoai
    || ''
  )
}

function customerEmail(order) {
  return customerInfo(order).Email || '—'
}

function details(order) {
  const list = order?.chi_tiet_don_hangs || order?.chiTietDonHangs
  return Array.isArray(list) ? list : []
}

function productInfo(detail) {
  return detail?.san_pham || detail?.sanPham || {}
}

function productName(detail) {
  return productInfo(detail).TenSP || `Sản phẩm #${detail?.MaSP ?? ''}`
}

function productImage(detail) {
  const path = productInfo(detail).HinhAnh

  if (!path || imageErrors.value.has(path)) return ''

  if (/^https?:\/\//i.test(path)) return path

  return `http://127.0.0.1:8000/storage/${String(path).replace(/^\/+/, '')}`
}

function voucherName(order) {
  const voucher = order?.voucher
  return voucher?.MaGiamGia || 'Không sử dụng'
}

function statusLabel(status) {
  return statuses.find(item => item.value === status)?.label
    || status
    || 'Chưa xác định'
}

function statusClass(status) {
  return `status-${status || 'unknown'}`
}

function formatMoney(value) {
  return Number(value || 0).toLocaleString('vi-VN') + ' ₫'
}

function formatDate(value) {
  if (!value) return '—'

  const date = new Date(value)

  if (Number.isNaN(date.getTime())) return value

  return date.toLocaleString('vi-VN', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

function viewOrder(order) {
  selectedOrder.value = order
}

// Mỗi lần chỉ chuyển sang bước kế tiếp.
function nextStatus(order) {
  const next = {
    ChoXacNhan: {
      value: 'DaXacNhan',
      label: 'Xác nhận đơn'
    },
    DaXacNhan: {
      value: 'DangGiao',
      label: 'Chuyển sang đang giao'
    },
    DangGiao: {
      value: 'DaGiao',
      label: 'Xác nhận đã giao'
    }
  }

  return next[order?.TrangThaiDH] || null
}

async function updateStatus(order) {
  const next = nextStatus(order)

  if (!next || busyId.value !== null) return

  const confirmed = window.confirm(
    `Bạn muốn chuyển đơn #${order.MaDH} sang "${next.label}"?`
  )

  if (!confirmed) return

  busyId.value = order.MaDH
  error.value = ''
  success.value = ''

  try {
    const response = await axios.put(
      `${API}/admin/don-hang/update`,
      {
        MaDH: order.MaDH,
        TrangThaiDH: next.value
      },
      requestConfig()
    )

    if (response.data?.status === false) {
      throw new Error(
        response.data.message || 'Cập nhật trạng thái thất bại.'
      )
    }

    success.value = `Đã cập nhật đơn hàng #${order.MaDH}: ${statusLabel(next.value)}.`
    selectedOrder.value = null
    await loadOrders()
  } catch (err) {
    error.value = apiMessage(
      err,
      'Không thể cập nhật trạng thái đơn hàng.'
    )
  } finally {
    busyId.value = null
  }
}

// Backend hiện tại chỉ cho hủy đơn đang Chờ xác nhận.
async function cancelOrder(order) {
  if (order.TrangThaiDH !== 'ChoXacNhan' || busyId.value !== null) {
    return
  }

  const input = window.prompt(
    `Nhập lý do hủy đơn hàng #${order.MaDH}:`
  )

  // Bấm Cancel trong prompt thì không hủy
  if (input === null) return

  const reason = input.trim()

  if (!reason) {
    error.value = 'Vui lòng nhập lý do hủy đơn hàng.'
    return
  }

  if (reason.length > 255) {
    error.value = 'Lý do hủy không được vượt quá 255 ký tự.'
    return
  }

  busyId.value = order.MaDH
  error.value = ''
  success.value = ''

  try {
    const response = await axios.delete(
      `${API}/don-hang/delete`,
      {
        ...requestConfig(),
        data: {
          id: order.MaDH,
          LyDoHuy: reason
        }
      }
    )

    if (response.data?.status !== true) {
      throw new Error(
        response.data?.message || 'Hủy đơn thất bại.'
      )
    }

    success.value = `Đã hủy đơn hàng #${order.MaDH}.`

    if (selectedOrder.value?.MaDH === order.MaDH) {
      selectedOrder.value = null
    }

    await loadOrders()
  } catch (err) {
    error.value =
      err?.response?.data?.message ||
      (
        err?.response?.data?.errors &&
        Object.values(err.response.data.errors).flat().join(' ')
      ) ||
      'Không thể hủy đơn hàng.'
  } finally {
    busyId.value = null
  }
}

onMounted(loadOrders)
</script>

<style scoped>
/* =========================================================
   BẢNG MÀU & BIẾN DÙNG CHUNG
   ========================================================= */
.qldh-page {
  --primary: #4f46e5;
  --primary-2: #2563eb;
  --accent: #06b6d4;
  --navy: #0f172a;
  --text: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --soft: #f1f5f9;
  --grad-primary: linear-gradient(135deg, #4f46e5 0%, #2563eb 55%, #06b6d4 100%);
  --grad-danger: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
  --grad-success: linear-gradient(135deg, #34d399 0%, #059669 100%);
  --grad-warm: linear-gradient(135deg, #fbbf24 0%, #f97316 100%);
  --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.06);
  --ease: cubic-bezier(0.22, 1, 0.36, 1);

  min-height: 100%;
  padding: 26px;
  background: linear-gradient(180deg, #f5f7ff 0%, #f8fafc 100%);
  color: var(--text);
  font-family: "Roboto", "Inter", Arial, sans-serif;
}

.qldh-page * {
  box-sizing: border-box;
}

/* =========================================================
   KEYFRAMES
   ========================================================= */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes rowIn {
  from { opacity: 0; transform: translateX(-10px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes pulseDot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.35); }
}

@keyframes shine {
  from { transform: translateX(-120%) skewX(-20deg); }
  to { transform: translateX(260%) skewX(-20deg); }
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

@keyframes overlayIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes modalIn {
  from { opacity: 0; transform: translateY(28px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes alertIn {
  from { opacity: 0; transform: translateY(-12px) scale(0.98); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

.page-header { animation: fadeUp 0.5s var(--ease) both; }

.stat-card { animation: fadeUp 0.55s var(--ease) both; }
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.12s; }
.stat-card:nth-child(3) { animation-delay: 0.19s; }
.stat-card:nth-child(4) { animation-delay: 0.26s; }

.content-card { animation: fadeUp 0.6s var(--ease) 0.3s both; }

.content-card tbody tr { animation: rowIn 0.4s var(--ease) both; }
.content-card tbody tr:nth-child(1) { animation-delay: 0.04s; }
.content-card tbody tr:nth-child(2) { animation-delay: 0.08s; }
.content-card tbody tr:nth-child(3) { animation-delay: 0.12s; }
.content-card tbody tr:nth-child(4) { animation-delay: 0.16s; }
.content-card tbody tr:nth-child(5) { animation-delay: 0.2s; }
.content-card tbody tr:nth-child(6) { animation-delay: 0.24s; }
.content-card tbody tr:nth-child(7) { animation-delay: 0.28s; }
.content-card tbody tr:nth-child(8) { animation-delay: 0.32s; }

/* =========================================================
   TIÊU ĐỀ
   ========================================================= */
.page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 18px;
  margin-bottom: 26px;
}

.page-header h1 {
  margin: 0 0 7px;
  font-size: 29px;
  font-weight: 800;
  letter-spacing: -0.4px;
  background: linear-gradient(90deg, #0f172a 0%, #4f46e5 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.page-header p,
.section-heading p,
.modal-header p {
  margin: 0;
  color: var(--muted);
  font-size: 13.5px;
}

/* =========================================================
   NÚT
   ========================================================= */
.btn {
  position: relative;
  overflow: hidden;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  gap: 7px;
  min-height: 36px;
  padding: 0 14px;
  border: 0;
  border-radius: 10px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease),
    background 0.25s, filter 0.25s;
}

.btn:disabled {
  cursor: not-allowed;
  opacity: 0.55;
}

.btn:active:not(:disabled) {
  transform: scale(0.95);
}

.btn-primary {
  min-height: 42px;
  padding: 0 18px;
  font-size: 13px;
  color: #fff;
  background: var(--grad-primary);
  background-size: 140% 140%;
  background-position: 0% 50%;
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
}

.btn-primary::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 40%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
  transform: translateX(-120%) skewX(-20deg);
  pointer-events: none;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  background-position: 100% 50%;
  box-shadow: 0 12px 26px rgba(79, 70, 229, 0.42);
}

.btn-primary:hover:not(:disabled)::after {
  animation: shine 0.8s var(--ease);
}

.refresh-icon {
  display: inline-block;
  font-size: 19px;
  line-height: 1;
  transition: transform 0.5s var(--ease);
}

.btn-primary:hover:not(:disabled) .refresh-icon {
  transform: rotate(180deg);
}

.btn-primary:disabled .refresh-icon {
  animation: spin 0.8s linear infinite;
}

/* nút trong bảng */
.btn-detail {
  color: #475569;
  background: var(--soft);
  border: 1.5px solid var(--line);
}

.btn-detail:hover:not(:disabled) {
  color: var(--primary);
  border-color: #c7d2fe;
  background: #eef2ff;
  transform: translateY(-2px);
}

.btn-next {
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #2563eb);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.3);
}

.btn-next:hover:not(:disabled) {
  transform: translateY(-3px);
  filter: brightness(1.06);
  box-shadow: 0 10px 20px rgba(79, 70, 229, 0.45);
}

.btn-cancel {
  color: #fff;
  background: var(--grad-danger);
  box-shadow: 0 5px 12px rgba(244, 63, 94, 0.3);
}

.btn-cancel:hover:not(:disabled) {
  transform: translateY(-3px);
  filter: brightness(1.06);
  box-shadow: 0 10px 20px rgba(244, 63, 94, 0.45);
}

/* =========================================================
   THÔNG BÁO
   ========================================================= */
.alert {
  margin-bottom: 16px;
  padding: 14px 18px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 600;
  animation: alertIn 0.4s var(--ease) both;
}

.alert-error {
  color: #be123c;
  background: #fff1f2;
  border: 1px solid #fecdd3;
  border-left: 5px solid #f43f5e;
}

.alert-success {
  color: #047857;
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  border-left: 5px solid #10b981;
}

/* =========================================================
   THẺ THỐNG KÊ
   ========================================================= */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 18px;
  margin-bottom: 24px;
}

.stat-card {
  --tone: #4f46e5;
  --tone-soft: rgba(79, 70, 229, 0.1);
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  gap: 16px;
  min-width: 0;
  min-height: 108px;
  padding: 20px;
  border: 1px solid var(--line);
  border-radius: 16px;
  background: #fff;
  box-shadow: var(--shadow-sm);
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease),
    border-color 0.3s;
}

.stat-card::before {
  content: "";
  position: absolute;
  top: -38px;
  right: -38px;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: var(--tone-soft);
  transition: transform 0.5s var(--ease);
}

.stat-card::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 4px;
  background: var(--tone);
  transform: scaleX(0.28);
  transform-origin: left;
  transition: transform 0.45s var(--ease);
}

.stat-card:nth-child(1) { --tone: #4f46e5; --tone-soft: rgba(79, 70, 229, 0.1); }
.stat-card:nth-child(2) { --tone: #f59e0b; --tone-soft: rgba(245, 158, 11, 0.13); }
.stat-card:nth-child(3) { --tone: #a855f7; --tone-soft: rgba(168, 85, 247, 0.12); }
.stat-card:nth-child(4) { --tone: #10b981; --tone-soft: rgba(16, 185, 129, 0.12); }

.stat-card:hover {
  transform: translateY(-6px);
  border-color: transparent;
  box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
}

.stat-card:hover::before { transform: scale(1.5); }
.stat-card:hover::after { transform: scaleX(1); }

.stat-card > div:last-child {
  position: relative;
  z-index: 1;
  min-width: 0;
}

.stat-icon {
  position: relative;
  z-index: 1;
  display: grid;
  place-items: center;
  flex: 0 0 54px;
  width: 54px;
  height: 54px;
  border-radius: 16px;
  color: #fff;
  font-size: 23px;
  font-weight: 700;
  transition: transform 0.35s var(--ease);
}

.stat-card:hover .stat-icon {
  transform: rotate(-8deg) scale(1.1);
}

.icon-blue {
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  box-shadow: 0 8px 16px rgba(79, 70, 229, 0.35);
}

.icon-orange {
  background: linear-gradient(135deg, #fbbf24, #f97316);
  box-shadow: 0 8px 16px rgba(245, 158, 11, 0.38);
}

.icon-purple {
  background: linear-gradient(135deg, #c084fc, #9333ea);
  box-shadow: 0 8px 16px rgba(168, 85, 247, 0.35);
}

.icon-green {
  background: linear-gradient(135deg, #34d399, #059669);
  box-shadow: 0 8px 16px rgba(16, 185, 129, 0.35);
}

.stat-card p {
  margin: 0 0 7px;
  color: var(--muted);
  font-size: 12px;
  font-weight: 600;
}

.stat-card h2 {
  margin: 0;
  color: var(--navy);
  font-size: 28px;
  font-weight: 800;
  line-height: 1.1;
}

/* =========================================================
   KHUNG DANH SÁCH
   ========================================================= */
.content-card {
  overflow: hidden;
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 18px;
  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
}

.section-heading {
  padding: 24px 26px 16px;
}

.section-heading h2 {
  margin: 0 0 6px;
  color: var(--navy);
  font-size: 18px;
  font-weight: 800;
}

.toolbar {
  display: flex;
  gap: 12px;
  padding: 0 26px 18px;
}

.search-box {
  display: flex;
  align-items: center;
  gap: 10px;
  flex: 1;
  min-width: 200px;
  padding: 0 14px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  color: var(--muted);
  background: var(--soft);
  transition: all 0.25s var(--ease);
}

.search-box:hover { border-color: #c7d2fe; }

.search-box:focus-within {
  color: var(--primary);
  background: #fff;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.search-box span { font-size: 21px; }

.search-box input {
  width: 100%;
  height: 43px;
  border: 0;
  outline: none;
  background: transparent;
  color: var(--navy);
  font: inherit;
  font-size: 13px;
}

.search-box input::placeholder { color: #94a3b8; }

.filter-select {
  width: 210px;
  min-width: 0;
  height: 46px;
  padding: 0 14px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  background: var(--soft);
  color: var(--text);
  font: inherit;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  outline: 0;
  transition: all 0.25s var(--ease);
}

.filter-select:hover { border-color: #c7d2fe; }

.filter-select:focus {
  background: #fff;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

/* =========================================================
   BẢNG
   ========================================================= */
.table-wrapper {
  overflow-x: auto;
  width: 100%;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  text-align: left;
}

.content-card > .table-wrapper > table {
  min-width: 1100px;
}

thead th {
  padding: 15px;
  background: linear-gradient(180deg, #eef2ff, #e0e7ff);
  color: #3730a3;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  white-space: nowrap;
}

thead th:first-child { padding-left: 26px; }
tbody td:first-child { padding-left: 26px; }

tbody td {
  padding: 15px;
  border-bottom: 1px solid #eef2f7;
  color: #475569;
  font-size: 12.5px;
  vertical-align: middle;
  transition: background 0.25s;
}

tbody tr:last-child td { border-bottom: 0; }
tbody tr:hover td { background: #f5f7ff; }
.content-card tbody tr:hover td:first-child { box-shadow: inset 4px 0 0 var(--primary); }

.order-code {
  display: inline-flex;
  padding: 6px 11px;
  border-radius: 8px;
  color: #4338ca;
  background: #e0e7ff;
  font-weight: 800;
  white-space: nowrap;
}

.customer-name {
  max-width: 190px;
  overflow: hidden;
  color: var(--navy);
  font-weight: 700;
  text-overflow: ellipsis;
  white-space: nowrap;
  transition: color 0.2s;
}

tbody tr:hover .customer-name { color: var(--primary); }

.sub-text {
  margin-top: 5px;
  color: #94a3b8;
  font-size: 11px;
}

.date-cell {
  color: var(--muted);
  white-space: nowrap;
}

.price-cell {
  color: #4f46e5;
  font-size: 13px;
  font-weight: 800;
  white-space: nowrap;
}

/* =========================================================
   TRẠNG THÁI ĐƠN
   ========================================================= */
.status-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
}

.status-badge::before {
  content: "";
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: currentColor;
}

.status-ChoXacNhan {
  color: #b45309;
  background: #fef3c7;
}

.status-ChoXacNhan::before { animation: pulseDot 1.4s ease-in-out infinite; }

.status-DaXacNhan {
  color: #1d4ed8;
  background: #dbeafe;
}

.status-DangGiao {
  color: #7e22ce;
  background: #f3e8ff;
}

.status-DangGiao::before { animation: pulseDot 1.8s ease-in-out infinite; }

.status-DaGiao {
  color: #047857;
  background: #d1fae5;
}

.status-DaHuy {
  color: #be123c;
  background: #ffe4e6;
}

.status-unknown {
  color: #475569;
  background: #e2e8f0;
}

.cancel-reason-preview {
  max-width: 200px;
  margin-top: 7px;
  padding: 5px 9px;
  border-left: 3px solid #f43f5e;
  border-radius: 0 8px 8px 0;
  color: #be123c;
  background: #fff1f2;
  font-size: 11px;
  line-height: 1.45;
  overflow-wrap: anywhere;
}

/* =========================================================
   THAO TÁC
   ========================================================= */
.action-buttons {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
  gap: 7px;
  min-width: 290px;
}

.empty-cell {
  padding: 48px 15px;
  text-align: center;
  color: #94a3b8;
}

/* =========================================================
   MODAL CHI TIẾT
   ========================================================= */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 1000;
  display: grid;
  place-items: center;
  padding: 20px;
  background: rgba(15, 23, 42, 0.55);
  backdrop-filter: blur(4px);
  animation: overlayIn 0.25s ease both;
}

.detail-modal {
  width: min(840px, 100%);
  max-height: 90vh;
  overflow-y: auto;
  padding: 0 26px 26px;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 30px 80px rgba(15, 23, 42, 0.3);
  animation: modalIn 0.4s var(--ease) both;
}

.modal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  margin: 0 -26px;
  padding: 24px 26px;
  background: var(--grad-primary);
}

.modal-header h2 {
  margin: 0 0 7px;
  color: #fff;
  font-size: 21px;
  font-weight: 800;
}

.modal-header p {
  color: rgba(255, 255, 255, 0.85);
}

.close-button {
  display: grid;
  place-items: center;
  flex: 0 0 36px;
  width: 36px;
  height: 36px;
  border: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  color: #fff;
  font-size: 24px;
  line-height: 1;
  cursor: pointer;
  transition: transform 0.3s var(--ease), background 0.2s;
}

.close-button:hover {
  background: rgba(255, 255, 255, 0.35);
  transform: rotate(90deg);
}

.modal-status {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 4px;
  padding: 18px 0;
  border-bottom: 1px solid var(--line);
}

.detail-modal h3 {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 24px 0 14px;
  color: var(--navy);
  font-size: 15px;
  font-weight: 800;
}

.detail-modal h3::before {
  content: "";
  width: 4px;
  height: 18px;
  border-radius: 4px;
  background: var(--grad-primary);
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
}

.detail-item {
  min-width: 0;
  padding: 13px 15px;
  border: 1px solid var(--line);
  border-radius: 12px;
  background: #f8fafc;
  transition: all 0.25s var(--ease);
}

.detail-item:hover {
  border-color: #c7d2fe;
  background: #f5f7ff;
  transform: translateY(-2px);
}

.detail-item span {
  display: block;
  margin-bottom: 6px;
  color: var(--primary);
  font-size: 10.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.detail-item strong {
  display: block;
  color: var(--navy);
  font-size: 13px;
  font-weight: 700;
  overflow-wrap: anywhere;
}

.full-width { grid-column: 1 / -1; }

/* khu vực thông tin hủy đơn */
.cancel-info-section {
  margin-top: 6px;
  padding: 2px 18px 18px;
  border: 1px solid #fecdd3;
  border-radius: 14px;
  background: linear-gradient(180deg, #fff1f2, #fff);
}

.cancel-info-section h3::before {
  background: var(--grad-danger);
}

.cancel-info-section .detail-item {
  border-color: #fecdd3;
  background: #fff;
}

.cancel-info-section .detail-item span { color: #be123c; }

/* bảng sản phẩm */
.detail-products {
  overflow-x: auto;
  border: 1px solid var(--line);
  border-radius: 14px;
}

.detail-products table { min-width: 540px; }

.detail-products thead th:first-child,
.detail-products tbody td:first-child { padding-left: 15px; }

.product-cell {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 150px;
}

.product-cell img {
  width: 46px;
  height: 46px;
  flex: 0 0 46px;
  object-fit: contain;
  border: 1px solid var(--line);
  border-radius: 10px;
  background: #fff;
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}

.detail-products tbody tr:hover .product-cell img {
  transform: scale(1.12);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.2);
}

.product-cell span {
  color: var(--navy);
  font-weight: 700;
}

.modal-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
  margin-top: 20px;
  padding: 18px 20px;
  border: 1px solid #c7d2fe;
  border-radius: 14px;
  background: linear-gradient(135deg, #eef2ff, #f8faff);
}

.modal-total span {
  color: var(--muted);
  font-size: 13px;
  font-weight: 700;
}

.modal-total strong {
  font-size: 24px;
  font-weight: 800;
  background: var(--grad-primary);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 9px;
  margin-top: 18px;
  padding-top: 18px;
  border-top: 1px solid var(--line);
}

.modal-footer .btn { min-height: 42px; padding: 0 18px; font-size: 13px; }

/* thanh cuộn gọn */
.table-wrapper::-webkit-scrollbar,
.detail-products::-webkit-scrollbar,
.detail-modal::-webkit-scrollbar { width: 8px; height: 8px; }

.table-wrapper::-webkit-scrollbar-thumb,
.detail-products::-webkit-scrollbar-thumb,
.detail-modal::-webkit-scrollbar-thumb { border-radius: 8px; background: #c7d2fe; }

.table-wrapper::-webkit-scrollbar-thumb:hover,
.detail-products::-webkit-scrollbar-thumb:hover,
.detail-modal::-webkit-scrollbar-thumb:hover { background: #818cf8; }

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 1100px) {
  .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 650px) {
  .qldh-page { padding: 15px; }

  .page-header { align-items: flex-start; flex-direction: column; }
  .page-header h1 { font-size: 24px; }

  .stats-grid { gap: 10px; }
  .stat-card { padding: 13px; gap: 10px; min-height: 92px; }
  .stat-icon { flex-basis: 40px; width: 40px; height: 40px; border-radius: 12px; font-size: 18px; }
  .stat-card h2 { font-size: 22px; }

  .section-heading { padding: 20px 15px 14px; }

  .toolbar {
    align-items: stretch;
    flex-direction: column;
    padding-right: 14px;
    padding-left: 14px;
  }

  .filter-select { width: 100%; }

  .detail-modal { padding: 0 18px 20px; }
  .modal-header { margin: 0 -18px; padding: 20px 18px; }
  .detail-grid { grid-template-columns: 1fr; }
  .full-width { grid-column: auto; }
}

/* Tôn trọng người dùng tắt hiệu ứng chuyển động */
@media (prefers-reduced-motion: reduce) {
  .qldh-page *,
  .qldh-page *::before,
  .qldh-page *::after {
    animation: none !important;
    transition: none !important;
  }
}
</style>