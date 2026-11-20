
<template>
  <div class="voucher-page">
    <!-- TIÊU ĐỀ -->
    <div class="page-heading">
      <div>
        <div class="breadcrumb">Quản lý / Voucher</div>
        <h1>Quản lý voucher</h1>
        <p>Quản lý mã giảm giá và thời hạn sử dụng của cửa hàng.</p>
      </div>

      <button class="btn-primary" @click="openAddModal">
        <i class="fa-solid fa-plus"></i>
        Thêm voucher
      </button>
    </div>

    <!-- THỐNG KÊ -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon blue">
          <i class="fa-solid fa-ticket"></i>
        </div>
        <div>
          <div class="stat-label">Tổng voucher</div>
          <div class="stat-number">{{ vouchers.length }}</div>
          <div class="stat-note">Voucher trong hệ thống</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon green">
          <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
          <div class="stat-label">Đang sử dụng</div>
          <div class="stat-number">{{ activeCount }}</div>
          <div class="stat-note">Còn hạn và đang hoạt động</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon orange">
          <i class="fa-regular fa-clock"></i>
        </div>
        <div>
          <div class="stat-label">Đã hết hạn</div>
          <div class="stat-number">{{ expiredCount }}</div>
          <div class="stat-note">Quá ngày sử dụng</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon purple">
          <i class="fa-solid fa-ban"></i>
        </div>
        <div>
          <div class="stat-label">Đã ngừng</div>
          <div class="stat-number">{{ inactiveCount }}</div>
          <div class="stat-note">Không còn hoạt động</div>
        </div>
      </div>
    </div>

    <!-- DANH SÁCH -->
    <section class="content-card">
      <div class="list-heading">
        <div>
          <h2>Danh sách voucher</h2>
          <p>Tra cứu mã giảm giá, giá trị giảm và hạn sử dụng.</p>
        </div>

        <span class="result-count">
          {{ filteredVouchers.length }} kết quả
        </span>
      </div>

      <!-- TÌM KIẾM VÀ BỘ LỌC -->
      <div class="filter-bar">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass search-icon"></i>

          <input
            v-model.trim="keyword"
            type="text"
            placeholder="Tìm mã voucher hoặc mã số..."
          />

          <button
            v-if="keyword"
            class="clear-search"
            title="Xóa tìm kiếm"
            @click="keyword = ''"
          >
            ×
          </button>
        </div>

        <div class="filter-tabs">
          <button
            v-for="item in filterOptions"
            :key="item.value"
            :class="{ active: statusFilter === item.value }"
            @click="statusFilter = item.value"
          >
            {{ item.label }}
          </button>
        </div>

        <button
          class="btn-secondary"
          :disabled="loading"
          @click="loadVouchers"
        >
          <i class="fa-solid fa-rotate-right" :class="{ 'fa-spin': loading }"></i>
          Làm mới
        </button>
      </div>

      <!-- ĐANG TẢI -->
      <div v-if="loading" class="state-box">
        <i class="fa-solid fa-spinner fa-spin"></i>
        <strong>Đang tải voucher...</strong>
      </div>

      <!-- LỖI -->
      <div v-else-if="error" class="state-box error-state">
        <i class="fa-solid fa-circle-exclamation"></i>
        <strong>{{ error }}</strong>
        <button class="btn-secondary" @click="loadVouchers">
          Thử lại
        </button>
      </div>

      <!-- KHÔNG CÓ KẾT QUẢ -->
      <div v-else-if="filteredVouchers.length === 0" class="state-box">
        <i class="fa-solid fa-ticket empty-icon"></i>
        <strong>
          {{ vouchers.length ? 'Không tìm thấy voucher phù hợp' : 'Chưa có voucher nào' }}
        </strong>
        <span>
          {{ vouchers.length
            ? 'Thử thay đổi từ khóa hoặc bộ lọc.'
            : 'Thêm voucher mới để dữ liệu xuất hiện tại đây.' }}
        </span>

        <button
          v-if="keyword || statusFilter !== 'all'"
          class="btn-secondary"
          @click="resetFilters"
        >
          Xóa bộ lọc
        </button>
      </div>

      <!-- BẢNG VOUCHER -->
      <div v-else class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>MÃ VOUCHER</th>
              <th>GIÁ TRỊ GIẢM</th>
              <th>NGÀY HẾT HẠN</th>
              <th>TRẠNG THÁI</th>
              <th class="center">THAO TÁC</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="item in filteredVouchers" :key="item.id">
              <td>
                <div class="voucher-code-cell">
                  <div class="voucher-icon">
                    <i class="fa-solid fa-ticket"></i>
                  </div>

                  <div>
                    <div class="voucher-code">{{ item.code }}</div>
                    <div class="voucher-id">Mã voucher #{{ item.id }}</div>
                  </div>
                </div>
              </td>

              <td>
                <span class="discount-value">
                  {{ formatDiscount(item.discount) }}%
                </span>
              </td>

              <td>
                <div class="date-cell">
                  <i class="fa-regular fa-calendar"></i>
                  {{ formatDate(item.expiryDate) }}
                </div>
                <div
                  v-if="getDisplayStatus(item) === 'expired'"
                  class="date-expired"
                >
                  Đã quá hạn
                </div>
              </td>

              <td>
                <span
                  class="status-badge"
                  :class="statusClass(item)"
                >
                  <span class="status-dot"></span>
                  {{ statusText(item) }}
                </span>
              </td>

              <td>
                <div class="action-group">
                  <button
                    class="action-btn view-btn"
                    title="Xem chi tiết"
                    @click="viewVoucher(item)"
                  >
                    <i class="fa-regular fa-eye"></i>
                  </button>

                  <button
                    class="action-btn edit-btn"
                    title="Chỉnh sửa"
                    @click="openEditModal(item)"
                  >
                    <i class="fa-regular fa-pen-to-square"></i>
                  </button>

                  <button
                    class="action-btn delete-btn"
                    title="Xóa voucher"
                    :disabled="busyId === item.id"
                    @click="askDelete(item)"
                  >
                    <i class="fa-regular fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="!loading && !error" class="table-footer">
        <span>
          Đang hiển thị <strong>{{ filteredVouchers.length }}</strong>
          / {{ vouchers.length }} voucher
        </span>

        <span class="database-note">
          <i class="fa-solid fa-database"></i>
          Dữ liệu từ database
        </span>
      </div>
    </section>

    <!-- FORM THÊM / SỬA -->
    <div
      v-if="showFormModal"
      class="modal-overlay"
      @click.self="closeFormModal"
    >
      <section class="modal-card">
        <div class="modal-heading">
          <div>
            <div class="eyebrow">
              {{ editingId ? 'CẬP NHẬT VOUCHER' : 'TẠO VOUCHER MỚI' }}
            </div>

            <h2>
              {{ editingId ? 'Chỉnh sửa voucher' : 'Thêm voucher' }}
            </h2>

            <p>
              {{
                editingId
                  ? 'Thay đổi thông tin mã giảm giá.'
                  : 'Nhập thông tin để tạo mã giảm giá mới.'
              }}
            </p>
          </div>

          <button class="modal-close" @click="closeFormModal">×</button>
        </div>

        <form @submit.prevent="saveVoucher">
          <div class="form-group">
            <label for="voucher-code">
              Mã giảm giá <span>*</span>
            </label>

            <input
              id="voucher-code"
              v-model.trim="form.MaGiamGia"
              type="text"
              placeholder="Ví dụ: WELCOME10"
              maxlength="50"
              autocomplete="off"
              required
            />

            <small>Mã khách nhập tại bước đặt hàng.</small>
          </div>

          <div class="form-group">
            <label for="voucher-discount">
              Giá trị giảm (%) <span>*</span>
            </label>

            <div class="discount-input">
              <input
                id="voucher-discount"
                v-model.number="form.GiaTriGiam"
                type="number"
                min="0.01"
                max="100"
                step="0.01"
                placeholder="10"
                required
              />
              <span>%</span>
            </div>

            <small>Ví dụ: nhập 10 để giảm 10% tổng tiền hàng.</small>
          </div>

          <div class="form-group">
            <label for="voucher-expiry">
              Ngày hết hạn <span>*</span>
            </label>

            <input
              id="voucher-expiry"
              v-model="form.NgayHetHan"
              type="date"
              required
            />
          </div>

          <div class="form-group">
            <label for="voucher-status">Trạng thái</label>

            <select id="voucher-status" v-model="form.TrangThai">
              <option value="DangSuDung">Đang sử dụng</option>
              <option value="NgungSuDung">Ngừng sử dụng</option>
            </select>
          </div>

          <div v-if="formError" class="form-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ formError }}
          </div>

          <div class="modal-actions">
            <button
              type="button"
              class="btn-secondary"
              :disabled="saving"
              @click="closeFormModal"
            >
              Hủy
            </button>

            <button type="submit" class="btn-primary" :disabled="saving">
              <i v-if="saving" class="fa-solid fa-spinner fa-spin"></i>
              {{ saving
                ? 'Đang lưu...'
                : editingId
                  ? 'Lưu thay đổi'
                  : 'Tạo voucher' }}
            </button>
          </div>
        </form>
      </section>
    </div>

    <!-- XEM CHI TIẾT -->
    <div
      v-if="selectedVoucher"
      class="modal-overlay"
      @click.self="selectedVoucher = null"
    >
      <section class="modal-card detail-modal">
        <div class="modal-heading">
          <div>
            <div class="eyebrow">CHI TIẾT VOUCHER #{{ selectedVoucher.id }}</div>
            <h2>{{ selectedVoucher.code }}</h2>
            <p>Thông tin voucher trong hệ thống.</p>
          </div>

          <button class="modal-close" @click="selectedVoucher = null">×</button>
        </div>

        <div class="coupon-preview">
          <div class="coupon-symbol">
            <i class="fa-solid fa-ticket"></i>
          </div>

          <div>
            <small>MÃ GIẢM GIÁ</small>
            <strong>{{ selectedVoucher.code }}</strong>
            <span>TECHSHOP</span>
          </div>

          <div class="coupon-discount">
            {{ formatDiscount(selectedVoucher.discount) }}<small>% OFF</small>
          </div>
        </div>

        <div class="detail-grid">
          <div class="detail-item">
            <span>Mã voucher</span>
            <strong>#{{ selectedVoucher.id }}</strong>
          </div>

          <div class="detail-item">
            <span>Giá trị giảm</span>
            <strong>{{ formatDiscount(selectedVoucher.discount) }}%</strong>
          </div>

          <div class="detail-item">
            <span>Ngày hết hạn</span>
            <strong>{{ formatDate(selectedVoucher.expiryDate) }}</strong>
          </div>

          <div class="detail-item">
            <span>Trạng thái</span>
            <strong :class="statusClass(selectedVoucher)">
              {{ statusText(selectedVoucher) }}
            </strong>
          </div>
        </div>

        <div class="modal-actions">
          <button class="btn-secondary" @click="selectedVoucher = null">
            Đóng
          </button>

          <button
            class="btn-primary"
            @click="editSelectedVoucher"
          >
            <i class="fa-regular fa-pen-to-square"></i>
            Chỉnh sửa
          </button>
        </div>
      </section>
    </div>

    <!-- XÁC NHẬN XÓA -->
    <div
      v-if="voucherToDelete"
      class="modal-overlay"
      @click.self="voucherToDelete = null"
    >
      <section class="modal-card confirm-modal">
        <div class="confirm-icon">
          <i class="fa-regular fa-trash-can"></i>
        </div>

        <h2>Xóa voucher?</h2>

        <p>
          Bạn có chắc muốn xóa mã
          <strong>{{ voucherToDelete.code }}</strong>?
          Thao tác này sẽ xóa dữ liệu voucher trong database.
        </p>

        <div class="modal-actions centered-actions">
          <button
            class="btn-secondary"
            :disabled="deleting"
            @click="voucherToDelete = null"
          >
            Hủy
          </button>

          <button
            class="btn-danger"
            :disabled="deleting"
            @click="deleteVoucher"
          >
            <i v-if="deleting" class="fa-solid fa-spinner fa-spin"></i>
            {{ deleting ? 'Đang xóa...' : 'Xác nhận xóa' }}
          </button>
        </div>
      </section>
    </div>

    <!-- THÔNG BÁO -->
    <transition name="toast">
      <div
        v-if="toast"
        class="toast-message"
        :class="{ 'toast-error': toastType === 'error' }"
      >
        <span>
          <i
            :class="toastType === 'error'
              ? 'fa-solid fa-circle-exclamation'
              : 'fa-solid fa-check'"
          ></i>
        </span>
        {{ toast }}
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";

