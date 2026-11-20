
<template>
  <div class="ts-stock-page">

    <!-- PAGE HEADER -->
    <div class="stock-page-header">
      <div>
        <div class="stock-eyebrow">
          TECHSHOP / INVENTORY MANAGEMENT
        </div>

        <h1>Quản lý kho</h1>

        <p class="stock-subtitle">
          Theo dõi tồn kho, nhập xuất hàng hóa và lịch sử biến động.
        </p>
      </div>

      <div class="header-actions">
        <div class="warehouse-location">
          <i class="fa-solid fa-warehouse"></i>
          <span>Kho duy nhất · Đà Nẵng</span>
          <span class="online-dot"></span>
          <b>Đang hoạt động</b>
        </div>

        <button
          class="btn-refresh"
          type="button"
          @click="refreshAll"
          :disabled="loading"
        >
          <i
            class="fa-solid fa-rotate"
            :class="{ 'fa-spin': loading }"
          ></i>
          Làm mới
        </button>
      </div>
    </div>

    <!-- GLOBAL ALERT -->
    <div
      v-if="successMessage"
      class="stock-alert alert-success"
    >
      <i class="fa-solid fa-circle-check"></i>
      {{ successMessage }}
      <button type="button" @click="successMessage = ''">
        ×
      </button>
    </div>

    <div
      v-if="errorMessage"
      class="stock-alert alert-error"
    >
      <i class="fa-solid fa-circle-exclamation"></i>
      {{ errorMessage }}
      <button type="button" @click="errorMessage = ''">
        ×
      </button>
    </div>

    <!-- SUMMARY -->
    <div class="stock-summary-grid">

      <div class="summary-card">
        <div class="summary-top">
          <span class="summary-label">Tổng sản phẩm</span>
          <div class="summary-icon blue-icon">
            <i class="fa-solid fa-boxes-stacked"></i>
          </div>
        </div>

        <div class="summary-value">
          {{ formatNumber(stats.TongSanPham) }}
        </div>

        <div class="summary-description">
          Sản phẩm đang được quản lý
        </div>
      </div>

      <div class="summary-card">
        <div class="summary-top">
          <span class="summary-label">Sắp hết hàng</span>
          <div class="summary-icon orange-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
          </div>
        </div>

        <div class="summary-value orange-text">
          {{ formatNumber(stats.SoSanPhamSapHetHang) }}
        </div>

        <div class="summary-description">
          Cần theo dõi và bổ sung hàng
        </div>
      </div>

      <div class="summary-card">
        <div class="summary-top">
          <span class="summary-label">Hết hàng</span>
          <div class="summary-icon red-icon">
            <i class="fa-solid fa-circle-xmark"></i>
          </div>
        </div>

        <div class="summary-value red-text">
          {{ formatNumber(stats.SoSanPhamHetHang) }}
        </div>

        <div class="summary-description">
          Không còn hàng khả dụng
        </div>
      </div>

      <div class="summary-card">
        <div class="summary-top">
          <span class="summary-label">Tổng số lượng tồn</span>
          <div class="summary-icon green-icon">
            <i class="fa-solid fa-cubes"></i>
          </div>
        </div>

        <div class="summary-value green-text">
          {{ formatNumber(stats.TongSoLuongTon) }}
        </div>

        <div class="summary-description">
          Hàng hóa thực tế trong kho
        </div>
      </div>

    </div>

    <!-- INVENTORY WORKSPACE -->
    <section class="stock-workspace">

      <!-- WORKSPACE HEADER -->
      <div class="workspace-header">

        <div>
          <h2>Quản lý kho hàng</h2>
          <p>Quản lý số lượng và hoạt động kho tại một nơi.</p>
        </div>

        <div class="workspace-main-actions">

          <button
            class="action-btn btn-inbound"
            type="button"
            @click="openAction('nhap')"
          >
            <i class="fa-solid fa-arrow-down"></i>
            Nhập kho
          </button>

          <button
            class="action-btn btn-outbound"
            type="button"
            @click="openAction('xuat')"
          >
            <i class="fa-solid fa-arrow-up"></i>
            Xuất kho
          </button>

          <button
            class="action-btn btn-check"
            type="button"
            @click="openAction('kiemke')"
          >
            <i class="fa-solid fa-clipboard-check"></i>
            Kiểm kê
          </button>

        </div>

      </div>

      <!-- TAB NAVIGATION -->
      <div class="stock-tabs">

        <button
          type="button"
          :class="{ active: activeTab === 'inventory' }"
          @click="changeTab('inventory')"
        >
          <i class="fa-solid fa-boxes-stacked"></i>
          Danh sách tồn kho
          <span class="tab-count">{{ inventoryTotal }}</span>
        </button>

        <button
          type="button"
          :class="{ active: activeTab === 'history' }"
          @click="changeTab('history')"
        >
          <i class="fa-solid fa-clock-rotate-left"></i>
          Lịch sử nhập xuất
        </button>

        <button
          type="button"
          :class="{ active: activeTab === 'returns' }"
          @click="changeTab('returns')"
        >
          <i class="fa-solid fa-rotate"></i>
          Hàng đổi trả
        </button>

      </div>

      <!-- ============================= -->
      <!-- TAB 1: INVENTORY -->
      <!-- ============================= -->

      <div
        v-if="activeTab === 'inventory'"
        class="stock-tab-content"
      >

        <div class="inventory-toolbar">

          <div class="toolbar-search">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input
              v-model="inventoryKeyword"
              type="search"
              placeholder="Tìm tên hoặc mã sản phẩm..."
              @keyup.enter="loadInventory(1)"
            />

            <button
              v-if="inventoryKeyword"
              type="button"
              @click="inventoryKeyword = ''; loadInventory(1)"
            >
              ×
            </button>
          </div>

          <select
            v-model="inventoryStatus"
            class="filter-select"
            @change="loadInventory(1)"
          >
            <option value="">Tất cả trạng thái</option>
            <option value="ConHang">Còn hàng</option>
            <option value="SapHet">Sắp hết hàng</option>
            <option value="HetHang">Hết hàng</option>
          </select>

          <div class="threshold-control">
            <label>Ngưỡng sắp hết:</label>
            <input
              v-model.number="threshold"
              type="number"
              min="1"
              max="10000"
              @change="loadInventory(1)"
            />
          </div>

          <button
            type="button"
            class="filter-reset"
            @click="resetInventoryFilters"
          >
            <i class="fa-solid fa-filter-circle-xmark"></i>
            Xóa lọc
          </button>

        </div>

        <!-- INVENTORY TABLE -->
        <div class="table-responsive">

          <table class="stock-table">

            <thead>
              <tr>
                <th>SẢN PHẨM</th>
                <th>MÃ SP</th>
                <th class="text-center">TỒN KHO</th>
                <th class="text-center">ĐANG GIỮ</th>
                <th class="text-center">KHẢ DỤNG</th>
                <th>TRẠNG THÁI</th>
                <th class="text-center">THAO TÁC</th>
              </tr>
            </thead>

            <tbody>

              <tr v-if="inventoryLoading">
                <td colspan="7">
                  <div class="table-state">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Đang tải dữ liệu tồn kho...
                  </div>
                </td>
              </tr>

              <tr v-else-if="inventory.length === 0">
                <td colspan="7">
                  <div class="table-state empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <strong>Không tìm thấy sản phẩm</strong>
                    <span>Thử thay đổi từ khóa hoặc bộ lọc.</span>
                  </div>
                </td>
              </tr>

              <tr
                v-else
                v-for="item in inventory"
                :key="item.MaSP"
              >

                <td>
                  <div class="product-cell">

                    <div class="product-image">
                      <img
                        v-if="item.HinhAnh"
                        :src="item.HinhAnh"
                        :alt="item.TenSP"
                        @error="handleImageError"
                      />

                      <i
                        v-else
                        class="fa-solid fa-box"
                      ></i>
                    </div>

                    <div class="product-info">
                      <strong>{{ item.TenSP }}</strong>
                      <span>
                        {{ item.TrangThaiSP === 'DangBan'
                          ? 'Đang kinh doanh'
                          : 'Ngừng kinh doanh'
                        }}
                      </span>
                    </div>

                  </div>
                </td>

                <td>
                  <span class="product-code">
                    #{{ item.MaSP }}
                  </span>
                </td>

                <td class="text-center">
                  <strong class="quantity-main">
                    {{ formatNumber(item.SoLuongTon) }}
                  </strong>
                </td>

                <td class="text-center">
                  <span class="quantity-held">
                    {{ formatNumber(item.SoLuongDangGiu) }}
                  </span>
                </td>

                <td class="text-center">
                  <strong
                    :class="availableOf(item) <= threshold
                      ? 'quantity-low'
                      : 'quantity-available'"
                  >
                    {{ formatNumber(availableOf(item)) }}
                  </strong>
                </td>

                <td>
                  <span
                    class="stock-status"
                    :class="statusClass(item)"
                  >
                    <span class="status-dot"></span>
                    {{ statusLabel(item) }}
                  </span>
                </td>

                <td class="text-center">
                  <button
                    type="button"
                    class="detail-button"
                    title="Xem chi tiết"
                    @click="openDetail(item)"
                  >
                    <i class="fa-solid fa-eye"></i>
                    Chi tiết
                  </button>
                </td>

              </tr>

            </tbody>

          </table>

        </div>

        <!-- INVENTORY PAGINATION -->
        <div class="table-footer">

          <span>
            Hiển thị
            <strong>{{ inventory.length }}</strong>
            / {{ inventoryTotal }} sản phẩm
          </span>

          <div class="pagination-control">

            <button
              type="button"
              :disabled="inventoryPage <= 1"
              @click="loadInventory(inventoryPage - 1)"
            >
              <i class="fa-solid fa-chevron-left"></i>
            </button>

            <span>
              Trang {{ inventoryPage }} / {{ inventoryLastPage }}
            </span>

            <button
              type="button"
              :disabled="inventoryPage >= inventoryLastPage"
              @click="loadInventory(inventoryPage + 1)"
            >
              <i class="fa-solid fa-chevron-right"></i>
            </button>

          </div>

        </div>

      </div>

      <!-- ============================= -->
      <!-- TAB 2: HISTORY -->
      <!-- ============================= -->

      <div
        v-if="activeTab === 'history'"
        class="stock-tab-content"
      >

        <div class="history-heading">
          <div>
            <h3>Lịch sử biến động kho</h3>
            <p>
              Theo dõi mọi phiếu nhập, xuất và điều chỉnh tồn kho.
            </p>
          </div>

          <button
            type="button"
            class="btn-refresh"
            @click="loadHistory(1)"
            :disabled="historyLoading"
          >
            <i
              class="fa-solid fa-rotate"
              :class="{ 'fa-spin': historyLoading }"
            ></i>
            Làm mới
          </button>
        </div>

        <!-- HISTORY FILTERS -->
        <div class="history-filters">

          <div class="toolbar-search history-search">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input
              v-model="historyFilters.keyword"
              type="search"
              placeholder="Tìm mã phiếu, sản phẩm, lý do..."
              @keyup.enter="loadHistory(1)"
            />
          </div>

          <select
            v-model="historyFilters.LoaiPhieu"
            class="filter-select"
          >
            <option value="">Tất cả giao dịch</option>
            <option value="NHAP">Nhập kho</option>
            <option value="XUAT">Xuất kho</option>
          </select>

          <input
            v-model="historyFilters.TuNgay"
            class="date-filter"
            type="date"
            title="Từ ngày"
          />

          <input
            v-model="historyFilters.DenNgay"
            class="date-filter"
            type="date"
            title="Đến ngày"
          />

          <input
            v-model="historyFilters.MaSP"
            class="small-filter"
            type="number"
            min="1"
            placeholder="Mã SP"
            title="Lọc theo mã sản phẩm"
          />

          <button
            type="button"
            class="btn-search-filter"
            @click="loadHistory(1)"
          >
            <i class="fa-solid fa-magnifying-glass"></i>
            Lọc
          </button>

          <button
            type="button"
            class="filter-reset"
            @click="resetHistoryFilters"
          >
            Xóa
          </button>

        </div>

        <!-- HISTORY TABLE -->
        <div class="table-responsive">

          <table class="stock-table history-table">

            <thead>
              <tr>
                <th>MÃ PHIẾU</th>
                <th>THỜI GIAN</th>
                <th>SẢN PHẨM</th>
                <th>HOẠT ĐỘNG</th>
                <th class="text-center">SỐ LƯỢNG</th>
                <th>LIÊN KẾT</th>
                <th>NGƯỜI THỰC HIỆN</th>
              </tr>
            </thead>

            <tbody>

              <tr v-if="historyLoading">
                <td colspan="7">
                  <div class="table-state">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Đang tải lịch sử...
                  </div>
                </td>
              </tr>

              <tr v-else-if="histories.length === 0">
                <td colspan="7">
                  <div class="table-state empty-state">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <strong>Chưa có giao dịch phù hợp</strong>
                    <span>
                      Các giao dịch mới sẽ được lưu lại tại đây.
                    </span>
                  </div>
                </td>
              </tr>

              <tr
                v-else
                v-for="item in histories"
                :key="item.MaPhieu"
              >

                <td>
                  <span class="history-code">
                    #{{ item.MaPhieu }}
                  </span>
                </td>

                <td>
                  <div class="date-cell">
                    <strong>{{ formatDate(item.NgayLap) }}</strong>
                  </div>
                </td>

                <td>
                  <div class="history-product">
                    <strong>{{ item.TenSP || 'Sản phẩm #' + item.MaSP }}</strong>
                    <span>SP #{{ item.MaSP }}</span>
                  </div>
                </td>

                <td>
                  <span
                    class="movement-badge"
                    :class="item.LoaiPhieu === 'NHAP'
                      ? 'movement-in'
                      : 'movement-out'"
                  >
                    <i
                      class="fa-solid"
                      :class="item.LoaiPhieu === 'NHAP'
                        ? 'fa-arrow-down'
                        : 'fa-arrow-up'"
                    ></i>

                    {{ item.LoaiPhieu === 'NHAP'
                      ? 'Nhập kho'
                      : 'Xuất kho'
                    }}
                  </span>

                  <div class="history-reason">
                    {{ item.LyDo || 'Không có lý do' }}
                  </div>
                </td>

                <td class="text-center">
                  <strong
                    class="history-quantity"
                    :class="item.LoaiPhieu === 'NHAP'
                      ? 'positive'
                      : 'negative'"
                  >
                    {{ item.LoaiPhieu === 'NHAP' ? '+' : '-' }}
                    {{ formatNumber(item.SoLuong) }}
                  </strong>
                </td>

                <td>
                  <span
                    v-if="item.MaDH"
                    class="link-code order-link"
                  >
                    Đơn #{{ item.MaDH }}
                  </span>

                  <span
                    v-else-if="item.MaYCDT"
                    class="link-code return-link"
                  >
                    Yêu cầu #{{ item.MaYCDT }}
                  </span>

                  <span
                    v-else
                    class="link-empty"
                  >
                    Thủ công
                  </span>
                </td>

                <td>
                  <div class="staff-cell">
                    <div class="staff-avatar">
                      <i class="fa-solid fa-user"></i>
                    </div>
                    <span>
                      {{ item.TenNguoiLap || 'Hệ thống' }}
                    </span>
                  </div>
                </td>

              </tr>

            </tbody>

          </table>

        </div>

        <div class="table-footer">

          <span>
            Tổng cộng
            <strong>{{ historyTotal }}</strong>
            giao dịch
          </span>

          <div class="pagination-control">

            <button
              type="button"
              :disabled="historyPage <= 1"
              @click="loadHistory(historyPage - 1)"
            >
              <i class="fa-solid fa-chevron-left"></i>
            </button>

            <span>
              Trang {{ historyPage }} / {{ historyLastPage }}
            </span>

            <button
              type="button"
              :disabled="historyPage >= historyLastPage"
              @click="loadHistory(historyPage + 1)"
            >
              <i class="fa-solid fa-chevron-right"></i>
            </button>

          </div>

        </div>

      </div>

      <!-- ============================= -->
      <!-- TAB 3: RETURN GOODS -->
      <!-- ============================= -->

      <div
        v-if="activeTab === 'returns'"
        class="stock-tab-content"
      >

        <div class="return-intro">
          <div class="return-icon">
            <i class="fa-solid fa-box-open"></i>
          </div>

          <div>
            <h3>Nhập lại hàng đổi trả</h3>
            <p>
              Chỉ nhập hàng trở lại kho bán được sau khi cửa hàng
              đã nhận và kiểm tra sản phẩm đạt điều kiện.
            </p>
          </div>
        </div>

        <div class="return-warning">
          <i class="fa-solid fa-shield-halved"></i>
          <div>
            <strong>Kiểm soát chất lượng hàng trả</strong>
            <span>
              Hàng không đạt kiểm tra sẽ không được cộng vào tồn kho.
              Backend sẽ tự kiểm tra trạng thái yêu cầu và số lượng
              còn được phép nhập.
            </span>
          </div>
        </div>

        <div class="return-form-card">

          <div class="form-heading">
            <div>
              <span class="form-eyebrow">RETURN INVENTORY</span>
              <h3>Thông tin nhập lại hàng</h3>
            </div>

            <span class="form-icon">
              <i class="fa-solid fa-rotate-left"></i>
            </span>
          </div>

          <form @submit.prevent="submitReturn">

            <div class="form-grid">

              <div class="form-group">
                <label>
                  Mã yêu cầu đổi trả
                  <span class="required">*</span>
                </label>

                <input
                  v-model.number="returnForm.MaYCDT"
                  type="number"
                  min="1"
                  required
                  placeholder="Ví dụ: 12"
                />

                <small>
                  Nhập mã yêu cầu đã được cửa hàng tiếp nhận.
                </small>
              </div>

              <div class="form-group">
                <label>Kết quả kiểm tra</label>

                <select
                  v-model="returnForm.KetQuaKiemTra"
                  required
                >
                  <option value="Dat">
                    Đạt điều kiện bán lại
                  </option>
                  <option value="KhongDat">
                    Không đạt điều kiện bán lại
                  </option>
                </select>

                <small>
                  Chỉ kết quả Đạt mới được gửi yêu cầu nhập kho.
                </small>
              </div>

              <div class="form-group">
                <label>Số lượng nhập lại</label>

                <input
                  v-model.number="returnForm.SoLuongNhapLai"
                  type="number"
                  min="1"
                  placeholder="Để trống nếu nhập toàn bộ số còn lại"
                />

                <small>
                  Có thể để trống để Backend tự lấy số lượng còn lại.
                </small>
              </div>

              <div class="form-group">
                <label>Lý do / ghi chú</label>

                <input
                  v-model.trim="returnForm.LyDo"
                  type="text"
                  maxlength="255"
                  placeholder="Ví dụ: Hàng còn nguyên hộp, đủ phụ kiện"
                />
              </div>

            </div>

            <div class="return-form-footer">

              <div class="return-result-note">
                <i class="fa-solid fa-circle-info"></i>
                Mỗi lần nhập sẽ tạo một phiếu NHAP liên kết với
                mã yêu cầu đổi trả.
              </div>

              <button
                type="submit"
                class="action-btn btn-inbound"
                :disabled="submitting"
              >
                <i
                  class="fa-solid"
                  :class="submitting
                    ? 'fa-spinner fa-spin'
                    : 'fa-arrow-down'"
                ></i>
                {{ submitting ? 'Đang xử lý...' : 'Xác nhận nhập lại kho' }}
              </button>

            </div>

          </form>

        </div>

      </div>

    </section>

    <!-- ================================= -->
    <!-- ACTION MODAL: IN / OUT / STOCKTAKE -->
    <!-- ================================= -->

    <div
      v-if="showActionModal"
      class="stock-modal-overlay"
      @click.self="closeAction"
    >

      <div class="stock-modal">

        <div class="modal-heading">

          <div>
            <span class="form-eyebrow">TECHSHOP INVENTORY</span>

            <h3>
              {{ actionTitle }}
            </h3>

            <p>{{ actionDescription }}</p>
          </div>

          <button
            type="button"
            class="modal-close"
            @click="closeAction"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>

        </div>

        <form @submit.prevent="submitAction">

          <div class="modal-body">

            <div
              v-if="actionType === 'xuat'"
              class="modal-warning"
            >
              <i class="fa-solid fa-triangle-exclamation"></i>
              Xuất kho thủ công chỉ dùng cho hàng hỏng, thất thoát
              hoặc sử dụng nội bộ. Không dùng để xuất đơn hàng online.
            </div>

            <div class="form-group">
              <label>
                Sản phẩm
                <span class="required">*</span>
              </label>

              <select
                v-model.number="actionForm.MaSP"
                required
              >
                <option value="">-- Chọn sản phẩm --</option>

                <option
                  v-for="product in productOptions"
                  :key="product.MaSP"
                  :value="product.MaSP"
                >
                  #{{ product.MaSP }} · {{ product.TenSP }}
                  (Tồn: {{ product.SoLuongTon }})
                </option>
              </select>

              <small v-if="selectedActionProduct">
                Tồn thực tế:
                <strong>
                  {{ formatNumber(selectedActionProduct.SoLuongTon) }}
                </strong>
                · Đang giữ:
                <strong>
                  {{ formatNumber(selectedActionProduct.SoLuongDangGiu) }}
                </strong>
                · Khả dụng:
                <strong>
                  {{ formatNumber(availableOf(selectedActionProduct)) }}
                </strong>
              </small>

              <small v-else>
                Danh sách sản phẩm được lấy từ API tồn kho.
              </small>
            </div>

            <div
              v-if="actionType !== 'kiemke'"
              class="form-group"
            >
              <label>
                Số lượng
                <span class="required">*</span>
              </label>

              <input
                v-model.number="actionForm.SoLuong"
                type="number"
                min="1"
                step="1"
                required
                placeholder="Nhập số lượng"
              />
            </div>

            <div
              v-if="actionType === 'kiemke'"
              class="form-group"
            >
              <label>
                Số lượng thực tế kiểm kê
                <span class="required">*</span>
              </label>

              <input
                v-model.number="actionForm.SoLuongThucTe"
                type="number"
                min="0"
                step="1"
                required
                placeholder="Nhập số lượng đếm được"
              />

              <small>
                Hệ thống tự so sánh với tồn kho hiện tại và tạo
                phiếu điều chỉnh nếu có chênh lệch.
              </small>
            </div>

            <div class="form-group">
              <label>
                Lý do
                <span class="required">*</span>
              </label>

              <textarea
                v-model.trim="actionForm.LyDo"
                required
                maxlength="500"
                rows="3"
                placeholder="Nhập lý do thực hiện..."
              ></textarea>
            </div>

            <div
              v-if="actionType === 'kiemke' && selectedActionProduct"
              class="stocktake-preview"
            >
              <div>
                <span>Tồn hệ thống</span>
                <strong>
                  {{ formatNumber(selectedActionProduct.SoLuongTon) }}
                </strong>
              </div>

              <div>
                <span>Số lượng khả dụng</span>
                <strong>
                  {{ formatNumber(availableOf(selectedActionProduct)) }}
                </strong>
              </div>

              <div v-if="isValidCount">
                <span>Chênh lệch dự kiến</span>
                <strong
                  :class="countDifference > 0
                    ? 'positive'
                    : countDifference < 0
                      ? 'negative'
                      : ''"
                >
                  {{ countDifference > 0 ? '+' : '' }}
                  {{ formatNumber(countDifference) }}
                </strong>
              </div>
            </div>

          </div>

          <div
            v-if="formError"
            class="form-error"
          >
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ formError }}
          </div>

          <div class="modal-footer">

            <button
              type="button"
              class="btn-cancel"
              @click="closeAction"
              :disabled="submitting"
            >
              Hủy
            </button>

            <button
              type="submit"
              class="action-btn"
              :class="actionButtonClass"
              :disabled="submitting"
            >
              <i
                class="fa-solid"
                :class="submitting
                  ? 'fa-spinner fa-spin'
                  : actionButtonIcon"
              ></i>

              {{ submitting ? 'Đang xử lý...' : actionButtonLabel }}
            </button>

          </div>

        </form>

      </div>

    </div>

    <!-- ================================= -->
    <!-- PRODUCT DETAIL MODAL -->
    <!-- ================================= -->

    <div
      v-if="showDetailModal"
      class="stock-modal-overlay"
      @click.self="closeDetail"
    >

      <div class="stock-modal detail-modal">

        <div class="modal-heading">

          <div>
            <span class="form-eyebrow">INVENTORY DETAIL</span>
            <h3>Chi tiết tồn kho</h3>
            <p>Thông tin sản phẩm và 20 biến động gần nhất.</p>
          </div>

          <button
            type="button"
            class="modal-close"
            @click="closeDetail"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>

        </div>

        <div v-if="detailLoading" class="detail-loading">
          <i class="fa-solid fa-spinner fa-spin"></i>
          Đang lấy chi tiết sản phẩm...
        </div>

        <div
          v-else-if="detailData"
          class="detail-modal-body"
        >

          <div class="detail-product">

            <div class="detail-product-image">
              <img
                v-if="detailData.sanPham?.HinhAnh"
                :src="detailData.sanPham.HinhAnh"
                :alt="detailData.sanPham.TenSP"
                @error="handleImageError"
              />

              <i
                v-else
                class="fa-solid fa-box"
              ></i>
            </div>

            <div>
              <h4>{{ detailData.sanPham?.TenSP }}</h4>
              <span>
                Mã sản phẩm #{{ detailData.sanPham?.MaSP }}
              </span>
            </div>

          </div>

          <div class="detail-stat-grid">

            <div>
              <span>Tồn thực tế</span>
              <strong>
                {{ formatNumber(detailData.tonKho?.SoLuongTon) }}
              </strong>
            </div>

            <div>
              <span>Đang giữ</span>
              <strong>
                {{ formatNumber(detailData.tonKho?.SoLuongDangGiu) }}
              </strong>
            </div>

            <div>
              <span>Khả dụng</span>
              <strong class="green-text">
                {{ formatNumber(detailData.tonKho?.SoLuongKhaDung) }}
              </strong>
            </div>

          </div>

          <h4 class="detail-history-title">
            Biến động gần đây
          </h4>

          <div class="detail-history-list">

            <div
              v-if="!detailData.lichSuBienDong?.length"
              class="detail-empty"
            >
              Chưa có biến động được ghi nhận.
            </div>

            <div
              v-for="record in detailData.lichSuBienDong || []"
              :key="record.MaPhieu"
              class="detail-history-item"
            >

              <div>
                <strong>
                  {{ record.LoaiPhieu === 'NHAP'
                    ? 'Nhập kho'
                    : 'Xuất kho'
                  }}
                </strong>
                <span>{{ record.LyDo || 'Không có lý do' }}</span>
                <small>{{ formatDate(record.NgayLap) }}</small>
              </div>

              <strong
                :class="record.LoaiPhieu === 'NHAP'
                  ? 'positive'
                  : 'negative'"
              >
                {{ record.LoaiPhieu === 'NHAP' ? '+' : '-' }}
                {{ formatNumber(record.SoLuong) }}
              </strong>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>