const API = "http://127.0.0.1:8000/api";

export default {
  name: "QuanLyVoucher",

  data() {
    return {
      vouchers: [],
      loading: false,
      error: "",

      keyword: "",
      statusFilter: "all",

      showFormModal: false,
      editingId: null,
      selectedVoucher: null,
      voucherToDelete: null,

      saving: false,
      deleting: false,
      busyId: null,

      formError: "",
      toast: "",
      toastType: "success",
      toastTimer: null,

      filterOptions: [
        { label: "Tất cả", value: "all" },
        { label: "Đang sử dụng", value: "active" },
        { label: "Đã hết hạn", value: "expired" },
        { label: "Đã ngừng", value: "inactive" }
      ],

      form: {
        MaGiamGia: "",
        GiaTriGiam: 10,
        NgayHetHan: "",
        TrangThai: "DangSuDung"
      }
    };
  },

  computed: {
    activeCount() {
      return this.vouchers.filter(
        item => this.getDisplayStatus(item) === "active"
      ).length;
    },

    expiredCount() {
      return this.vouchers.filter(
        item => this.getDisplayStatus(item) === "expired"
      ).length;
    },

    inactiveCount() {
      return this.vouchers.filter(
        item => this.getDisplayStatus(item) === "inactive"
      ).length;
    },

    filteredVouchers() {
      const keyword = this.removeDiacritics(
        this.keyword.toLowerCase()
      );

      return this.vouchers.filter(item => {
        const searchable = this.removeDiacritics(
          `${item.id} ${item.code}`.toLowerCase()
        );

        const matchesKeyword =
          !keyword || searchable.includes(keyword);

        const status = this.getDisplayStatus(item);

        const matchesStatus =
          this.statusFilter === "all" ||
          this.statusFilter === status;

        return matchesKeyword && matchesStatus;
      });
    }
  },

  mounted() {
    this.loadVouchers();
  },

  beforeUnmount() {
    clearTimeout(this.toastTimer);
  },

  methods: {
    // Token đăng nhập quản trị
    getConfig() {
      const token =
        localStorage.getItem("admin_token") ||
        localStorage.getItem("adminToken") ||
        localStorage.getItem("token");

      if (!token) {
        throw new Error(
          "Không tìm thấy token. Bạn hãy đăng nhập lại tài khoản quản trị."
        );
      }

      return {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json"
        }
      };
    },

    removeDiacritics(value) {
      return String(value || "")
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/đ/g, "d")
        .replace(/Đ/g, "D");
    },

    normalizeVoucher(item) {
      return {
        id: item.MaVoucher,
        code: item.MaGiamGia || "",
        discount: Number(item.GiaTriGiam || 0),
        expiryDate: item.NgayHetHan
          ? String(item.NgayHetHan).slice(0, 10)
          : "",
        rawStatus: item.TrangThai || "DangSuDung"
      };
    },

    // Dùng định dạng ngày YYYY-MM-DD để so sánh,
    // tránh nhầm ngày do múi giờ.
    getDisplayStatus(item) {
      const today = new Date();
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1).padStart(2, "0");
      const day = String(today.getDate()).padStart(2, "0");
      const todayString = `${year}-${month}-${day}`;

      if (
        item.expiryDate &&
        item.expiryDate < todayString
      ) {
        return "expired";
      }

      return item.rawStatus === "DangSuDung"
        ? "active"
        : "inactive";
    },

    statusText(item) {
      const status = this.getDisplayStatus(item);

      if (status === "active") return "Đang sử dụng";
      if (status === "expired") return "Đã hết hạn";
      return "Đã ngừng";
    },

    statusClass(item) {
      const status = this.getDisplayStatus(item);

      if (status === "active") return "status-active";
      if (status === "expired") return "status-expired";
      return "status-inactive";
    },

    formatDate(value) {
      if (!value) return "—";

      const parts = String(value).slice(0, 10).split("-");

      if (parts.length !== 3) return value;

      return `${parts[2]}/${parts[1]}/${parts[0]}`;
    },

    formatDiscount(value) {
      return Number(value).toLocaleString("vi-VN", {
        maximumFractionDigits: 2
      });
    },

    async loadVouchers() {
      this.loading = true;
      this.error = "";

      try {
        const response = await axios.get(
          `${API}/voucher/get-data`,
          this.getConfig()
        );

        if (response.data.status !== true) {
          throw new Error(
            response.data.message || "Không lấy được danh sách voucher."
          );
        }

        const data = Array.isArray(response.data.data)
          ? response.data.data
          : [];

        this.vouchers = data.map(item =>
          this.normalizeVoucher(item)
        );
      } catch (error) {
        console.error(
          "Lỗi lấy voucher:",
          error.response?.data || error
        );

        this.error =
          error.response?.data?.message ||
          error.message ||
          "Không thể tải danh sách voucher.";

        this.showToast(this.error, "error");
      } finally {
        this.loading = false;
      }
    },

    openAddModal() {
      this.editingId = null;
      this.formError = "";

      this.form = {
        MaGiamGia: "",
        GiaTriGiam: 10,
        NgayHetHan: "",
        TrangThai: "DangSuDung"
      };

      this.showFormModal = true;
    },

    openEditModal(item) {
      this.editingId = item.id;
      this.formError = "";

      this.form = {
        MaGiamGia: item.code,
        GiaTriGiam: item.discount,
        NgayHetHan: item.expiryDate,
        TrangThai: item.rawStatus
      };

      this.selectedVoucher = null;
      this.showFormModal = true;
    },

    viewVoucher(item) {
      this.selectedVoucher = { ...item };
    },

    editSelectedVoucher() {
      if (!this.selectedVoucher) return;

      const item = this.vouchers.find(
        voucher => voucher.id === this.selectedVoucher.id
      );

      if (item) this.openEditModal(item);
    },

    closeFormModal() {
      if (this.saving) return;

      this.showFormModal = false;
      this.formError = "";
    },

    validateForm() {
      const code = this.form.MaGiamGia.trim();
      const discount = Number(this.form.GiaTriGiam);
      const expiryDate = this.form.NgayHetHan;

      if (!code) {
        this.formError = "Vui lòng nhập mã giảm giá.";
        return false;
      }

      if (!Number.isFinite(discount) || discount <= 0 || discount > 100) {
        this.formError = "Giá trị giảm phải lớn hơn 0 và không quá 100%.";
        return false;
      }

      if (!expiryDate) {
        this.formError = "Vui lòng chọn ngày hết hạn.";
        return false;
      }

      // Không ép ngày hết hạn phải ở tương lai,
      // vì đôi khi quản trị viên cần sửa voucher đã hết hạn.
      return true;
    },

    async saveVoucher() {
      this.formError = "";

      if (!this.validateForm()) return;

      this.saving = true;

      const payload = {
        MaGiamGia: this.form.MaGiamGia.trim().toUpperCase(),
        GiaTriGiam: Number(this.form.GiaTriGiam),
        NgayHetHan: this.form.NgayHetHan,
        TrangThai: this.form.TrangThai
      };

      try {
        let response;

        if (this.editingId !== null) {
          // Controller hiện tại đọc khóa voucher qua request->id.
          response = await axios.put(
            `${API}/voucher/update`,
            {
              id: this.editingId,
              ...payload
            },
            this.getConfig()
          );
        } else {
          response = await axios.post(
            `${API}/voucher/add-data`,
            payload,
            this.getConfig()
          );
        }

        if (response.data.status !== true) {
          throw new Error(
            response.data.message || "Không thể lưu voucher."
          );
        }

        const editing = this.editingId !== null;

        this.showFormModal = false;

        this.showToast(
          editing
            ? "Cập nhật voucher thành công."
            : "Thêm voucher thành công."
        );

        await this.loadVouchers();
      } catch (error) {
        console.error(
          "Lỗi lưu voucher:",
          error.response?.data || error
        );

        const validationErrors = error.response?.data?.errors;
        const firstValidationError = validationErrors
          ? Object.values(validationErrors).flat()[0]
          : null;

        this.formError =
          firstValidationError ||
          error.response?.data?.message ||
          error.message ||
          "Không thể lưu voucher.";

        this.showToast(this.formError, "error");
      } finally {
        this.saving = false;
      }
    },

    askDelete(item) {
      this.voucherToDelete = { ...item };
    },

    async deleteVoucher() {
      if (!this.voucherToDelete || this.deleting) return;

      this.deleting = true;
      this.busyId = this.voucherToDelete.id;

      try {
        const response = await axios.delete(
          `${API}/voucher/delete`,
          {
            ...this.getConfig(),
            data: {
              id: this.voucherToDelete.id
            }
          }
        );

        if (response.data.status !== true) {
          throw new Error(
            response.data.message || "Xóa voucher thất bại."
          );
        }

        const deletedId = this.voucherToDelete.id;

        if (this.selectedVoucher?.id === deletedId) {
          this.selectedVoucher = null;
        }

        this.voucherToDelete = null;

        this.showToast("Xóa voucher thành công.");
        await this.loadVouchers();
      } catch (error) {
        console.error(
          "Lỗi xóa voucher:",
          error.response?.data || error
        );

        this.showToast(
          error.response?.data?.message ||
          error.message ||
          "Không thể xóa voucher.",
          "error"
        );
      } finally {
        this.deleting = false;
        this.busyId = null;
      }
    },

    resetFilters() {
      this.keyword = "";
      this.statusFilter = "all";
    },

    showToast(message, type = "success") {
      this.toast = message;
      this.toastType = type;

      clearTimeout(this.toastTimer);

      this.toastTimer = setTimeout(() => {
        this.toast = "";
      }, 3500);
    }
  }
};
</script>
<style scoped>
/* =========================================================
   BẢNG MÀU & BIẾN DÙNG CHUNG
   ========================================================= */
.voucher-page {
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

  width: 100%;
  min-width: 0;
  padding: 4px 2px 24px;
  color: var(--text);
  font-family: "Roboto", "Inter", Arial, sans-serif;
}

.voucher-page * {
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

@keyframes overlayIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes modalIn {
  from { opacity: 0; transform: translateY(28px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes couponIn {
  from { opacity: 0; transform: rotate(-3deg) scale(0.92); }
  to { opacity: 1; transform: rotate(0) scale(1); }
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

.page-heading { animation: fadeUp 0.5s var(--ease) both; }

.stat-card { animation: fadeUp 0.55s var(--ease) both; }
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.12s; }
.stat-card:nth-child(3) { animation-delay: 0.19s; }
.stat-card:nth-child(4) { animation-delay: 0.26s; }

.content-card { animation: fadeUp 0.6s var(--ease) 0.3s both; }

tbody tr { animation: rowIn 0.4s var(--ease) both; }
tbody tr:nth-child(1) { animation-delay: 0.04s; }
tbody tr:nth-child(2) { animation-delay: 0.08s; }
tbody tr:nth-child(3) { animation-delay: 0.12s; }
tbody tr:nth-child(4) { animation-delay: 0.16s; }
tbody tr:nth-child(5) { animation-delay: 0.2s; }
tbody tr:nth-child(6) { animation-delay: 0.24s; }
tbody tr:nth-child(7) { animation-delay: 0.28s; }
tbody tr:nth-child(8) { animation-delay: 0.32s; }

/* =========================================================
   TIÊU ĐỀ
   ========================================================= */
.page-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 26px;
}

.breadcrumb {
  display: inline-flex;
  margin-bottom: 10px;
  padding: 4px 12px;
  border-radius: 999px;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 12px;
  font-weight: 700;
}

.page-heading h1 {
  margin: 0;
  font-size: clamp(25px, 2.2vw, 30px);
  font-weight: 800;
  letter-spacing: -0.4px;
  background: linear-gradient(90deg, #0f172a 0%, #4f46e5 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.page-heading p {
  margin: 8px 0 0;
  color: var(--muted);
  font-size: 14px;
}

/* =========================================================
   NÚT
   ========================================================= */
.btn-primary,
.btn-secondary,
.btn-danger {
  position: relative;
  overflow: hidden;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  min-height: 42px;
  padding: 0 18px;
  border: 0;
  border-radius: 11px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease),
    background 0.25s, border-color 0.25s;
}

.btn-primary {
  color: #fff;
  background: var(--grad-primary);
  background-size: 140% 140%;
  background-position: 0% 50%;
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
}

.btn-danger {
  color: #fff;
  background: var(--grad-danger);
  box-shadow: 0 8px 18px rgba(244, 63, 94, 0.3);
}

.btn-primary::after,
.btn-danger::after {
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

.btn-primary:hover:not(:disabled),
.btn-danger:hover:not(:disabled) {
  transform: translateY(-2px);
}

.btn-primary:hover:not(:disabled) {
  background-position: 100% 50%;
  box-shadow: 0 12px 26px rgba(79, 70, 229, 0.42);
}

.btn-danger:hover:not(:disabled) {
  box-shadow: 0 12px 26px rgba(244, 63, 94, 0.42);
}

.btn-primary:hover:not(:disabled)::after,
.btn-danger:hover:not(:disabled)::after {
  animation: shine 0.8s var(--ease);
}

.btn-primary:active:not(:disabled),
.btn-danger:active:not(:disabled) {
  transform: scale(0.97);
}

.btn-secondary {
  border: 1.5px solid var(--line);
  color: #475569;
  background: #fff;
}

.btn-secondary:hover:not(:disabled) {
  color: var(--primary);
  border-color: #c7d2fe;
  background: #eef2ff;
  transform: translateY(-2px);
}

.btn-primary:disabled,
.btn-danger:disabled,
.btn-secondary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
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
  min-height: 112px;
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
.stat-card:nth-child(2) { --tone: #10b981; --tone-soft: rgba(16, 185, 129, 0.12); }
.stat-card:nth-child(3) { --tone: #f59e0b; --tone-soft: rgba(245, 158, 11, 0.13); }
.stat-card:nth-child(4) { --tone: #a855f7; --tone-soft: rgba(168, 85, 247, 0.12); }

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
  display: flex;
  align-items: center;
  justify-content: center;
  width: 54px;
  height: 54px;
  flex-shrink: 0;
  border-radius: 16px;
  color: #fff;
  font-size: 21px;
  transition: transform 0.35s var(--ease);
}

.stat-card:hover .stat-icon { transform: rotate(-8deg) scale(1.1); }

.blue {
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  box-shadow: 0 8px 16px rgba(79, 70, 229, 0.35);
}

.green {
  color: #fff;
  background: linear-gradient(135deg, #34d399, #059669);
  box-shadow: 0 8px 16px rgba(16, 185, 129, 0.35);
}

.orange {
  color: #fff;
  background: linear-gradient(135deg, #fbbf24, #f97316);
  box-shadow: 0 8px 16px rgba(245, 158, 11, 0.38);
}

.purple {
  color: #fff;
  background: linear-gradient(135deg, #c084fc, #9333ea);
  box-shadow: 0 8px 16px rgba(168, 85, 247, 0.35);
}

.stat-label {
  margin-bottom: 6px;
  color: var(--muted);
  font-size: 12px;
  font-weight: 600;
}

.stat-number {
  color: var(--navy);
  font-size: 28px;
  font-weight: 800;
  line-height: 1.1;
}

.stat-note {
  margin-top: 6px;
  color: #94a3b8;
  font-size: 11px;
}

/* =========================================================
   KHUNG DANH SÁCH
   ========================================================= */
.content-card {
  overflow: hidden;
  border: 1px solid var(--line);
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
}

.list-heading {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
  padding: 24px 26px 20px;
}

.list-heading h2 {
  margin: 0;
  color: var(--navy);
  font-size: 18px;
  font-weight: 800;
}

.list-heading p {
  margin: 6px 0 0;
  color: var(--muted);
  font-size: 12.5px;
}

.result-count {
  padding: 8px 14px;
  border-radius: 999px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 6px 14px rgba(79, 70, 229, 0.3);
  font-size: 12px;
  font-weight: 700;
  white-space: nowrap;
}

/* =========================================================
   TÌM KIẾM / LỌC
   ========================================================= */
.filter-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 16px 26px;
  border-top: 1px solid var(--line);
  border-bottom: 1px solid var(--line);
  background: #f8fafc;
}

.search-box {
  display: flex;
  align-items: center;
  width: min(350px, 100%);
  min-height: 46px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  color: var(--muted);
  background: #fff;
  transition: all 0.25s var(--ease);
}

.search-box:hover { border-color: #c7d2fe; }

.search-box:focus-within {
  color: var(--primary);
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.search-icon {
  margin: 0 10px 0 14px;
  font-size: 13px;
}

.search-box input {
  width: 100%;
  min-width: 0;
  height: 42px;
  padding: 0 8px 0 0;
  border: 0;
  outline: 0;
  color: var(--navy);
  background: transparent;
  font-size: 13px;
}

.search-box input::placeholder { color: #94a3b8; }

.clear-search {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  margin-right: 10px;
  padding: 0;
  border: 0;
  border-radius: 50%;
  color: #64748b;
  background: #e2e8f0;
  font-size: 17px;
  line-height: 1;
  cursor: pointer;
  transition: all 0.2s;
}

.clear-search:hover {
  color: #fff;
  background: #f43f5e;
  transform: rotate(90deg);
}

.filter-tabs {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
  padding: 4px;
  border: 1px solid var(--line);
  border-radius: 12px;
  background: var(--soft);
}

.filter-tabs button {
  padding: 9px 14px;
  border: 0;
  border-radius: 9px;
  color: var(--muted);
  background: transparent;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.25s var(--ease);
}

.filter-tabs button:hover:not(.active) {
  color: var(--primary);
  background: #e0e7ff;
}

.filter-tabs button.active {
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.35);
}

/* =========================================================
   BẢNG
   ========================================================= */
.table-wrapper {
  width: 100%;
  overflow-x: auto;
}

table {
  width: 100%;
  min-width: 860px;
  border-collapse: separate;
  border-spacing: 0;
  text-align: left;
}

thead th {
  padding: 15px 18px;
  color: #3730a3;
  background: linear-gradient(180deg, #eef2ff, #e0e7ff);
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 0.4px;
  white-space: nowrap;
}

thead th:first-child,
tbody td:first-child { padding-left: 26px; }

tbody td {
  padding: 17px 18px;
  border-bottom: 1px solid #eef2f7;
  color: #475569;
  font-size: 12.5px;
  vertical-align: middle;
  transition: background 0.25s;
}

tbody tr:hover td { background: #f5f7ff; }
tbody tr:hover td:first-child { box-shadow: inset 4px 0 0 var(--primary); }
tbody tr:last-child td { border-bottom: 0; }

.center { text-align: center !important; }

/* mã voucher */
.voucher-code-cell {
  display: flex;
  align-items: center;
  gap: 13px;
  min-width: 200px;
}

.voucher-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  flex-shrink: 0;
  border-radius: 13px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
  font-size: 17px;
  transition: transform 0.35s var(--ease);
}

tbody tr:hover .voucher-icon {
  transform: rotate(-12deg) scale(1.1);
}

.voucher-code {
  color: var(--navy);
  font-size: 13.5px;
  font-weight: 800;
  letter-spacing: 0.04em;
  transition: color 0.2s;
}

tbody tr:hover .voucher-code { color: var(--primary); }

.voucher-id {
  margin-top: 5px;
  color: #94a3b8;
  font-size: 10.5px;
}

/* giá trị giảm: dạng tem vé */
.discount-value {
  display: inline-flex;
  align-items: center;
  padding: 8px 14px;
  border: 1.5px dashed #f59e0b;
  border-radius: 10px;
  color: #b45309;
  background: linear-gradient(135deg, #fffbeb, #fef3c7);
  box-shadow: 0 4px 10px rgba(245, 158, 11, 0.18);
  font-size: 14px;
  font-weight: 800;
  white-space: nowrap;
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}

tbody tr:hover .discount-value {
  transform: scale(1.08) rotate(-2deg);
  box-shadow: 0 8px 16px rgba(245, 158, 11, 0.3);
}

.date-cell {
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--muted);
  white-space: nowrap;
}

.date-cell i { color: var(--primary); }

.date-expired {
  margin-top: 5px;
  color: #e11d48;
  font-size: 11px;
  font-weight: 700;
}

/* trạng thái */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
}

.status-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: currentColor;
}

.status-active {
  color: #047857;
  background: #d1fae5;
}

.status-active .status-dot { animation: pulseDot 1.8s ease-in-out infinite; }

.status-expired {
  color: #be123c;
  background: #ffe4e6;
}

.status-inactive {
  color: #475569;
  background: #e2e8f0;
}

/* thao tác */
.action-group {
  display: flex;
  justify-content: center;
  flex-wrap: nowrap;
  gap: 7px;
  min-width: 120px;
}

.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 34px;
  height: 34px;
  border: 0;
  border-radius: 10px;
  color: #fff;
  font-size: 13px;
  cursor: pointer;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
}

.view-btn {
  background: linear-gradient(135deg, #6366f1, #2563eb);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.3);
}

.edit-btn {
  background: var(--grad-warm);
  box-shadow: 0 5px 12px rgba(245, 158, 11, 0.32);
}

.delete-btn {
  background: var(--grad-danger);
  box-shadow: 0 5px 12px rgba(244, 63, 94, 0.3);
}

.action-btn:hover:not(:disabled) { transform: translateY(-3px) scale(1.08); }
.view-btn:hover:not(:disabled) { box-shadow: 0 10px 20px rgba(79, 70, 229, 0.45); }
.edit-btn:hover:not(:disabled) { box-shadow: 0 10px 20px rgba(245, 158, 11, 0.45); }
.delete-btn:hover:not(:disabled) { box-shadow: 0 10px 20px rgba(244, 63, 94, 0.45); }
.action-btn:active:not(:disabled) { transform: scale(0.92); }

.action-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
  box-shadow: none;
  filter: grayscale(0.4);
}

/* chân bảng */
.table-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 15px 26px;
  border-top: 1px solid var(--line);
  background: #f8fafc;
  color: var(--muted);
  font-size: 12px;
}

.table-footer strong { color: var(--primary); }

.database-note {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 5px 12px;
  border-radius: 999px;
  color: #047857;
  background: #d1fae5;
  font-weight: 700;
}

/* =========================================================
   TRẠNG THÁI TẢI / LỖI / TRỐNG
   ========================================================= */
.state-box {
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: 12px;
  padding: 52px 20px;
  color: var(--muted);
  text-align: center;
  font-size: 13px;
}

.state-box > i {
  font-size: 28px;
  color: var(--primary);
}

.state-box strong {
  color: var(--navy);
  font-size: 14px;
  font-weight: 800;
}

.empty-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 74px;
  height: 74px;
  border-radius: 50%;
  background: #e0e7ff;
  font-size: 30px !important;
}

.error-state { background: linear-gradient(180deg, #fff1f2, #fff); }
.error-state > i { color: #f43f5e; }
.error-state strong { color: #be123c; }

/* =========================================================
   MODAL
   ========================================================= */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 1100;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: rgba(15, 23, 42, 0.55);
  backdrop-filter: blur(4px);
  animation: overlayIn 0.25s ease both;
}

.modal-card {
  width: min(100%, 520px);
  max-height: 90vh;
  overflow-y: auto;
  padding: 0 26px 26px;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 30px 80px rgba(15, 23, 42, 0.3);
  animation: modalIn 0.4s var(--ease) both;
}

.detail-modal { width: min(100%, 580px); }

.modal-heading {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  margin: 0 -26px;
  padding: 24px 26px;
  color: #fff;
  background: var(--grad-primary);
}

.eyebrow {
  display: inline-block;
  margin-bottom: 8px;
  padding: 4px 10px;
  border-radius: 999px;
  color: #fff;
  background: rgba(255, 255, 255, 0.22);
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 0.4px;
}

.modal-heading h2 {
  margin: 0;
  color: #fff;
  font-size: 21px;
  font-weight: 800;
}

.modal-heading p {
  margin: 5px 0 0;
  color: rgba(255, 255, 255, 0.85);
  font-size: 12.5px;
}

.modal-close {
  flex-shrink: 0;
  width: 34px;
  height: 34px;
  border: 0;
  border-radius: 50%;
  color: #fff;
  background: rgba(255, 255, 255, 0.2);
  font-size: 22px;
  line-height: 1;
  cursor: pointer;
  transition: transform 0.3s var(--ease), background 0.2s;
}

.modal-close:hover {
  background: rgba(255, 255, 255, 0.35);
  transform: rotate(90deg);
}

/* =========================================================
   FORM
   ========================================================= */
.form-group { margin-top: 20px; }

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #334155;
  font-size: 12.5px;
  font-weight: 700;
}

.form-group label span { color: #f43f5e; }

.form-group input,
.form-group select {
  width: 100%;
  min-height: 46px;
  padding: 10px 14px;
  border: 1.5px solid var(--line);
  border-radius: 11px;
  outline: none;
  color: var(--navy);
  background: #f8fafc;
  font: inherit;
  font-size: 13px;
  transition: all 0.25s var(--ease);
}

.form-group input:hover,
.form-group select:hover { border-color: #c7d2fe; }

.form-group input:focus,
.form-group select:focus {
  border-color: var(--primary);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.form-group small {
  display: block;
  margin-top: 6px;
  color: #94a3b8;
  font-size: 11px;
}

.discount-input { position: relative; }
.discount-input input { padding-right: 46px; }

.discount-input span {
  position: absolute;
  top: 50%;
  right: 8px;
  transform: translateY(-50%);
  display: grid;
  place-items: center;
  width: 30px;
  height: 30px;
  border-radius: 8px;
  color: #fff;
  background: var(--grad-primary);
  font-size: 12px;
  font-weight: 800;
  pointer-events: none;
}

.form-error {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin-top: 18px;
  padding: 12px 14px;
  border: 1px solid #fecdd3;
  border-left: 5px solid #f43f5e;
  border-radius: 10px;
  color: #be123c;
  background: #fff1f2;
  font-size: 12px;
  font-weight: 600;
  line-height: 1.6;
  animation: shake 0.4s ease both;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 9px;
  margin-top: 22px;
  padding-top: 18px;
  border-top: 1px solid var(--line);
}

/* =========================================================
   PHIẾU GIẢM GIÁ (CHI TIẾT)
   ========================================================= */
.coupon-preview {
  position: relative;
  display: flex;
  align-items: center;
  gap: 14px;
  margin-top: 22px;
  padding: 20px 22px;
  border-radius: 16px;
  background: linear-gradient(120deg, #eef2ff 0%, #fff7ed 100%);
  border: 2px dashed #a5b4fc;
  animation: couponIn 0.5s var(--ease) 0.1s both;
}

/* khuyết hai bên như tem vé */
.coupon-preview::before,
.coupon-preview::after {
  content: "";
  position: absolute;
  top: 50%;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  border-radius: 50%;
  background: #fff;
  border: 2px dashed #a5b4fc;
}

.coupon-preview::before { left: -12px; clip-path: inset(0 0 0 50%); }
.coupon-preview::after { right: -12px; clip-path: inset(0 50% 0 0); }

.coupon-symbol {
  display: grid;
  place-items: center;
  width: 52px;
  height: 52px;
  flex-shrink: 0;
  border-radius: 14px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
  font-size: 22px;
}

.coupon-preview > div:nth-child(2) {
  display: flex;
  flex: 1;
  flex-direction: column;
  gap: 5px;
  min-width: 0;
}

.coupon-preview small {
  color: var(--primary);
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 0.3px;
}

.coupon-preview strong {
  overflow-wrap: anywhere;
  color: var(--navy);
  font-size: 17px;
  font-weight: 800;
  letter-spacing: 0.05em;
}

.coupon-preview span {
  color: #94a3b8;
  font-size: 10px;
  letter-spacing: 0.16em;
}

.coupon-discount {
  font-size: 34px;
  font-weight: 900;
  white-space: nowrap;
  background: var(--grad-warm);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.coupon-discount small {
  display: block;
  margin-top: 2px;
  text-align: right;
  -webkit-text-fill-color: #b45309;
  color: #b45309;
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
  margin-top: 18px;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 7px;
  padding: 14px 15px;
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
  color: var(--primary);
  font-size: 10.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.detail-item strong {
  color: var(--navy);
  font-size: 13px;
  font-weight: 700;
}

/* trạng thái hiển thị trong ô chi tiết */
.detail-item strong[class^="status-"] {
  align-self: flex-start;
  padding: 4px 12px;
  border-radius: 999px;
  font-size: 12px;
}

/* =========================================================
   XÁC NHẬN XÓA
   ========================================================= */
.confirm-modal {
  width: min(100%, 440px);
  padding-top: 30px;
  text-align: center;
}

.confirm-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  color: #fff;
  background: var(--grad-danger);
  box-shadow: 0 10px 24px rgba(244, 63, 94, 0.4);
  font-size: 26px;
  animation: pulseDot 2s ease-in-out infinite;
}

.confirm-modal h2 {
  margin: 16px 0 0;
  color: var(--navy);
  font-size: 21px;
  font-weight: 800;
}

.confirm-modal p {
  color: var(--muted);
  font-size: 13px;
  line-height: 1.8;
}

.confirm-modal p strong {
  padding: 2px 8px;
  border-radius: 6px;
  color: #4338ca;
  background: #e0e7ff;
}

.centered-actions {
  justify-content: center;
  border-top: 0;
}

/* =========================================================
   TOAST
   ========================================================= */
.toast-message {
  position: fixed;
  right: 24px;
  bottom: 24px;
  z-index: 1300;
  display: flex;
  align-items: center;
  gap: 11px;
  max-width: calc(100vw - 32px);
  padding: 14px 20px 14px 14px;
  border-radius: 14px;
  color: #fff;
  background: linear-gradient(135deg, #059669, #10b981);
  box-shadow: 0 14px 34px rgba(5, 150, 105, 0.4);
  font-size: 13px;
  font-weight: 600;
}

.toast-message span {
  display: grid;
  place-items: center;
  width: 26px;
  height: 26px;
  border-radius: 50%;
  color: #059669;
  background: #fff;
}

.toast-message.toast-error {
  background: var(--grad-danger);
  box-shadow: 0 14px 34px rgba(244, 63, 94, 0.4);
}

.toast-message.toast-error span { color: #e11d48; }

.toast-enter-active,
.toast-leave-active {
  transition: opacity 0.3s var(--ease), transform 0.3s var(--ease);
}

.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translateX(30px) scale(0.95);
}

/* thanh cuộn gọn */
.table-wrapper::-webkit-scrollbar { height: 8px; }
.table-wrapper::-webkit-scrollbar-thumb { border-radius: 8px; background: #c7d2fe; }
.table-wrapper::-webkit-scrollbar-thumb:hover { background: #818cf8; }

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 1150px) {
  .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 700px) {
  .page-heading { align-items: flex-start; flex-direction: column; }
  .page-heading h1 { font-size: 24px; }
  .stats-grid { gap: 10px; }
  .stat-card { align-items: flex-start; flex-direction: column; gap: 10px; padding: 14px; }
  .stat-icon { width: 42px; height: 42px; border-radius: 12px; font-size: 17px; }
  .stat-number { font-size: 23px; }
  .filter-bar { padding: 14px; }
  .search-box { width: 100%; }
  .list-heading { padding: 20px 15px; }
  .table-footer { align-items: flex-start; flex-direction: column; padding: 14px 15px; }
  .detail-grid { grid-template-columns: 1fr; }
  .modal-card { padding: 0 18px 20px; }
  .modal-heading { margin: 0 -18px; padding: 20px 18px; }
  .coupon-discount { font-size: 28px; }
}

/* Tôn trọng người dùng tắt hiệu ứng chuyển động */
@media (prefers-reduced-motion: reduce) {
  .voucher-page *,
  .voucher-page *::before,
  .voucher-page *::after {
    animation: none !important;
    transition: none !important;
  }
}
</style>