</template>

<script>
import axios from "axios";

const API = "http://127.0.0.1:8000/api";

export default {
  name: "QuanLyKho",

  data() {
    return {
      loading: false,
      inventoryLoading: false,
      historyLoading: false,
      submitting: false,
      showActionModal: false,
      showDetailModal: false,

      activeTab: "inventory",

      successMessage: "",
      errorMessage: "",
      formError: "",

      threshold: 5,

      // Thống kê lấy từ API.
      stats: {
        TongSanPham: 0,
        TongSoLuongTon: 0,
        TongSoLuongDangGiu: 0,
        TongSoLuongKhaDung: 0,
        SoSanPhamSapHetHang: 0,
        SoSanPhamHetHang: 0,
        NguongSapHet: 5,
      },

      // Danh sách tồn kho.
      inventory: [],
      inventoryTotal: 0,
      inventoryPage: 1,
      inventoryLastPage: 1,
      inventoryPerPage: 10,

      inventoryKeyword: "",
      inventoryStatus: "",

      // Sản phẩm dùng cho các form nhập/xuất.
      productOptions: [],

      // Lịch sử kho.
      histories: [],
      historyTotal: 0,
      historyPage: 1,
      historyLastPage: 1,
      historyPerPage: 20,

      historyFilters: {
        keyword: "",
        LoaiPhieu: "",
        MaSP: "",
        MaDH: "",
        MaYCDT: "",
        TuNgay: "",
        DenNgay: "",
      },

      // Form nhập / xuất / kiểm kê.
      actionType: "",

      actionForm: {
        MaSP: "",
        SoLuong: 1,
        SoLuongThucTe: 0,
        LyDo: "",
      },

      // Form nhập lại hàng đổi trả.
      returnForm: {
        MaYCDT: "",
        KetQuaKiemTra: "Dat",
        SoLuongNhapLai: "",
        LyDo: "",
      },

      // Chi tiết sản phẩm.
      detailLoading: false,
      detailData: null,
    };
  },

  computed: {
    actionTitle() {
      const titles = {
        nhap: "Tạo phiếu nhập kho",
        xuat: "Tạo phiếu xuất kho",
        kiemke: "Kiểm kê tồn kho",
      };

      return titles[this.actionType] || "Thao tác kho";
    },

    actionDescription() {
      const descriptions = {
        nhap: "Bổ sung số lượng hàng hóa vào kho.",
        xuat: "Ghi nhận hàng xuất kho thủ công.",
        kiemke: "Đối chiếu số lượng thực tế với hệ thống.",
      };

      return descriptions[this.actionType] || "";
    },

    actionButtonLabel() {
      const labels = {
        nhap: "Xác nhận nhập kho",
        xuat: "Xác nhận xuất kho",
        kiemke: "Xác nhận kiểm kê",
      };

      return labels[this.actionType] || "Xác nhận";
    },

    actionButtonIcon() {
      const icons = {
        nhap: "fa-arrow-down",
        xuat: "fa-arrow-up",
        kiemke: "fa-clipboard-check",
      };

      return icons[this.actionType] || "fa-check";
    },

    actionButtonClass() {
      const classes = {
        nhap: "btn-inbound",
        xuat: "btn-outbound",
        kiemke: "btn-check",
      };

      return classes[this.actionType] || "btn-inbound";
    },

    selectedActionProduct() {
      return this.productOptions.find(
        item => Number(item.MaSP) === Number(this.actionForm.MaSP)
      ) || null;
    },

    countDifference() {
      if (!this.selectedActionProduct) return 0;

      return Number(this.actionForm.SoLuongThucTe || 0)
        - Number(this.selectedActionProduct.SoLuongTon || 0);
    },

    isValidCount() {
      return this.actionForm.SoLuongThucTe !== "" &&
        this.selectedActionProduct !== null;
    },
  },

  mounted() {
    this.refreshAll();
  },

  methods: {

    // =====================================
    // AXIOS CONFIG
    // =====================================

    getConfig() {
      const token = localStorage.getItem("admin_token");

      if (!token) {
        throw new Error(
          "Không tìm thấy admin_token. Vui lòng đăng nhập lại."
        );
      }

      return {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
          "Content-Type": "application/json",
        },
      };
    },

    getErrorMessage(error) {
      const response = error?.response;

      if (response?.status === 401) {
        return "Phiên đăng nhập hết hạn. Vui lòng đăng nhập lại.";
      }

      if (response?.status === 403) {
        return "Tài khoản không có quyền quản lý kho.";
      }

      if (response?.data?.errors) {
        const errors = Object.values(response.data.errors).flat();
        return errors[0] || "Dữ liệu không hợp lệ.";
      }

      return response?.data?.message ||
        error?.message ||
        "Có lỗi xảy ra. Vui lòng thử lại.";
    },

    clearMessages() {
      this.successMessage = "";
      this.errorMessage = "";
    },

    // =====================================
    // LOAD ALL
    // =====================================

    async refreshAll() {
      this.loading = true;
      this.clearMessages();

      try {
        await Promise.all([
          this.loadInventory(this.inventoryPage),
          this.loadHistory(this.historyPage),
          this.loadProductOptions(),
        ]);
      } finally {
        this.loading = false;
      }
    },

    // =====================================
    // LOAD INVENTORY
    // GET /kho/ton-kho
    // =====================================

    async loadInventory(page = 1) {
      this.inventoryLoading = true;

      try {
        const params = {
          page,
          per_page: this.inventoryPerPage,
          NguongSapHet: this.threshold,
        };

        // KhoController bản hiện tại sử dụng TuKhoa.
        if (this.inventoryKeyword.trim()) {
          params.TuKhoa = this.inventoryKeyword.trim();
        }

        if (this.inventoryStatus) {
          params.TrangThaiTonKho = this.inventoryStatus;
        }

        const response = await axios.get(
          `${API}/kho/ton-kho`,
          {
            ...this.getConfig(),
            params,
          }
        );

        if (!response.data?.status) {
          throw new Error(
            response.data?.message || "Không lấy được tồn kho."
          );
        }

        const result = response.data;

        this.stats = {
          ...this.stats,
          ...(result.thongKe || {}),
        };

        const pagination = result.danhSach || {};

        this.inventory = pagination.data || [];
        this.inventoryPage = pagination.current_page || 1;
        this.inventoryLastPage = pagination.last_page || 1;
        this.inventoryTotal = pagination.total || 0;

      } catch (error) {
        console.error("Lỗi lấy tồn kho:", error);
        this.errorMessage = this.getErrorMessage(error);
      } finally {
        this.inventoryLoading = false;
      }
    },

    // =====================================
    // PRODUCT OPTIONS
    // DÙNG CHO FORM NHẬP/XUẤT/KIỂM KÊ
    // =====================================

    async loadProductOptions() {
      try {
        const response = await axios.get(
          `${API}/kho/ton-kho`,
          {
            ...this.getConfig(),
            params: {
              page: 1,
              per_page: 100,
              NguongSapHet: this.threshold,
            },
          }
        );

        if (response.data?.status) {
          this.productOptions =
            response.data?.danhSach?.data || [];
        }

      } catch (error) {
        console.error("Lỗi tải danh sách sản phẩm:", error);
      }
    },

    // =====================================
    // LOAD HISTORY
    // GET /phieu-xuat-nhap/lich-su
    // =====================================

    async loadHistory(page = 1) {
      this.historyLoading = true;

      try {
        const params = {
          page,
          per_page: this.historyPerPage,
        };

        Object.keys(this.historyFilters).forEach(key => {
          const value = this.historyFilters[key];

          if (value !== "" && value !== null && value !== undefined) {
            params[key] = value;
          }
        });

        const response = await axios.get(
          `${API}/phieu-xuat-nhap/lich-su`,
          {
            ...this.getConfig(),
            params,
          }
        );

        if (!response.data?.status) {
          throw new Error(
            response.data?.message || "Không lấy được lịch sử kho."
          );
        }

        const pagination = response.data.data || {};

        this.histories = pagination.data || [];
        this.historyPage = pagination.current_page || 1;
        this.historyLastPage = pagination.last_page || 1;
        this.historyTotal = pagination.total || 0;

      } catch (error) {
        console.error("Lỗi lịch sử kho:", error);
        this.errorMessage = this.getErrorMessage(error);
      } finally {
        this.historyLoading = false;
      }
    },

    // =====================================
    // CHANGE TAB
    // =====================================

    changeTab(tab) {
      this.activeTab = tab;

      if (tab === "history" && this.histories.length === 0) {
        this.loadHistory(1);
      }
    },

    // =====================================
    // FILTER INVENTORY
    // =====================================

    resetInventoryFilters() {
      this.inventoryKeyword = "";
      this.inventoryStatus = "";
      this.threshold = 5;

      this.loadInventory(1);
      this.loadProductOptions();
    },

    // =====================================
    // FILTER HISTORY
    // =====================================

    resetHistoryFilters() {
      this.historyFilters = {
        keyword: "",
        LoaiPhieu: "",
        MaSP: "",
        MaDH: "",
        MaYCDT: "",
        TuNgay: "",
        DenNgay: "",
      };

      this.loadHistory(1);
    },

    // =====================================
    // STOCK CALCULATIONS
    // =====================================

    availableOf(item) {
      const total = Number(item?.SoLuongTon || 0);
      const held = Number(item?.SoLuongDangGiu || 0);

      return Math.max(0, total - held);
    },

    statusLabel(item) {
      const available = this.availableOf(item);

      if (available <= 0) {
        return "Hết hàng";
      }

      if (available <= Number(this.threshold)) {
        return "Sắp hết";
      }

      return "Còn hàng";
    },

    statusClass(item) {
      const available = this.availableOf(item);

      if (available <= 0) return "status-out";
      if (available <= Number(this.threshold)) return "status-low";

      return "status-in";
    },

    // =====================================
    // FORMAT
    // =====================================

    formatNumber(value) {
      return Number(value || 0).toLocaleString("vi-VN");
    },

    formatDate(value) {
      if (!value) return "—";

      const date = new Date(value);

      if (Number.isNaN(date.getTime())) {
        return String(value);
      }

      return date.toLocaleString("vi-VN", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    },

    handleImageError(event) {
      event.target.style.display = "none";
    },

    // =====================================
    // OPEN ACTION MODAL
    // =====================================

    openAction(type) {
      this.actionType = type;

      this.actionForm = {
        MaSP: "",
        SoLuong: 1,
        SoLuongThucTe: 0,
        LyDo: "",
      };

      this.formError = "";
      this.showActionModal = true;

      if (!this.productOptions.length) {
        this.loadProductOptions();
      }
    },

    closeAction() {
      if (this.submitting) return;

      this.showActionModal = false;
      this.formError = "";
    },

    // =====================================
    // SUBMIT IN / OUT / STOCKTAKE
    // =====================================

    async submitAction() {
      this.formError = "";

      const maSP = Number(this.actionForm.MaSP);
      const lyDo = String(this.actionForm.LyDo || "").trim();

      if (!maSP || maSP < 1) {
        this.formError = "Vui lòng chọn sản phẩm.";
        return;
      }

      if (!lyDo) {
        this.formError = "Vui lòng nhập lý do.";
        return;
      }

      let endpoint = "";
      let payload = {};

      if (this.actionType === "nhap") {
        const soLuong = Number(this.actionForm.SoLuong);

        if (!Number.isInteger(soLuong) || soLuong < 1) {
          this.formError = "Số lượng nhập phải là số nguyên lớn hơn 0.";
          return;
        }

        endpoint = "/phieu-xuat-nhap/nhap-kho";

        payload = {
          MaSP: maSP,
          SoLuong: soLuong,
          LyDo: lyDo,
        };
      }

      if (this.actionType === "xuat") {
        const soLuong = Number(this.actionForm.SoLuong);

        if (!Number.isInteger(soLuong) || soLuong < 1) {
          this.formError = "Số lượng xuất phải là số nguyên lớn hơn 0.";
          return;
        }

        endpoint = "/phieu-xuat-nhap/xuat-kho";

        payload = {
          MaSP: maSP,
          SoLuong: soLuong,
          LyDo: lyDo,
        };
      }

      if (this.actionType === "kiemke") {
        const soLuongThucTe =
          Number(this.actionForm.SoLuongThucTe);

        if (
          !Number.isInteger(soLuongThucTe) ||
          soLuongThucTe < 0
        ) {
          this.formError =
            "Số lượng thực tế phải là số nguyên không âm.";
          return;
        }

        endpoint = "/kho/kiem-ke";

        payload = {
          MaSP: maSP,
          SoLuongThucTe: soLuongThucTe,
          LyDo: lyDo,
        };
      }

      this.submitting = true;

      try {
        const response = await axios.post(
          `${API}${endpoint}`,
          payload,
          this.getConfig()
        );

        if (!response.data?.status) {
          throw new Error(
            response.data?.message || "Thao tác kho thất bại."
          );
        }

        this.showActionModal = false;
        this.successMessage =
          response.data.message || "Thao tác kho thành công.";

        await Promise.all([
          this.loadInventory(1),
          this.loadHistory(1),
          this.loadProductOptions(),
        ]);

      } catch (error) {
        console.error("Lỗi thao tác kho:", error);
        this.formError = this.getErrorMessage(error);
      } finally {
        this.submitting = false;
      }
    },

    // =====================================
    // SUBMIT RETURN GOODS
    // =====================================

    async submitReturn() {
      this.clearMessages();

      const maYCDT = Number(this.returnForm.MaYCDT);

      if (!maYCDT || maYCDT < 1) {
        this.errorMessage = "Vui lòng nhập mã yêu cầu đổi trả.";
        return;
      }

      if (this.returnForm.KetQuaKiemTra !== "Dat") {
        this.errorMessage =
          "Hàng không đạt kiểm tra không được nhập vào kho bán được.";
        return;
      }

      const payload = {
        MaYCDT: maYCDT,
        KetQuaKiemTra: "Dat",
        LyDo: this.returnForm.LyDo.trim(),
      };

      if (
        this.returnForm.SoLuongNhapLai !== "" &&
        this.returnForm.SoLuongNhapLai !== null &&
        this.returnForm.SoLuongNhapLai !== undefined
      ) {
        const quantity = Number(
          this.returnForm.SoLuongNhapLai
        );

        if (!Number.isInteger(quantity) || quantity < 1) {
          this.errorMessage =
            "Số lượng nhập lại phải là số nguyên lớn hơn 0.";
          return;
        }

        payload.SoLuongNhapLai = quantity;
      }

      this.submitting = true;

      try {
        const response = await axios.post(
          `${API}/phieu-xuat-nhap/nhap-hang-doi-tra`,
          payload,
          this.getConfig()
        );

        if (!response.data?.status) {
          throw new Error(
            response.data?.message || "Nhập lại hàng thất bại."
          );
        }

        this.successMessage =
          response.data.message || "Nhập lại hàng thành công.";

        this.returnForm = {
          MaYCDT: "",
          KetQuaKiemTra: "Dat",
          SoLuongNhapLai: "",
          LyDo: "",
        };

        await Promise.all([
          this.loadInventory(1),
          this.loadHistory(1),
          this.loadProductOptions(),
        ]);

      } catch (error) {
        console.error("Lỗi nhập lại hàng:", error);
        this.errorMessage = this.getErrorMessage(error);
      } finally {
        this.submitting = false;
      }
    },

    // =====================================
    // PRODUCT DETAIL
    // =====================================

    async openDetail(item) {
      this.showDetailModal = true;
      this.detailLoading = true;
      this.detailData = null;

      try {
        const response = await axios.get(
          `${API}/kho/ton-kho/${item.MaSP}`,
          this.getConfig()
        );

        if (!response.data?.status) {
          throw new Error(
            response.data?.message || "Không lấy được chi tiết sản phẩm."
          );
        }

        this.detailData = response.data;

      } catch (error) {
        console.error("Lỗi chi tiết tồn kho:", error);
        this.errorMessage = this.getErrorMessage(error);
        this.showDetailModal = false;
      } finally {
        this.detailLoading = false;
      }
    },

    closeDetail() {
      this.showDetailModal = false;
      this.detailData = null;
    },

  },
};
</script>
<style scoped>
/* =========================================================
   BẢNG MÀU & BIẾN DÙNG CHUNG
   ========================================================= */
.ts-stock-page {
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
  padding: 26px;
  color: var(--text);
  font-family: "Roboto", "Inter", Arial, sans-serif;
  background: linear-gradient(180deg, #f5f7ff 0%, #f8fafc 100%);
}

.ts-stock-page * {
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

@keyframes tabIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes pulseDot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.4); }
}

@keyframes ping {
  0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.55); }
  100% { box-shadow: 0 0 0 9px rgba(16, 185, 129, 0); }
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

@keyframes alertIn {
  from { opacity: 0; transform: translateY(-12px) scale(0.98); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

.stock-page-header { animation: fadeUp 0.5s var(--ease) both; }

.summary-card { animation: fadeUp 0.55s var(--ease) both; }
.summary-card:nth-child(1) { animation-delay: 0.05s; }
.summary-card:nth-child(2) { animation-delay: 0.12s; }
.summary-card:nth-child(3) { animation-delay: 0.19s; }
.summary-card:nth-child(4) { animation-delay: 0.26s; }

.stock-workspace { animation: fadeUp 0.6s var(--ease) 0.3s both; }
.stock-tab-content { animation: tabIn 0.4s var(--ease) both; }

.stock-table tbody tr { animation: rowIn 0.4s var(--ease) both; }
.stock-table tbody tr:nth-child(1) { animation-delay: 0.04s; }
.stock-table tbody tr:nth-child(2) { animation-delay: 0.08s; }
.stock-table tbody tr:nth-child(3) { animation-delay: 0.12s; }
.stock-table tbody tr:nth-child(4) { animation-delay: 0.16s; }
.stock-table tbody tr:nth-child(5) { animation-delay: 0.2s; }
.stock-table tbody tr:nth-child(6) { animation-delay: 0.24s; }
.stock-table tbody tr:nth-child(7) { animation-delay: 0.28s; }
.stock-table tbody tr:nth-child(8) { animation-delay: 0.32s; }

/* =========================================================
   TIÊU ĐỀ
   ========================================================= */
.stock-page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 26px;
}

.stock-eyebrow {
  display: inline-flex;
  margin-bottom: 10px;
  padding: 4px 12px;
  border-radius: 999px;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 1.5px;
}

.stock-page-header h1 {
  margin: 0;
  font-size: 30px;
  font-weight: 800;
  letter-spacing: -0.5px;
  background: linear-gradient(90deg, #0f172a 0%, #4f46e5 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.stock-subtitle {
  margin: 8px 0 0;
  color: var(--muted);
  font-size: 13.5px;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.warehouse-location {
  display: flex;
  align-items: center;
  gap: 8px;
  min-height: 42px;
  padding: 0 15px;
  border: 1.5px solid var(--line);
  border-radius: 11px;
  background: #fff;
  color: #475569;
  font-size: 12px;
  font-weight: 600;
}

.warehouse-location > i {
  color: var(--primary);
  font-size: 15px;
}

.warehouse-location b {
  color: #047857;
  font-size: 11px;
  white-space: nowrap;
}

.online-dot {
  width: 8px;
  height: 8px;
  flex-shrink: 0;
  border-radius: 50%;
  background: #10b981;
  animation: ping 1.8s ease-out infinite;
}

/* =========================================================
   NÚT
   ========================================================= */
.btn-refresh,
.action-btn,
.btn-search-filter,
.filter-reset,
.btn-cancel {
  position: relative;
  overflow: hidden;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease),
    background 0.25s, border-color 0.25s, filter 0.25s, color 0.25s;
}

.btn-refresh {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  min-height: 42px;
  padding: 0 18px;
  border: 0;
  border-radius: 11px;
  color: #fff;
  background: var(--grad-primary);
  background-size: 140% 140%;
  background-position: 0% 50%;
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
}

.btn-refresh::after,
.action-btn::after {
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

.btn-refresh:hover:not(:disabled) {
  transform: translateY(-2px);
  background-position: 100% 50%;
  box-shadow: 0 12px 26px rgba(79, 70, 229, 0.42);
}

.btn-refresh:hover:not(:disabled)::after,
.action-btn:hover:not(:disabled)::after {
  animation: shine 0.8s var(--ease);
}

.btn-refresh:active:not(:disabled) { transform: scale(0.97); }

button:disabled {
  opacity: 0.6;
  cursor: not-allowed !important;
}

/* thao tác kho */
.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  min-height: 42px;
  padding: 0 18px;
  border: 0;
  border-radius: 11px;
  color: #fff;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
}

.btn-inbound {
  background: var(--grad-success);
  box-shadow: 0 8px 18px rgba(16, 185, 129, 0.32);
}

.btn-outbound {
  background: var(--grad-danger);
  box-shadow: 0 8px 18px rgba(244, 63, 94, 0.3);
}

.btn-check {
  background: linear-gradient(135deg, #6366f1, #2563eb);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
}

.action-btn:hover:not(:disabled) { transform: translateY(-3px); }
.btn-inbound:hover:not(:disabled) { box-shadow: 0 12px 26px rgba(16, 185, 129, 0.45); }
.btn-outbound:hover:not(:disabled) { box-shadow: 0 12px 26px rgba(244, 63, 94, 0.45); }
.btn-check:hover:not(:disabled) { box-shadow: 0 12px 26px rgba(79, 70, 229, 0.45); }
.action-btn:active:not(:disabled) { transform: scale(0.96); }

/* =========================================================
   THÔNG BÁO
   ========================================================= */
.stock-alert {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 17px;
  padding: 14px 18px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 600;
  animation: alertIn 0.4s var(--ease) both;
}

.stock-alert button {
  margin-left: auto;
  border: 0;
  background: transparent;
  color: inherit;
  font-size: 20px;
  cursor: pointer;
  transition: transform 0.25s var(--ease);
}

.stock-alert button:hover { transform: rotate(90deg); }

.alert-success {
  color: #047857;
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  border-left: 5px solid #10b981;
}

.alert-error {
  color: #be123c;
  background: #fff1f2;
  border: 1px solid #fecdd3;
  border-left: 5px solid #f43f5e;
}

/* =========================================================
   THẺ TỔNG QUAN
   ========================================================= */
.stock-summary-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 18px;
  margin-bottom: 24px;
}

.summary-card {
  --tone: #4f46e5;
  --tone-soft: rgba(79, 70, 229, 0.1);
  position: relative;
  overflow: hidden;
  min-width: 0;
  padding: 20px;
  border: 1px solid var(--line);
  border-radius: 16px;
  background: #fff;
  box-shadow: var(--shadow-sm);
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease),
    border-color 0.3s;
}

.summary-card::before {
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

.summary-card::after {
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

.summary-card:nth-child(1) { --tone: #4f46e5; --tone-soft: rgba(79, 70, 229, 0.1); }
.summary-card:nth-child(2) { --tone: #f59e0b; --tone-soft: rgba(245, 158, 11, 0.13); }
.summary-card:nth-child(3) { --tone: #f43f5e; --tone-soft: rgba(244, 63, 94, 0.1); }
.summary-card:nth-child(4) { --tone: #10b981; --tone-soft: rgba(16, 185, 129, 0.12); }

.summary-card:hover {
  transform: translateY(-6px);
  border-color: transparent;
  box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
}

.summary-card:hover::before { transform: scale(1.5); }
.summary-card:hover::after { transform: scaleX(1); }

.summary-top,
.summary-value,
.summary-description {
  position: relative;
  z-index: 1;
}

.summary-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}

.summary-label {
  color: var(--muted);
  font-size: 12px;
  font-weight: 600;
}

.summary-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  flex-shrink: 0;
  border-radius: 15px;
  color: #fff;
  font-size: 19px;
  transition: transform 0.35s var(--ease);
}

.summary-card:hover .summary-icon { transform: rotate(-8deg) scale(1.1); }

.blue-icon {
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  box-shadow: 0 8px 16px rgba(79, 70, 229, 0.35);
}

.orange-icon {
  background: linear-gradient(135deg, #fbbf24, #f97316);
  box-shadow: 0 8px 16px rgba(245, 158, 11, 0.38);
}

.red-icon {
  background: linear-gradient(135deg, #fb7185, #e11d48);
  box-shadow: 0 8px 16px rgba(244, 63, 94, 0.35);
}

.green-icon {
  background: linear-gradient(135deg, #34d399, #059669);
  box-shadow: 0 8px 16px rgba(16, 185, 129, 0.35);
}

.summary-value {
  margin-top: 14px;
  color: var(--navy);
  font-size: 32px;
  font-weight: 800;
  letter-spacing: -0.5px;
  line-height: 1.15;
}

.orange-text { color: #ea580c; }
.red-text { color: #e11d48; }
.green-text { color: #059669; }

.summary-description {
  margin-top: 7px;
  color: #94a3b8;
  font-size: 11.5px;
}

/* =========================================================
   KHU LÀM VIỆC
   ========================================================= */
.stock-workspace {
  overflow: hidden;
  border: 1px solid var(--line);
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
}

.workspace-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
  padding: 24px 26px;
}

.workspace-header h2 {
  margin: 0;
  color: var(--navy);
  font-size: 19px;
  font-weight: 800;
}

.workspace-header p {
  margin: 7px 0 0;
  color: var(--muted);
  font-size: 12.5px;
}

.workspace-main-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

/* tab */
.stock-tabs {
  display: flex;
  gap: 8px;
  padding: 0 26px 18px;
  border-bottom: 1px solid var(--line);
  overflow-x: auto;
}

.stock-tabs button {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 9px;
  flex-shrink: 0;
  padding: 11px 16px;
  border: 1.5px solid var(--line);
  border-radius: 11px;
  background: #fff;
  color: var(--muted);
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.28s var(--ease);
}

.stock-tabs button:hover:not(.active) {
  color: var(--primary);
  border-color: #c7d2fe;
  background: #eef2ff;
  transform: translateY(-2px);
}

.stock-tabs button.active {
  border-color: transparent;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.35);
}

/* bỏ gạch chân cũ */
.stock-tabs button.active::after { display: none; }

.tab-count {
  min-width: 24px;
  padding: 3px 8px;
  border-radius: 999px;
  background: rgba(100, 116, 139, 0.14);
  color: inherit;
  font-size: 11px;
  font-weight: 800;
  text-align: center;
}

.stock-tabs button.active .tab-count {
  background: rgba(255, 255, 255, 0.25);
}

.stock-tab-content {
  min-width: 0;
  padding: 22px 26px 18px;
}

/* =========================================================
   THANH LỌC
   ========================================================= */
.inventory-toolbar,
.history-filters {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.toolbar-search {
  display: flex;
  align-items: center;
  gap: 9px;
  flex: 1;
  min-width: 210px;
  height: 44px;
  padding: 0 14px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  color: var(--muted);
  background: #fff;
  transition: all 0.25s var(--ease);
}

.toolbar-search:hover { border-color: #c7d2fe; }

.toolbar-search:focus-within {
  color: var(--primary);
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.toolbar-search > i { font-size: 13px; }

.toolbar-search input {
  width: 100%;
  min-width: 0;
  height: 100%;
  padding: 0;
  border: 0;
  outline: none;
  color: var(--navy);
  background: transparent;
  font-size: 12.5px;
}

.toolbar-search input::placeholder { color: #94a3b8; }

.toolbar-search button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
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

.toolbar-search button:hover {
  color: #fff;
  background: #f43f5e;
  transform: rotate(90deg);
}

.filter-select,
.date-filter,
.small-filter {
  height: 44px;
  padding: 0 13px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  outline: none;
  background: var(--soft);
  color: var(--text);
  font-size: 12.5px;
  font-weight: 500;
  transition: all 0.25s var(--ease);
}

.filter-select { min-width: 160px; cursor: pointer; }
.date-filter { min-width: 140px; }
.small-filter { width: 90px; }

.filter-select:hover,
.date-filter:hover,
.small-filter:hover { border-color: #c7d2fe; }

.filter-select:focus,
.date-filter:focus,
.small-filter:focus {
  border-color: var(--primary);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.threshold-control {
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
}

.threshold-control label {
  color: var(--muted);
  font-size: 11.5px;
  font-weight: 600;
}

.threshold-control input {
  width: 62px;
  height: 40px;
  padding: 0 8px;
  border: 1.5px solid var(--line);
  border-radius: 10px;
  outline: none;
  background: var(--soft);
  font-size: 12.5px;
  font-weight: 700;
  text-align: center;
  transition: all 0.25s var(--ease);
}

.threshold-control input:focus {
  border-color: var(--primary);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.filter-reset,
.btn-search-filter {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  height: 44px;
  padding: 0 15px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  background: #fff;
  color: #475569;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
}

.filter-reset:hover {
  color: #e11d48;
  border-color: #fecdd3;
  background: #fff1f2;
  transform: translateY(-2px);
}

.btn-search-filter {
  border: 0;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 6px 14px rgba(79, 70, 229, 0.3);
}

.btn-search-filter:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(79, 70, 229, 0.42);
}

/* =========================================================
   BẢNG
   ========================================================= */
.table-responsive {
  width: 100%;
  overflow-x: auto;
}

.stock-table {
  width: 100%;
  min-width: 860px;
  border-collapse: separate;
  border-spacing: 0;
}

.stock-table thead th {
  padding: 15px 14px;
  color: #3730a3;
  background: linear-gradient(180deg, #eef2ff, #e0e7ff);
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.5px;
  text-align: left;
  white-space: nowrap;
}

.stock-table thead th:first-child { border-radius: 12px 0 0 12px; }
.stock-table thead th:last-child { border-radius: 0 12px 12px 0; }
.stock-table thead th.text-center { text-align: center; }

.stock-table td {
  padding: 14px;
  border-bottom: 1px solid #eef2f7;
  color: #475569;
  font-size: 12px;
  vertical-align: middle;
  transition: background 0.25s;
}

.stock-table tbody tr:hover td { background: #f5f7ff; }
.stock-table tbody tr:hover td:first-child { box-shadow: inset 4px 0 0 var(--primary); }

.text-center { text-align: center; }

.product-cell {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 200px;
}

.product-image {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  overflow: hidden;
  flex-shrink: 0;
  border: 1px solid var(--line);
  border-radius: 12px;
  background: #f8fafc;
  color: #94a3b8;
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}

.stock-table tbody tr:hover .product-image {
  transform: scale(1.12);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.2);
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  background: #fff;
}

.product-info,
.history-product,
.date-cell {
  display: flex;
  flex-direction: column;
  gap: 5px;
  min-width: 0;
}

.product-info strong,
.history-product strong {
  color: var(--navy);
  font-size: 12.5px;
  font-weight: 700;
  line-height: 1.45;
  transition: color 0.2s;
}

.stock-table tbody tr:hover .product-info strong,
.stock-table tbody tr:hover .history-product strong { color: var(--primary); }

.product-info span,
.history-product span {
  color: #94a3b8;
  font-size: 10.5px;
}

.product-code,
.history-code {
  display: inline-flex;
  padding: 5px 10px;
  border-radius: 8px;
  color: #4338ca;
  background: #e0e7ff;
  font-family: Consolas, monospace;
  font-size: 11.5px;
  font-weight: 800;
}

.quantity-main {
  color: var(--navy);
  font-size: 15px;
  font-weight: 800;
}

.quantity-held {
  color: var(--muted);
  font-weight: 600;
}

.quantity-available {
  color: #059669;
  font-size: 14px;
  font-weight: 800;
}

.quantity-low {
  color: #ea580c;
  font-size: 14px;
  font-weight: 800;
}

/* trạng thái tồn */
.stock-status,
.movement-badge {
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

.status-in {
  color: #047857;
  background: #d1fae5;
}

.status-in .status-dot { animation: pulseDot 1.8s ease-in-out infinite; }

.status-low {
  color: #b45309;
  background: #fef3c7;
}

.status-low .status-dot { animation: pulseDot 1.2s ease-in-out infinite; }

.status-out {
  color: #be123c;
  background: #ffe4e6;
}

.detail-button {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border: 0;
  border-radius: 10px;
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #2563eb);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.3);
  font-size: 11.5px;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
}

.detail-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(79, 70, 229, 0.45);
}

.detail-button:active { transform: scale(0.95); }

/* trạng thái tải / trống */
.table-state {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-height: 130px;
  color: var(--muted);
  font-size: 12.5px;
}

.table-state > i:first-child { color: var(--primary); }

.empty-state {
  flex-direction: column;
  gap: 8px;
}

.empty-state > i {
  display: grid;
  place-items: center;
  width: 68px;
  height: 68px;
  margin-bottom: 4px;
  border-radius: 50%;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 28px;
}

.empty-state strong {
  color: var(--navy);
  font-size: 14px;
  font-weight: 800;
}

.empty-state span { font-size: 11.5px; }

/* =========================================================
   LỊCH SỬ
   ========================================================= */
.history-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
  margin-bottom: 18px;
}

.history-heading h3,
.return-intro h3 {
  margin: 0;
  color: var(--navy);
  font-size: 16px;
  font-weight: 800;
}

.history-heading p,
.return-intro p {
  margin: 6px 0 0;
  color: var(--muted);
  font-size: 12px;
  line-height: 1.7;
}

.history-filters {
  padding: 14px;
  border: 1px solid var(--line);
  border-radius: 14px;
  background: #f8fafc;
}

.history-search { min-width: 210px; }
.history-table { min-width: 1060px; }

.date-cell strong {
  color: var(--muted);
  font-size: 11.5px;
  font-weight: 600;
  white-space: nowrap;
}

.movement-in {
  color: #047857;
  background: #d1fae5;
}

.movement-out {
  color: #be123c;
  background: #ffe4e6;
}

.history-reason {
  max-width: 210px;
  margin-top: 7px;
  overflow: hidden;
  color: #94a3b8;
  font-size: 10.5px;
  line-height: 1.5;
  text-overflow: ellipsis;
}

.history-quantity {
  font-size: 15px;
  font-weight: 800;
}

.positive { color: #059669 !important; }
.negative { color: #e11d48 !important; }

.link-code {
  display: inline-block;
  padding: 6px 11px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
}

.order-link {
  color: #1d4ed8;
  background: #dbeafe;
}

.return-link {
  color: #7e22ce;
  background: #f3e8ff;
}

.link-empty {
  color: #94a3b8;
  font-size: 11px;
}

.staff-cell {
  display: flex;
  align-items: center;
  gap: 9px;
  font-weight: 600;
  white-space: nowrap;
}

.staff-avatar {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
  font-size: 11px;
}

/* =========================================================
   PHÂN TRANG
   ========================================================= */
.table-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  margin-top: 6px;
  padding: 16px 0 2px;
  color: var(--muted);
  font-size: 12px;
}

.table-footer strong { color: var(--primary); }

.pagination-control {
  display: flex;
  align-items: center;
  gap: 12px;
}

.pagination-control button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border: 1.5px solid var(--line);
  border-radius: 10px;
  background: #fff;
  color: #475569;
  cursor: pointer;
  transition: all 0.25s var(--ease);
}

.pagination-control button:hover:not(:disabled) {
  color: #fff;
  border-color: transparent;
  background: var(--grad-primary);
  box-shadow: 0 6px 14px rgba(79, 70, 229, 0.35);
  transform: translateY(-2px);
}

.pagination-control button:disabled {
  color: #cbd5e1;
  background: #f8fafc;
}

.pagination-control span {
  padding: 6px 14px;
  border-radius: 999px;
  color: var(--primary);
  background: #e0e7ff;
  font-weight: 700;
  white-space: nowrap;
}

/* =========================================================
   HÀNG ĐỔI TRẢ
   ========================================================= */
.return-intro {
  display: flex;
  align-items: flex-start;
  gap: 15px;
  padding: 7px 0 22px;
}

.return-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 54px;
  height: 54px;
  flex-shrink: 0;
  border-radius: 16px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
  font-size: 21px;
}

.return-warning {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 22px;
  padding: 15px 17px;
  border: 1px solid #fde68a;
  border-left: 5px solid #f59e0b;
  border-radius: 12px;
  background: linear-gradient(135deg, #fffbeb, #fff);
  color: #b45309;
}

.return-warning > i {
  margin-top: 2px;
  font-size: 18px;
}

.return-warning div {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.return-warning strong {
  font-size: 12.5px;
  font-weight: 800;
}

.return-warning span {
  color: #92400e;
  font-size: 11.5px;
  line-height: 1.7;
}

.return-form-card {
  padding: 24px;
  border: 1px solid var(--line);
  border-radius: 16px;
  background: #fff;
  box-shadow: var(--shadow-sm);
}

.form-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
  margin-bottom: 23px;
}

.form-eyebrow {
  display: inline-flex;
  padding: 3px 10px;
  border-radius: 999px;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 9.5px;
  font-weight: 800;
  letter-spacing: 1.2px;
}

.form-heading h3 {
  margin: 8px 0 0;
  color: var(--navy);
  font-size: 16px;
  font-weight: 800;
}

.form-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  border-radius: 13px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 6px 14px rgba(79, 70, 229, 0.3);
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 19px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 0;
}

.form-group label {
  color: #334155;
  font-size: 12.5px;
  font-weight: 700;
}

.required { color: #f43f5e; }

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  min-width: 0;
  min-height: 46px;
  padding: 11px 14px;
  border: 1.5px solid var(--line);
  border-radius: 11px;
  outline: none;
  background: #f8fafc;
  color: var(--navy);
  font: inherit;
  font-size: 13px;
  transition: all 0.25s var(--ease);
}

.form-group textarea { resize: vertical; }

.form-group input:hover,
.form-group select:hover,
.form-group textarea:hover { border-color: #c7d2fe; }

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: var(--primary);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.form-group small {
  color: #94a3b8;
  font-size: 11px;
  line-height: 1.6;
}

.form-group small strong { color: var(--primary); }

.return-form-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
  flex-wrap: wrap;
  margin-top: 22px;
  padding-top: 20px;
  border-top: 1px solid var(--line);
}

.return-result-note {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  color: var(--muted);
  font-size: 11.5px;
  line-height: 1.6;
}

.return-result-note i { color: var(--primary); }

/* =========================================================
   MODAL
   ========================================================= */
.stock-modal-overlay {
  position: fixed;
  z-index: 3000;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow-y: auto;
  padding: 18px;
  background: rgba(15, 23, 42, 0.55);
  backdrop-filter: blur(4px);
  animation: overlayIn 0.25s ease both;
}

.stock-modal {
  width: min(100%, 540px);
  max-height: calc(100vh - 36px);
  overflow-y: auto;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 30px 80px rgba(15, 23, 42, 0.3);
  animation: modalIn 0.4s var(--ease) both;
}

.modal-heading {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 15px;
  padding: 24px 26px;
  background: var(--grad-primary);
}

.modal-heading .form-eyebrow {
  color: #fff;
  background: rgba(255, 255, 255, 0.22);
}

.modal-heading h3 {
  margin: 9px 0 0;
  color: #fff;
  font-size: 20px;
  font-weight: 800;
}

.modal-heading p {
  margin: 7px 0 0;
  color: rgba(255, 255, 255, 0.85);
  font-size: 12px;
  line-height: 1.5;
}

.modal-close {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 36px;
  height: 36px;
  flex-shrink: 0;
  border: 0;
  border-radius: 50%;
  color: #fff;
  background: rgba(255, 255, 255, 0.2);
  cursor: pointer;
  transition: transform 0.3s var(--ease), background 0.2s;
}

.modal-close:hover {
  background: rgba(255, 255, 255, 0.35);
  transform: rotate(90deg);
}

.modal-body {
  display: flex;
  flex-direction: column;
  gap: 18px;
  padding: 24px 26px;
}

.modal-warning {
  display: flex;
  gap: 10px;
  padding: 13px 15px;
  border-left: 5px solid #f59e0b;
  border-radius: 0 12px 12px 0;
  background: #fffbeb;
  color: #92400e;
  font-size: 11.5px;
  line-height: 1.7;
}

.modal-warning > i { margin-top: 2px; color: #f59e0b; }

.stocktake-preview {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 10px;
  padding: 14px;
  border: 1px solid #c7d2fe;
  border-radius: 14px;
  background: linear-gradient(135deg, #eef2ff, #f8faff);
}

.stocktake-preview div {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.stocktake-preview span {
  color: var(--primary);
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.stocktake-preview strong {
  color: var(--navy);
  font-size: 19px;
  font-weight: 800;
}

.form-error {
  display: flex;
  gap: 9px;
  margin: 0 26px 10px;
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

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  padding: 16px 26px 22px;
  border-top: 1px solid var(--line);
}

.btn-cancel {
  min-height: 42px;
  padding: 0 20px;
  border: 1.5px solid var(--line);
  border-radius: 11px;
  background: #fff;
  color: #475569;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
}

.btn-cancel:hover:not(:disabled) {
  color: var(--primary);
  border-color: #c7d2fe;
  background: #eef2ff;
  transform: translateY(-2px);
}

/* =========================================================
   MODAL CHI TIẾT
   ========================================================= */
.detail-modal { width: min(100%, 640px); }

.detail-modal-body { padding: 24px; }

.detail-product {
  display: flex;
  align-items: center;
  gap: 15px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--line);
}

.detail-product-image {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 64px;
  height: 64px;
  overflow: hidden;
  flex-shrink: 0;
  border: 1px solid var(--line);
  border-radius: 16px;
  background: #f8fafc;
  color: #94a3b8;
  font-size: 22px;
}

.detail-product-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.detail-product h4 {
  margin: 0 0 7px;
  color: var(--navy);
  font-size: 15px;
  font-weight: 800;
}

.detail-product span {
  display: inline-flex;
  padding: 3px 10px;
  border-radius: 999px;
  color: #4338ca;
  background: #e0e7ff;
  font-size: 11px;
  font-weight: 700;
}

.detail-stat-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 12px;
  margin: 20px 0 24px;
}

.detail-stat-grid > div {
  display: flex;
  flex-direction: column;
  gap: 9px;
  padding: 15px;
  border: 1px solid var(--line);
  border-radius: 14px;
  background: #f8fafc;
  transition: all 0.25s var(--ease);
}

.detail-stat-grid > div:hover {
  border-color: #c7d2fe;
  background: #f5f7ff;
  transform: translateY(-3px);
}

.detail-stat-grid span {
  color: var(--primary);
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.detail-stat-grid strong {
  color: var(--navy);
  font-size: 22px;
  font-weight: 800;
}

.detail-history-title {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0 0 13px;
  color: var(--navy);
  font-size: 13px;
  font-weight: 800;
}

.detail-history-title::before {
  content: "";
  width: 4px;
  height: 17px;
  border-radius: 4px;
  background: var(--grad-primary);
}

.detail-history-list {
  max-height: 300px;
  overflow-y: auto;
  border: 1px solid var(--line);
  border-radius: 14px;
}

.detail-history-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 13px 16px;
  border-bottom: 1px solid #eef2f7;
  transition: background 0.2s;
}

.detail-history-item:last-child { border-bottom: 0; }
.detail-history-item:hover { background: #f5f7ff; }

.detail-history-item > div {
  display: flex;
  flex-direction: column;
  gap: 4px;
  min-width: 0;
}

.detail-history-item > div > strong {
  color: var(--navy);
  font-size: 12px;
  font-weight: 700;
}

.detail-history-item span {
  color: var(--muted);
  font-size: 10.5px;
  line-height: 1.5;
  overflow-wrap: anywhere;
}

.detail-history-item small {
  color: #94a3b8;
  font-size: 10px;
}

.detail-history-item > strong {
  flex-shrink: 0;
  font-size: 15px;
  font-weight: 800;
}

.detail-loading,
.detail-empty {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  min-height: 120px;
  color: var(--muted);
  font-size: 12.5px;
}

.detail-loading i { color: var(--primary); }

/* thanh cuộn gọn */
.table-responsive::-webkit-scrollbar,
.stock-tabs::-webkit-scrollbar,
.detail-history-list::-webkit-scrollbar,
.stock-modal::-webkit-scrollbar { width: 8px; height: 8px; }

.table-responsive::-webkit-scrollbar-thumb,
.stock-tabs::-webkit-scrollbar-thumb,
.detail-history-list::-webkit-scrollbar-thumb,
.stock-modal::-webkit-scrollbar-thumb {
  border-radius: 8px;
  background: #c7d2fe;
}

.table-responsive::-webkit-scrollbar-thumb:hover,
.stock-tabs::-webkit-scrollbar-thumb:hover,
.detail-history-list::-webkit-scrollbar-thumb:hover,
.stock-modal::-webkit-scrollbar-thumb:hover { background: #818cf8; }

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 1100px) {
  .stock-summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .threshold-control { order: 4; }
}

@media (max-width: 768px) {
  .ts-stock-page { padding: 16px; }
  .stock-page-header { align-items: flex-start; }
  .stock-page-header h1 { font-size: 25px; }
  .workspace-header { align-items: flex-start; padding: 18px; }
  .workspace-main-actions { width: 100%; }
  .workspace-main-actions .action-btn { flex: 1; padding: 0 10px; }
  .stock-tabs { padding: 0 17px 15px; }
  .stock-tab-content { padding: 17px; }
  .form-grid { grid-template-columns: 1fr; }
  .history-filters > * { flex: 1 1 130px; min-width: 0; }
  .history-filters .history-search { flex-basis: 100%; }
  .table-footer { align-items: flex-start; flex-direction: column; }
  .return-form-footer { align-items: stretch; flex-direction: column; }
  .return-form-footer .action-btn { width: 100%; }
}

@media (max-width: 480px) {
  .stock-summary-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
  .summary-card { padding: 14px; }
  .summary-icon { width: 38px; height: 38px; border-radius: 12px; font-size: 16px; }
  .summary-value { font-size: 25px; }
  .summary-label { font-size: 10.5px; }
  .warehouse-location { flex-wrap: wrap; }
  .stocktake-preview { grid-template-columns: 1fr; }
  .detail-stat-grid { grid-template-columns: 1fr; }
  .modal-heading { padding: 20px 18px; }
  .modal-body { padding: 20px 18px; }
  .modal-footer { padding: 14px 18px 18px; }
  .form-error { margin: 0 18px 10px; }
}

/* Tôn trọng người dùng tắt hiệu ứng chuyển động */
@media (prefers-reduced-motion: reduce) {
  .ts-stock-page *,
  .ts-stock-page *::before,
  .ts-stock-page *::after {
    animation: none !important;
    transition: none !important;
  }
}
</style>