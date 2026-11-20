

<template>
  <div class="product-page">
    <!-- TIÊU ĐỀ -->
    <div class="page-heading">
      <div>
        <h1>Quản lý sản phẩm</h1>
        <p>Thêm, sửa, xóa và quản lý tất cả sản phẩm trong cửa hàng của bạn.</p>
      </div>

      <button class="primary-btn" type="button" @click="moThem">
        <i class="fa-solid fa-plus"></i>
        Thêm sản phẩm
      </button>
    </div>

    <!-- THỐNG KÊ -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon icon-blue">
          <i class="fa-solid fa-cube"></i>
        </div>
        <div class="stat-info">
          <span>Tổng sản phẩm</span>
          <strong>{{ danhSach.length }}</strong>
          <small>Toàn bộ sản phẩm</small>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-green">
          <i class="fa-solid fa-tag"></i>
        </div>
        <div class="stat-info">
          <span>Đang bán</span>
          <strong>{{ soLuongDangBan }}</strong>
          <small>Sản phẩm còn hàng</small>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-orange">
          <i class="fa-solid fa-box-open"></i>
        </div>
        <div class="stat-info">
          <span>Hết hàng</span>
          <strong>{{ soLuongHetHang }}</strong>
          <small>Cần bổ sung hàng</small>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-purple">
          <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div class="stat-info">
          <span>Tổng doanh thu (tháng)</span>
          <strong>—</strong>
          <small>Chưa có dữ liệu doanh thu</small>
        </div>
      </div>
    </div>

    <!-- BẢNG SẢN PHẨM -->
    <div class="product-panel">
      <div class="toolbar">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input
            v-model="tuKhoa"
            type="text"
            placeholder="Tìm kiếm sản phẩm..."
          />

          <button
            v-if="tuKhoa"
            type="button"
            class="clear-search"
            @click="tuKhoa = ''"
            aria-label="Xóa tìm kiếm"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <label class="filter-box">
          <span>Danh mục</span>
          <select v-model="locDanhMuc">
            <option value="">Tất cả danh mục</option>
            <option
              v-for="dm in danhMucs"
              :key="dm.MaDM"
              :value="String(dm.MaDM)"
            >
              {{ dm.TenDM }}
            </option>
          </select>
        </label>

        <label class="filter-box">
          <span>Trạng thái</span>
          <select v-model="locTrangThai">
            <option value="">Tất cả</option>
            <option value="DangBan">Đang bán</option>
            <option value="HetHang">Hết hàng</option>
            <option value="NgungBan">Ngừng kinh doanh</option>
          </select>
        </label>

        <div class="view-buttons">
          <button
            type="button"
            :class="{ active: kieuHienThi === 'grid' }"
            title="Xem dạng thẻ"
            aria-label="Xem dạng thẻ"
            @click="kieuHienThi = 'grid'"
          >
            <i class="fa-solid fa-grip"></i>
          </button>

          <button
            type="button"
            :class="{ active: kieuHienThi === 'table' }"
            title="Xem dạng bảng"
            aria-label="Xem dạng bảng"
            @click="kieuHienThi = 'table'"
          >
            <i class="fa-solid fa-table-cells"></i>
          </button>
        </div>
      </div>

      <!-- CHẾ ĐỘ BẢNG -->
      <div v-if="kieuHienThi === 'table'" class="table-wrap">
        <table class="product-table">
          <thead>
            <tr>
              <th class="check-column">
                <input
                  type="checkbox"
                  :checked="tatCaTrangDuocChon"
                  @change="chonTatCa"
                  aria-label="Chọn tất cả sản phẩm trên trang"
                />
              </th>
              <th>STT</th>
              <th>Hình ảnh</th>
              <th>Tên sản phẩm</th>
              <th>Danh mục</th>
              <th>Thương hiệu</th>
              <th>Bảo hành</th>
              <th>Giá bán</th>
              <th>Trạng thái</th>
              <th>Tồn kho</th>
              <th>Thao tác</th>
            </tr>
          </thead>

          <tbody v-if="sanPhamTrang.length">
            <tr v-for="(sp, index) in sanPhamTrang" :key="sp.MaSP">
              <td class="check-column">
                <input
                  type="checkbox"
                  :checked="dsDaChon.includes(sp.MaSP)"
                  @change="chonMot(sp.MaSP, $event.target.checked)"
                  :aria-label="'Chọn ' + sp.TenSP"
                />
              </td>

              <td>{{ (trangHienTai - 1) * soDong + index + 1 }}</td>

              <td>
                <div class="product-image">
                  <img
                    v-if="sp.HinhAnh"
                    :src="sp.HinhAnh"
                    :alt="sp.TenSP"
                    @error="xuLyLoiAnh"
                  />
                  <i v-else class="fa-solid fa-image image-placeholder"></i>
                </div>
              </td>

              <td>
                <div class="product-name">{{ sp.TenSP }}</div>
                <div class="product-code">Mã: {{ sp.MaSP }}</div>
              </td>

              <td>
                <span class="category-badge">
                  {{ tenDanhMuc(sp.MaDM) }}
                </span>
              </td>

              <td>{{ sp.ThuongHieu || "Chưa cập nhật" }}</td>

              <td>
  <span
    class="warranty-badge"
    :class="{ 'warranty-none': !coBaoHanh(sp) }"
    :title="chiTietBaoHanh(sp)"
  >
    <i class="fa-solid fa-shield-halved"></i>
    {{ hienThiBaoHanh(sp) }}
  </span>
</td>

              <td class="price-cell">
                {{ dinhDangTien(sp.GiaBan) }}
              </td>

              <td>
                <span
                  class="status-badge"
                  :class="{
                    'status-selling':
                      sp.TrangThaiSP === 'DangBan' &&
                      Number(sp.SoLuongTon) > 0,
                    'status-empty':
                      sp.TrangThaiSP !== 'NgungBan' &&
                      Number(sp.SoLuongTon) <= 0,
                    'status-stopped': sp.TrangThaiSP === 'NgungBan',
                  }"
                >
                  {{
                    sp.TrangThaiSP === "NgungBan"
                      ? "Ngừng kinh doanh"
                      : Number(sp.SoLuongTon) <= 0
                      ? "Hết hàng"
                      : "Đang bán"
                  }}
                </span>
              </td>

              <td>{{ sp.SoLuongTon ?? 0 }}</td>

              <td>
                <div class="action-buttons">
                  <button
                    class="action-btn edit-btn"
                    type="button"
                    title="Sửa sản phẩm"
                    aria-label="Sửa sản phẩm"
                    @click="moSua(sp)"
                  >
                    <i class="fa-solid fa-pen"></i>
                  </button>

                  <button
                    class="action-btn delete-btn"
                    type="button"
                    title="Xóa sản phẩm"
                    aria-label="Xóa sản phẩm"
                    @click="moXoa(sp)"
                  >
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr>
              <td colspan="11" class="empty-state">
                <i class="fa-solid fa-box-open"></i>
                <p>Không tìm thấy sản phẩm phù hợp.</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- CHẾ ĐỘ THẺ -->
      <div v-else class="product-cards">
        <div v-if="sanPhamTrang.length === 0" class="empty-state">
          <i class="fa-solid fa-box-open"></i>
          <p>Không tìm thấy sản phẩm phù hợp.</p>
        </div>

        <article
          v-for="sp in sanPhamTrang"
          :key="sp.MaSP"
          class="product-card"
        >
          <div class="card-product-image">
            <img
              v-if="sp.HinhAnh"
              :src="sp.HinhAnh"
              :alt="sp.TenSP"
              @error="xuLyLoiAnh"
            />
            <i v-else class="fa-solid fa-image image-placeholder"></i>
          </div>

          <div class="card-product-info">
            <span class="category-badge">
              {{ tenDanhMuc(sp.MaDM) }}
            </span>

            <h3>{{ sp.TenSP }}</h3>
            <p>Mã sản phẩm: {{ sp.MaSP }}</p>
            <p>Thương hiệu: {{ sp.ThuongHieu || "Chưa cập nhật" }}</p>
            <p>
  Bảo hành:
  <span
    class="warranty-badge"
    :class="{ 'warranty-none': !coBaoHanh(sp) }"
    :title="chiTietBaoHanh(sp)"
  >
    {{ hienThiBaoHanh(sp) }}
  </span>
</p>
            <strong>{{ dinhDangTien(sp.GiaBan) }}</strong>

            <div class="card-product-bottom">
              <span
                class="status-badge"
                :class="{
                  'status-selling':
                    sp.TrangThaiSP === 'DangBan' &&
                    Number(sp.SoLuongTon) > 0,
                  'status-empty':
                    sp.TrangThaiSP !== 'NgungBan' &&
                    Number(sp.SoLuongTon) <= 0,
                  'status-stopped': sp.TrangThaiSP === 'NgungBan',
                }"
              >
                {{
                  sp.TrangThaiSP === "NgungBan"
                    ? "Ngừng kinh doanh"
                    : Number(sp.SoLuongTon) <= 0
                    ? "Hết hàng"
                    : "Đang bán"
                }}
              </span>

              <span>Tồn: {{ sp.SoLuongTon ?? 0 }}</span>
            </div>

            <div class="card-actions">
              <button
                class="primary-btn small-btn"
                type="button"
                @click="moSua(sp)"
              >
                <i class="fa-solid fa-pen"></i> Sửa
              </button>

              <button
                class="danger-btn small-btn"
                type="button"
                @click="moXoa(sp)"
              >
                <i class="fa-solid fa-trash"></i> Xóa
              </button>
            </div>
          </div>
        </article>
      </div>

      <!-- PHÂN TRANG -->
      <div class="table-footer">
        <span>
          Hiển thị
          {{ tongSanPham ? (trangHienTai - 1) * soDong + 1 : 0 }}
          -
          {{ Math.min(trangHienTai * soDong, tongSanPham) }}
          trên {{ tongSanPham }} sản phẩm
        </span>

        <div class="pagination">
          <button
            type="button"
            :disabled="trangHienTai === 1"
            @click="doiTrang(trangHienTai - 1)"
            aria-label="Trang trước"
          >
            <i class="fa-solid fa-chevron-left"></i>
          </button>

          <button
            v-for="trang in tongTrang"
            :key="trang"
            type="button"
            :class="{ active: trangHienTai === trang }"
            @click="doiTrang(trang)"
          >
            {{ trang }}
          </button>

          <button
            type="button"
            :disabled="trangHienTai === tongTrang"
            @click="doiTrang(trangHienTai + 1)"
            aria-label="Trang sau"
          >
            <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- ================================================= -->
    <!-- MODAL THÊM SẢN PHẨM -->
    <!-- ================================================= -->
    <div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content custom-modal">
          <div class="modal-header">
            <div>
              <h5 class="modal-title">Thêm sản phẩm</h5>
              <p>Nhập thông tin và thông số chi tiết sản phẩm mới</p>
            </div>
            <button
              class="btn-close"
              type="button"
              data-bs-dismiss="modal"
            ></button>
          </div>

          <div class="modal-body">
            <!-- THÔNG TIN CƠ BẢN -->
            <div class="form-grid">
              <label class="form-field">
                <span>Tên sản phẩm <b>*</b></span>
                <input
                  v-model="spMoi.TenSP"
                  class="form-control"
                  placeholder="Nhập tên sản phẩm"
                />
              </label>

              <label class="form-field">
                <span>Giá bán <b>*</b></span>
                <input
                  v-model="spMoi.GiaBan"
                  type="number"
                  min="0"
                  class="form-control"
                  placeholder="Nhập giá bán"
                />
              </label>

              <label class="form-field">
                <span>Link hình ảnh đại diện</span>
                <input
                  v-model="spMoi.HinhAnh"
                  class="form-control"
                  placeholder="https://..."
                />
              </label>

              <label class="form-field">
                <span>Số lượng tồn</span>
                <input
                  v-model="spMoi.SoLuongTon"
                  type="number"
                  min="0"
                  class="form-control"
                  placeholder="Nhập số lượng"
                />
              </label>

              <label class="form-field">
                <span>Trạng thái</span>
                <select
                  v-model="spMoi.TrangThaiSP"
                  class="form-select"
                >
                  <option value="">Tự động theo tồn kho</option>
                  <option value="DangBan">Đang bán</option>
                  <option value="HetHang">Hết hàng</option>
                </select>
              </label>

              <label class="form-field">
                <span>Mã danh mục <b>*</b></span>
                <input
                  v-model="spMoi.MaDM"
                  type="number"
                  min="1"
                  class="form-control"
                  placeholder="Nhập mã danh mục"
                />
              </label>

              <label class="form-field">
                <span>Thương hiệu</span>
                <input
                  v-model="spMoi.ThuongHieu"
                  class="form-control"
                  placeholder="VD: ASUS, Dell, Apple..."
                />
              </label>

              <label class="form-field">
                <span>Link ảnh thương hiệu</span>
                <input
                  v-model="spMoi.AnhThuongHieu"
                  class="form-control"
                  placeholder="https://..."
                />
              </label>
            </div>

            <!-- CHÍNH SÁCH BẢO HÀNH -->
            <div class="detail-form-section">
              <div class="detail-section-heading">
                <div>
                  <h6>Chính sách bảo hành</h6>
                  <p>Để trống cả 3 trường nếu sản phẩm không áp dụng bảo hành. Nếu đã nhập, cần điền đủ cả 3 trường.</p>
                </div>
              </div>

              <div class="form-grid">
                <label class="form-field">
                  <span>Tổng thời hạn bảo hành (tháng)</span>
                  <input
                    v-model="spMoi.ThoiHanBaoHanhThang"
                    type="number"
                    min="0"
                    step="1"
                    class="form-control"
                    placeholder="VD: 36"
                  />
                </label>

                <label class="form-field">
                  <span>Thời hạn hỗ trợ miễn phí (tháng)</span>
                  <input
                    v-model="spMoi.ThoiHanMienPhiThang"
                    type="number"
                    min="0"
                    step="1"
                    class="form-control"
                    placeholder="VD: 24"
                  />
                </label>

                <label class="form-field">
                  <span>Tỷ lệ shop hỗ trợ sau thời gian miễn phí (%)</span>
                  <input
                    v-model="spMoi.TyLeShopHoTro"
                    type="number"
                    min="0"
                    max="100"
                    step="1"
                    class="form-control"
                    placeholder="VD: 20"
                  />
                </label>
              </div>
            </div>

            <!-- THÔNG TIN CHI TIẾT -->
            <div class="detail-form-section">
              <div class="detail-section-heading">
                <div>
                  <h6>Thông số kỹ thuật</h6>
                  <p>Thêm thông số phù hợp với từng loại sản phẩm.</p>
                </div>

                <button
                  type="button"
                  class="primary-btn small-btn"
                  @click="themDongThongSo('spMoi')"
                >
                  <i class="fa-solid fa-plus"></i>
                  Thêm thông số
                </button>
              </div>

              <div
                v-for="(dong, index) in spMoi.ThongSo"
                :key="index"
                class="spec-row"
              >
                <input
                  v-model="dong.ten"
                  class="form-control"
                  placeholder="Tên thông số (VD: CPU)"
                />

                <input
                  v-model="dong.giaTri"
                  class="form-control"
                  placeholder="Giá trị (VD: Intel Core i5)"
                />

                <button
                  type="button"
                  class="remove-spec-btn"
                  @click="xoaDongThongSo('spMoi', index)"
                  title="Xóa thông số"
                >
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>

              <div class="detail-field">
                <label>Mô tả chi tiết</label>
                <textarea
                  v-model="spMoi.MoTaChiTiet"
                  class="form-control"
                  rows="4"
                  placeholder="Nhập mô tả chi tiết về sản phẩm..."
                ></textarea>
              </div>

              <div class="detail-field">
                <label>Hình ảnh chi tiết</label>
                <textarea
                  v-model="spMoi.HinhAnhChiTietText"
                  class="form-control"
                  rows="3"
                  placeholder="Nhập link ảnh, mỗi link một dòng..."
                ></textarea>
                <small>Nhập mỗi đường dẫn ảnh trên một dòng.</small>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button
              class="secondary-btn"
              type="button"
              data-bs-dismiss="modal"
            >
              Hủy
            </button>

            <button
              class="primary-btn"
              type="button"
              :disabled="dangXuLy"
              @click="themSP"
            >
              <i class="fa-solid fa-plus"></i>
              {{ dangXuLy ? "Đang xử lý..." : "Thêm sản phẩm" }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ================================================= -->
    <!-- MODAL SỬA SẢN PHẨM -->
    <!-- ================================================= -->
    <div class="modal fade" id="updateModal" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content custom-modal">
          <div class="modal-header">
            <div>
              <h5 class="modal-title">Cập nhật sản phẩm</h5>
              <p>Chỉnh sửa thông tin và thông số chi tiết sản phẩm</p>
            </div>
            <button
              class="btn-close"
              type="button"
              data-bs-dismiss="modal"
            ></button>
          </div>

          <div class="modal-body">
            <!-- THÔNG TIN CƠ BẢN -->
            <div class="form-grid">
              <label class="form-field">
                <span>Mã sản phẩm</span>
                <input
                  v-model="spSua.MaSP"
                  class="form-control"
                  readonly
                />
              </label>

              <label class="form-field">
                <span>Tên sản phẩm <b>*</b></span>
                <input
                  v-model="spSua.TenSP"
                  class="form-control"
                  placeholder="Nhập tên sản phẩm"
                />
              </label>

              <label class="form-field">
                <span>Giá bán <b>*</b></span>
                <input
                  v-model="spSua.GiaBan"
                  type="number"
                  min="0"
                  class="form-control"
                  placeholder="Nhập giá bán"
                />
              </label>

              <label class="form-field">
                <span>Link hình ảnh đại diện</span>
                <input
                  v-model="spSua.HinhAnh"
                  class="form-control"
                  placeholder="https://..."
                />
              </label>

              <label class="form-field">
                <span>Số lượng tồn</span>
                <input
                  v-model="spSua.SoLuongTon"
                  type="number"
                  min="0"
                  class="form-control"
                  placeholder="Nhập số lượng"
                />
              </label>

              <label class="form-field">
                <span>Trạng thái</span>
                <select
                  v-model="spSua.TrangThaiSP"
                  class="form-select"
                >
                  <option value="DangBan">Đang bán</option>
                  <option value="HetHang">Hết hàng</option>
                  <option value="NgungBan">Ngừng kinh doanh</option>
                </select>
              </label>

              <label class="form-field">
                <span>Mã danh mục <b>*</b></span>
                <input
                  v-model="spSua.MaDM"
                  type="number"
                  min="1"
                  class="form-control"
                  placeholder="Nhập mã danh mục"
                />
              </label>

              <label class="form-field">
                <span>Thương hiệu</span>
                <input
                  v-model="spSua.ThuongHieu"
                  class="form-control"
                  placeholder="VD: ASUS, Dell, Apple..."
                />
              </label>

              <label class="form-field">
                <span>Link ảnh thương hiệu</span>
                <input
                  v-model="spSua.AnhThuongHieu"
                  class="form-control"
                  placeholder="https://..."
                />
              </label>
            </div>

            <!-- CHÍNH SÁCH BẢO HÀNH -->
            <div class="detail-form-section">
              <div class="detail-section-heading">
                <div>
                  <h6>Chính sách bảo hành</h6>
                  <p>Để trống cả 3 trường nếu sản phẩm không áp dụng bảo hành. Nếu đã nhập, cần điền đủ cả 3 trường.</p>
                </div>
              </div>

              <div class="form-grid">
                <label class="form-field">
                  <span>Tổng thời hạn bảo hành (tháng)</span>
                  <input
                    v-model="spSua.ThoiHanBaoHanhThang"
                    type="number"
                    min="0"
                    step="1"
                    class="form-control"
                    placeholder="VD: 36"
                  />
                </label>

                <label class="form-field">
                  <span>Thời hạn hỗ trợ miễn phí (tháng)</span>
                  <input
                    v-model="spSua.ThoiHanMienPhiThang"
                    type="number"
                    min="0"
                    step="1"
                    class="form-control"
                    placeholder="VD: 24"
                  />
                </label>

                <label class="form-field">
                  <span>Tỷ lệ shop hỗ trợ sau thời gian miễn phí (%)</span>
                  <input
                    v-model="spSua.TyLeShopHoTro"
                    type="number"
                    min="0"
                    max="100"
                    step="1"
                    class="form-control"
                    placeholder="VD: 20"
                  />
                </label>
              </div>
            </div>

            <!-- THÔNG TIN CHI TIẾT -->
            <div class="detail-form-section">
              <div class="detail-section-heading">
                <div>
                  <h6>Thông số kỹ thuật</h6>
                  <p>Chỉnh sửa thông số kỹ thuật của sản phẩm.</p>
                </div>

                <button
                  type="button"
                  class="primary-btn small-btn"
                  @click="themDongThongSo('spSua')"
                >
                  <i class="fa-solid fa-plus"></i>
                  Thêm thông số
                </button>
              </div>

              <div
                v-for="(dong, index) in spSua.ThongSo"
                :key="index"
                class="spec-row"
              >
                <input
                  v-model="dong.ten"
                  class="form-control"
                  placeholder="Tên thông số (VD: RAM)"
                />

                <input
                  v-model="dong.giaTri"
                  class="form-control"
                  placeholder="Giá trị (VD: 16GB DDR5)"
                />

                <button
                  type="button"
                  class="remove-spec-btn"
                  @click="xoaDongThongSo('spSua', index)"
                  title="Xóa thông số"
                >
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>

              <div class="detail-field">
                <label>Mô tả chi tiết</label>
                <textarea
                  v-model="spSua.MoTaChiTiet"
                  class="form-control"
                  rows="4"
                  placeholder="Nhập mô tả chi tiết về sản phẩm..."
                ></textarea>
              </div>

              <div class="detail-field">
                <label>Hình ảnh chi tiết</label>
                <textarea
                  v-model="spSua.HinhAnhChiTietText"
                  class="form-control"
                  rows="3"
                  placeholder="Nhập link ảnh, mỗi link một dòng..."
                ></textarea>
                <small>Nhập mỗi đường dẫn ảnh trên một dòng.</small>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button
              class="secondary-btn"
              type="button"
              data-bs-dismiss="modal"
            >
              Hủy
            </button>

            <button
              class="primary-btn"
              type="button"
              :disabled="dangXuLy"
              @click="luuSua"
            >
              <i class="fa-solid fa-check"></i>
              {{ dangXuLy ? "Đang xử lý..." : "Lưu thay đổi" }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ================================================= -->
    <!-- MODAL XÓA SẢN PHẨM -->
    <!-- ================================================= -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
          <div class="modal-header">
            <h5 class="modal-title">Xác nhận xóa</h5>
            <button
              class="btn-close"
              type="button"
              data-bs-dismiss="modal"
            ></button>
          </div>

          <div class="modal-body delete-confirm">
            <div class="delete-icon">
              <i class="fa-solid fa-trash"></i>
            </div>

            <p>Bạn có chắc muốn xóa sản phẩm này không?</p>

            <strong v-if="spXoa">{{ spXoa.TenSP }}</strong>

            <small>Thao tác này không thể hoàn tác.</small>
          </div>

          <div class="modal-footer">
            <button
              class="secondary-btn"
              type="button"
              data-bs-dismiss="modal"
            >
              Hủy
            </button>

            <button
              class="danger-btn"
              type="button"
              :disabled="dangXuLy"
              @click="xoaSP"
            >
              <i class="fa-solid fa-trash"></i>
              {{ dangXuLy ? "Đang xử lý..." : "Xóa sản phẩm" }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api";

export default {
  name: "QuanLySanPham",

  data() {
    return {
      danhSach: [],
      danhMucs: [],

      spMoi: this.taoFormMoi(),

      spSua: {
        ThuongHieu: "",
        AnhThuongHieu: "",
        ThoiHanBaoHanhThang: "",
        ThoiHanMienPhiThang: "",
        TyLeShopHoTro: "",
        ThongSo: [{ ten: "", giaTri: "" }],
        MoTaChiTiet: "",
        HinhAnhChiTietText: "",
      },

      spXoa: null,

      tuKhoa: "",
      locDanhMuc: "",
      locTrangThai: "",
      kieuHienThi: "table",

      trangHienTai: 1,
      soDong: 8,
      dsDaChon: [],
      dangXuLy: false,
    };
  },

  computed: {
    soLuongDangBan() {
      return this.danhSach.filter(
        (sp) => Number(sp.SoLuongTon) > 0
      ).length;
    },

    soLuongHetHang() {
      return this.danhSach.filter(
        (sp) => Number(sp.SoLuongTon) <= 0
      ).length;
    },

    sanPhamLoc() {
      const keyword = this.tuKhoa.trim().toLowerCase();

      return this.danhSach.filter((sp) => {
        const khopTuKhoa =
          !keyword ||
          String(sp.MaSP ?? "").toLowerCase().includes(keyword) ||
          String(sp.TenSP ?? "").toLowerCase().includes(keyword) ||
          String(sp.ThuongHieu ?? "").toLowerCase().includes(keyword);

        const khopDanhMuc =
          !this.locDanhMuc ||
          String(sp.MaDM) === this.locDanhMuc;

        let trangThai;

        if (sp.TrangThaiSP === "NgungBan") {
          trangThai = "NgungBan";
        } else if (Number(sp.SoLuongTon) <= 0) {
          trangThai = "HetHang";
        } else {
          trangThai = "DangBan";
        }

        const khopTrangThai =
          !this.locTrangThai ||
          trangThai === this.locTrangThai;

        return khopTuKhoa && khopDanhMuc && khopTrangThai;
      });
    },

    tongSanPham() {
      return this.sanPhamLoc.length;
    },

    tongTrang() {
      return Math.max(
        1,
        Math.ceil(this.tongSanPham / this.soDong)
      );
    },

    sanPhamTrang() {
      const start = (this.trangHienTai - 1) * this.soDong;

      return this.sanPhamLoc.slice(
        start,
        start + this.soDong
      );
    },

    tatCaTrangDuocChon() {
      return (
        this.sanPhamTrang.length > 0 &&
        this.sanPhamTrang.every((sp) =>
          this.dsDaChon.includes(sp.MaSP)
        )
      );
    },
  },

  watch: {
    tuKhoa() {
      this.trangHienTai = 1;
    },

    locDanhMuc() {
      this.trangHienTai = 1;
    },

    locTrangThai() {
      this.trangHienTai = 1;
    },

    tongTrang(moi) {
      if (this.trangHienTai > moi) {
        this.trangHienTai = moi;
      }
    },
  },

  mounted() {
    this.getDanhMuc();
    this.getData();
  },

  methods: {
    // Tạo form trống khi thêm sản phẩm
    taoFormMoi() {
      return {
        TenSP: "",
        HinhAnh: "",
        GiaBan: "",
        SoLuongTon: 0,
        TrangThaiSP: "",
        MaDM: "",
        ThuongHieu: "",
        AnhThuongHieu: "",
        ThoiHanBaoHanhThang: "",
        ThoiHanMienPhiThang: "",
        TyLeShopHoTro: "",

        ThongSo: [{ ten: "", giaTri: "" }],
        MoTaChiTiet: "",
        HinhAnhChiTietText: "",
      };
    },

    // Lấy token Admin
    layTokenAdmin() {
      return localStorage.getItem("admin_token");
    },

    // Cấu hình xác thực cho API Admin
    cauHinhAuth() {
      const token = this.layTokenAdmin();

      if (!token) {
        alert("Không tìm thấy token Admin. Vui lòng đăng nhập lại.");
        return null;
      }

      return {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };
    },

    // Lấy danh sách danh mục
    async getDanhMuc() {
      const config = this.cauHinhAuth();

      if (!config) return;

      try {
        const res = await axios.get(
          `${API_URL}/danh-muc/get-data`,
          config
        );

        if (res.data.status) {
          this.danhMucs = res.data.data || [];
        }
      } catch (error) {
        console.error(
          "Lỗi lấy danh mục:",
          error.response?.data || error
        );
      }
    },

    // Lấy tên danh mục
    tenDanhMuc(maDM) {
      const danhMuc = this.danhMucs.find(
        (dm) => Number(dm.MaDM) === Number(maDM)
      );

      return danhMuc
        ? danhMuc.TenDM
        : `Danh mục ${maDM ?? "—"}`;
    },

    // Lấy danh sách sản phẩm
    // Không tải thông số chi tiết ở API danh sách
    async getData() {
      try {
        const res = await axios.get(
          `${API_URL}/san-pham/get-data`
        );

        if (res.data.status) {
          this.danhSach = res.data.data || [];
        }
      } catch (error) {
        console.error(
          "Lỗi lấy sản phẩm:",
          error.response?.data || error
        );

        alert("Không thể tải danh sách sản phẩm.");
      }
    },

    // Hiển thị chính sách bảo hành ở danh sách sản phẩm
    // Có cấu hình bảo hành hay không
coBaoHanh(sp) {
  const v = sp?.ThoiHanBaoHanhThang;
  return v !== null && v !== undefined && v !== "";
},

// Nhãn ngắn gọn hiển thị trong danh sách
hienThiBaoHanh(sp) {
  return this.coBaoHanh(sp)
    ? `${Number(sp.ThoiHanBaoHanhThang)} tháng`
    : "Không BH";
},

// Chi tiết chỉ hiện khi rê chuột, bỏ qua phần bằng 0
chiTietBaoHanh(sp) {
  if (!this.coBaoHanh(sp)) return "Sản phẩm chưa cấu hình bảo hành";

  const mienPhi = Number(sp.ThoiHanMienPhiThang || 0);
  const tyLe = Number(sp.TyLeShopHoTro || 0);
  const dong = [`Bảo hành ${Number(sp.ThoiHanBaoHanhThang)} tháng`];

  if (mienPhi > 0) dong.push(`Miễn phí ${mienPhi} tháng đầu`);
  if (tyLe > 0) dong.push(`Sau đó shop hỗ trợ ${tyLe}%`);

  return dong.join("\n");
},

    // Kiểm tra bộ thông tin bảo hành: cho phép để trống cả bộ,
    // nhưng nếu nhập thì phải nhập đủ và đúng giới hạn.
    kiemTraChinhSachBaoHanh(form) {
      const cacTruong = [
        form.ThoiHanBaoHanhThang,
        form.ThoiHanMienPhiThang,
        form.TyLeShopHoTro,
      ];

      const daNhap = cacTruong.map(
        (giaTri) => giaTri !== null && giaTri !== undefined && String(giaTri).trim() !== ""
      );

      if (daNhap.every((coGiaTri) => !coGiaTri)) return true;

      if (!daNhap.every(Boolean)) {
        alert("Vui lòng nhập đủ tổng thời hạn bảo hành, thời hạn miễn phí và tỷ lệ shop hỗ trợ. Hoặc để trống cả 3 trường.");
        return false;
      }

      const tong = Number(form.ThoiHanBaoHanhThang);
      const mienPhi = Number(form.ThoiHanMienPhiThang);
      const tyLe = Number(form.TyLeShopHoTro);

      if (!Number.isInteger(tong) || !Number.isInteger(mienPhi) || !Number.isInteger(tyLe)) {
        alert("Thời hạn bảo hành phải là số tháng nguyên; tỷ lệ hỗ trợ phải là số nguyên.");
        return false;
      }

      if (tong < 0 || mienPhi < 0 || mienPhi > tong) {
        alert("Thời hạn miễn phí phải từ 0 đến không vượt quá tổng thời hạn bảo hành.");
        return false;
      }

      if (tyLe < 0 || tyLe > 100) {
        alert("Tỷ lệ shop hỗ trợ phải nằm trong khoảng từ 0 đến 100%.");
        return false;
      }

      return true;
    },

    // Chuẩn hóa dữ liệu thương hiệu và bảo hành trước khi gửi API
    duLieuThuongHieuVaBaoHanh(form) {
      const boTrong = [
        form.ThoiHanBaoHanhThang,
        form.ThoiHanMienPhiThang,
        form.TyLeShopHoTro,
      ].every((giaTri) => giaTri === null || giaTri === undefined || String(giaTri).trim() === "");

      return {
        ThuongHieu: String(form.ThuongHieu || "").trim() || null,
        AnhThuongHieu: String(form.AnhThuongHieu || "").trim() || null,
        ThoiHanBaoHanhThang: boTrong ? null : Number(form.ThoiHanBaoHanhThang),
        ThoiHanMienPhiThang: boTrong ? null : Number(form.ThoiHanMienPhiThang),
        TyLeShopHoTro: boTrong ? null : Number(form.TyLeShopHoTro),
      };
    },

    // Định dạng tiền Việt Nam
    dinhDangTien(gia) {
      return (
        Number(gia || 0).toLocaleString("vi-VN") + " đ"
      );
    },

    // Mở Bootstrap Modal
    moModal(id) {
      const element = document.getElementById(id);

      if (element && window.bootstrap?.Modal) {
        window.bootstrap.Modal
          .getOrCreateInstance(element)
          .show();
      } else {
        alert(
          "Không tìm thấy Bootstrap Modal. Hãy kiểm tra Bootstrap JS."
        );
      }
    },

    // Đóng Bootstrap Modal
    dongModal(id) {
      const element = document.getElementById(id);

      if (element && window.bootstrap?.Modal) {
        window.bootstrap.Modal
          .getOrCreateInstance(element)
          .hide();
      }
    },

    // Thêm một dòng thông số
    themDongThongSo(form) {
      if (!Array.isArray(this[form].ThongSo)) {
        this[form].ThongSo = [];
      }

      this[form].ThongSo.push({
        ten: "",
        giaTri: "",
      });
    },

    // Xóa một dòng thông số
    xoaDongThongSo(form, index) {
      this[form].ThongSo.splice(index, 1);

      // Luôn giữ lại một dòng trống để dễ nhập tiếp
      if (this[form].ThongSo.length === 0) {
        this[form].ThongSo.push({
          ten: "",
          giaTri: "",
        });
      }
    },

    // Chuyển các dòng thông số thành object JSON
    chuyenThongSo(thongSo) {
      const ketQua = {};

      if (!Array.isArray(thongSo)) {
        return ketQua;
      }

      thongSo.forEach((dong) => {
        const ten = String(dong.ten || "").trim();
        const giaTri = String(dong.giaTri || "").trim();

        if (ten && giaTri) {
          ketQua[ten] = giaTri;
        }
      });

      return ketQua;
    },

    // Chuyển JSON thông số từ Backend thành các dòng trên form
    doiThongSoThanhDong(thongSo) {
      let duLieu = thongSo;

      // Trường hợp Backend trả JSON dưới dạng chuỗi
      if (typeof duLieu === "string") {
        try {
          duLieu = JSON.parse(duLieu);
        } catch (error) {
          console.error("Không đọc được JSON thông số:", error);
          duLieu = {};
        }
      }

      if (
        !duLieu ||
        typeof duLieu !== "object" ||
        Array.isArray(duLieu)
      ) {
        return [{ ten: "", giaTri: "" }];
      }

      const danhSach = Object.entries(duLieu).map(
        ([ten, giaTri]) => ({
          ten,
          giaTri:
            giaTri !== null && typeof giaTri === "object"
              ? JSON.stringify(giaTri)
              : String(giaTri ?? ""),
        })
      );

      return danhSach.length
        ? danhSach
        : [{ ten: "", giaTri: "" }];
    },

    // Chuyển chuỗi nhiều dòng thành mảng link ảnh
    chuyenAnhChiTiet(text) {
      return String(text || "")
        .split("\n")
        .map((link) => link.trim())
        .filter((link) => link !== "");
    },

    // Mở modal thêm sản phẩm
    moThem() {
      this.spMoi = this.taoFormMoi();
      this.moModal("addModal");
    },

    // Thêm sản phẩm
    async themSP() {
      if (this.dangXuLy) return;

      if (
        !this.spMoi.TenSP.trim() ||
        this.spMoi.GiaBan === "" ||
        this.spMoi.MaDM === ""
      ) {
        alert("Vui lòng nhập tên, giá bán và mã danh mục.");
        return;
      }

      if (
        Number(this.spMoi.GiaBan) < 0 ||
        Number(this.spMoi.SoLuongTon || 0) < 0
      ) {
        alert("Giá bán và số lượng không được âm.");
        return;
      }

      if (!Number.isInteger(Number(this.spMoi.SoLuongTon || 0))) {
        alert("Số lượng tồn phải là số nguyên.");
        return;
      }

      if (!this.kiemTraChinhSachBaoHanh(this.spMoi)) return;

      const config = this.cauHinhAuth();

      if (!config) return;

      this.dangXuLy = true;

      try {
        const duLieu = {
          // Thông tin cơ bản
          TenSP: this.spMoi.TenSP.trim(),
          HinhAnh: this.spMoi.HinhAnh || null,
          GiaBan: Number(this.spMoi.GiaBan),
          SoLuongTon: Number(this.spMoi.SoLuongTon || 0),
          TrangThaiSP: this.spMoi.TrangThaiSP || "DangBan",
          MaDM: Number(this.spMoi.MaDM),

          // Thương hiệu và chính sách bảo hành
          ...this.duLieuThuongHieuVaBaoHanh(this.spMoi),

          // Thông tin chi tiết
          ThongSo: this.chuyenThongSo(this.spMoi.ThongSo),
          MoTaChiTiet: this.spMoi.MoTaChiTiet || null,
          HinhAnhChiTiet: this.chuyenAnhChiTiet(
            this.spMoi.HinhAnhChiTietText
          ),
        };

        const res = await axios.post(
          `${API_URL}/san-pham/add-data`,
          duLieu,
          config
        );

        if (res.data.status) {
          this.dongModal("addModal");

          this.spMoi = this.taoFormMoi();
          this.trangHienTai = 1;

          await this.getData();

          alert("Thêm sản phẩm thành công.");
        } else {
          alert(
            res.data.message || "Thêm sản phẩm thất bại."
          );
        }
      } catch (error) {
        console.error(
          "Lỗi thêm sản phẩm:",
          error.response?.data || error
        );

        const loi = error.response?.data?.errors;

        if (loi) {
          alert(
            Object.values(loi).flat().join("\n")
          );
        } else {
          alert(
            error.response?.data?.message ||
              "Thêm sản phẩm thất bại."
          );
        }
      } finally {
        this.dangXuLy = false;
      }
    },

    // Mở modal sửa và lấy chi tiết sản phẩm
    async moSua(sp) {
      // Đưa thông tin cơ bản lên form trước
      this.spSua = {
        ...sp,
        ThuongHieu: sp.ThuongHieu ?? "",
        AnhThuongHieu: sp.AnhThuongHieu ?? "",
        ThoiHanBaoHanhThang: sp.ThoiHanBaoHanhThang ?? "",
        ThoiHanMienPhiThang: sp.ThoiHanMienPhiThang ?? "",
        TyLeShopHoTro: sp.TyLeShopHoTro ?? "",
        ThongSo: [{ ten: "", giaTri: "" }],
        MoTaChiTiet: "",
        HinhAnhChiTietText: "",
      };

      try {
        // API này công khai nên không cần token
        const res = await axios.get(
          `${API_URL}/chi-tiet-san-pham/get-detail/${sp.MaSP}`
        );

        if (res.data.status && res.data.data) {
          const chiTiet = res.data.data;

          this.spSua.ThongSo = this.doiThongSoThanhDong(
            chiTiet.ThongSo
          );

          this.spSua.MoTaChiTiet =
            chiTiet.MoTaChiTiet || "";

          let danhSachAnh = chiTiet.HinhAnhChiTiet;

          if (typeof danhSachAnh === "string") {
            try {
              danhSachAnh = JSON.parse(danhSachAnh);
            } catch (error) {
              danhSachAnh = [];
            }
          }

          this.spSua.HinhAnhChiTietText =
            Array.isArray(danhSachAnh)
              ? danhSachAnh.join("\n")
              : "";
        }
      } catch (error) {
        console.error(
          "Lỗi lấy chi tiết sản phẩm:",
          error.response?.data || error
        );

        alert(
          "Không tải được thông tin chi tiết. Bạn vẫn có thể sửa thông tin cơ bản."
        );
      }

      // Mở modal sau khi đã lấy dữ liệu chi tiết
      this.moModal("updateModal");
    },

    // Lưu chỉnh sửa sản phẩm
    async luuSua() {
      if (this.dangXuLy) return;

      if (
        !this.spSua.TenSP?.trim() ||
        this.spSua.GiaBan === "" ||
        this.spSua.MaDM === ""
      ) {
        alert("Vui lòng nhập tên, giá bán và mã danh mục.");
        return;
      }

      if (
        Number(this.spSua.GiaBan) < 0 ||
        Number(this.spSua.SoLuongTon || 0) < 0
      ) {
        alert("Giá bán và số lượng không được âm.");
        return;
      }

      if (!Number.isInteger(Number(this.spSua.SoLuongTon || 0))) {
        alert("Số lượng tồn phải là số nguyên.");
        return;
      }

      if (!this.kiemTraChinhSachBaoHanh(this.spSua)) return;

      const config = this.cauHinhAuth();

      if (!config) return;

      this.dangXuLy = true;

      try {
        const duLieu = {
          // Thông tin cơ bản
          MaSP: this.spSua.MaSP,
          TenSP: this.spSua.TenSP.trim(),
          HinhAnh: this.spSua.HinhAnh || null,
          GiaBan: Number(this.spSua.GiaBan),
          SoLuongTon: Number(this.spSua.SoLuongTon || 0),
          TrangThaiSP: this.spSua.TrangThaiSP,
          MaDM: Number(this.spSua.MaDM),

          // Thương hiệu và chính sách bảo hành
          ...this.duLieuThuongHieuVaBaoHanh(this.spSua),

          // Thông tin chi tiết
          ThongSo: this.chuyenThongSo(this.spSua.ThongSo),
          MoTaChiTiet: this.spSua.MoTaChiTiet || null,
          HinhAnhChiTiet: this.chuyenAnhChiTiet(
            this.spSua.HinhAnhChiTietText
          ),
        };

        const res = await axios.put(
          `${API_URL}/san-pham/update`,
          duLieu,
          config
        );

        if (res.data.status) {
          this.dongModal("updateModal");

          await this.getData();

          alert("Cập nhật sản phẩm thành công.");
        } else {
          alert(
            res.data.message || "Cập nhật sản phẩm thất bại."
          );
        }
      } catch (error) {
        console.error(
          "Lỗi cập nhật sản phẩm:",
          error.response?.data || error
        );

        const loi = error.response?.data?.errors;

        if (loi) {
          alert(
            Object.values(loi).flat().join("\n")
          );
        } else {
          alert(
            error.response?.data?.message ||
              "Cập nhật sản phẩm thất bại."
          );
        }
      } finally {
        this.dangXuLy = false;
      }
    },

    // Mở modal xóa
    moXoa(sp) {
      this.spXoa = sp;
      this.moModal("deleteModal");
    },

    // Xóa sản phẩm
    async xoaSP() {
      if (this.dangXuLy || !this.spXoa) return;

      const config = this.cauHinhAuth();

      if (!config) return;

      this.dangXuLy = true;

      try {
        const maSP = this.spXoa.MaSP;
        const tenSP = this.spXoa.TenSP;

        const res = await axios.delete(
          `${API_URL}/san-pham/delete`,
          {
            ...config,
            data: {
              id: maSP,
            },
          }
        );

        if (res.data.status) {
          const action = res.data.action;

          this.dongModal("deleteModal");

          this.dsDaChon = this.dsDaChon.filter(
            (id) => id !== maSP
          );

          this.spXoa = null;

          await this.getData();

          if (action === "ngung_kinh_doanh") {
            alert(
              `Sản phẩm "${tenSP}" đã được chuyển sang ngừng kinh doanh.`
            );
          } else if (action === "xoa_vinh_vien") {
            alert(
              `Đã xóa vĩnh viễn sản phẩm "${tenSP}".`
            );
          } else {
            alert(
              res.data.message ||
                "Đã xử lý sản phẩm thành công."
            );
          }
        } else {
          alert(
            res.data.message || "Xử lý sản phẩm thất bại."
          );
        }
      } catch (error) {
        console.error(
          "Lỗi xóa sản phẩm:",
          error.response?.data || error
        );

        alert(
          error.response?.data?.message ||
            "Xử lý sản phẩm thất bại."
        );
      } finally {
        this.dangXuLy = false;
      }
    },

    // Chuyển trang
    doiTrang(trang) {
      if (trang >= 1 && trang <= this.tongTrang) {
        this.trangHienTai = trang;
      }
    },

    // Chọn một sản phẩm
    chonMot(maSP, daChon) {
      if (daChon && !this.dsDaChon.includes(maSP)) {
        this.dsDaChon.push(maSP);
      } else if (!daChon) {
        this.dsDaChon = this.dsDaChon.filter(
          (id) => id !== maSP
        );
      }
    },

    // Chọn tất cả sản phẩm trên trang
    chonTatCa(event) {
      const idsTrang = this.sanPhamTrang.map(
        (sp) => sp.MaSP
      );

      if (event.target.checked) {
        this.dsDaChon = [
          ...new Set([...this.dsDaChon, ...idsTrang]),
        ];
      } else {
        this.dsDaChon = this.dsDaChon.filter(
          (id) => !idsTrang.includes(id)
        );
      }
    },

    // Xử lý khi hình ảnh bị lỗi
    xuLyLoiAnh(event) {
      event.target.style.display = "none";
    },
  },
};
</script>
<style scoped>
/* =========================================================
   BẢNG MÀU & BIẾN DÙNG CHUNG
   ========================================================= */
.product-page {
  --primary: #4f46e5;
  --primary-2: #2563eb;
  --primary-dark: #3730a3;
  --accent: #06b6d4;
  --navy: #0f172a;
  --text: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --surface: #ffffff;
  --soft: #f1f5f9;
  --grad-primary: linear-gradient(135deg, #4f46e5 0%, #2563eb 55%, #06b6d4 100%);
  --grad-danger: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
  --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.06);
  --shadow-md: 0 10px 28px rgba(79, 70, 229, 0.12);
  --shadow-lg: 0 18px 44px rgba(79, 70, 229, 0.2);
  --ease: cubic-bezier(0.22, 1, 0.36, 1);

  color: var(--text);
  width: 100%;
  min-width: 0;
  font-family: "Roboto", "Inter", Arial, sans-serif;
}

.product-page * {
  box-sizing: border-box;
}

/* =========================================================
   HIỆU ỨNG XUẤT HIỆN
   ========================================================= */
@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(16px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes pulseDot {
  0%,
  100% {
    box-shadow: 0 0 0 0 currentColor;
    opacity: 1;
  }
  50% {
    box-shadow: 0 0 0 4px transparent;
    opacity: 0.6;
  }
}

@keyframes shine {
  from {
    transform: translateX(-120%) skewX(-20deg);
  }
  to {
    transform: translateX(220%) skewX(-20deg);
  }
}

.page-heading {
  animation: fadeUp 0.5s var(--ease) both;
}

.stat-card {
  animation: fadeUp 0.55s var(--ease) both;
}
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.12s; }
.stat-card:nth-child(3) { animation-delay: 0.19s; }
.stat-card:nth-child(4) { animation-delay: 0.26s; }

.product-panel {
  animation: fadeUp 0.6s var(--ease) 0.3s both;
}

.product-card {
  animation: fadeUp 0.45s var(--ease) both;
}

/* =========================================================
   TIÊU ĐỀ TRANG
   ========================================================= */
.page-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 26px;
}

.page-heading h1 {
  margin: 0 0 7px;
  font-size: 29px;
  line-height: 1.25;
  font-weight: 800;
  letter-spacing: -0.3px;
  background: linear-gradient(90deg, #0f172a 0%, #4f46e5 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.page-heading p {
  margin: 0;
  color: var(--muted);
  font-size: 14px;
}

/* =========================================================
   NÚT BẤM
   ========================================================= */
.primary-btn,
.danger-btn,
.secondary-btn {
  position: relative;
  overflow: hidden;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  min-height: 44px;
  padding: 0 18px;
  border: 0;
  border-radius: 11px;
  font-size: 13px;
  font-weight: 700;
  white-space: nowrap;
  cursor: pointer;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease),
    filter 0.25s, background 0.25s;
}

.primary-btn {
  color: #fff;
  background: var(--grad-primary);
  background-size: 140% 140%;
  background-position: 0% 50%;
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
}

.primary-btn::after,
.danger-btn::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 40%;
  height: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.35),
    transparent
  );
  transform: translateX(-120%) skewX(-20deg);
  pointer-events: none;
}

.primary-btn:hover:not(:disabled),
.danger-btn:hover:not(:disabled) {
  transform: translateY(-2px);
}

.primary-btn:hover:not(:disabled)::after,
.danger-btn:hover:not(:disabled)::after {
  animation: shine 0.8s var(--ease);
}

.primary-btn:hover:not(:disabled) {
  color: #fff;
  background-position: 100% 50%;
  box-shadow: 0 12px 26px rgba(79, 70, 229, 0.42);
}

.primary-btn:active:not(:disabled),
.danger-btn:active:not(:disabled) {
  transform: translateY(0) scale(0.97);
}

.danger-btn {
  color: #fff;
  background: var(--grad-danger);
  box-shadow: 0 8px 18px rgba(244, 63, 94, 0.3);
}

.danger-btn:hover:not(:disabled) {
  color: #fff;
  box-shadow: 0 12px 26px rgba(244, 63, 94, 0.42);
}

.secondary-btn {
  color: #475569;
  background: var(--soft);
  border: 1px solid var(--line);
}

.secondary-btn:hover {
  color: var(--primary);
  background: #eef2ff;
  border-color: #c7d2fe;
}

.primary-btn:disabled,
.danger-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.primary-btn:focus-visible,
.danger-btn:focus-visible,
.secondary-btn:focus-visible {
  outline: 3px solid rgba(79, 70, 229, 0.35);
  outline-offset: 2px;
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
  gap: 17px;
  min-width: 0;
  min-height: 116px;
  padding: 20px;
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: 16px;
  box-shadow: var(--shadow-sm);
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease),
    border-color 0.3s;
}

/* vòng tròn mờ trang trí góc thẻ */
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

/* thanh màu phía dưới */
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

.stat-card:hover::before {
  transform: scale(1.5);
}

.stat-card:hover::after {
  transform: scaleX(1);
}

.stat-icon {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 0 0 56px;
  width: 56px;
  height: 56px;
  border-radius: 16px;
  color: #fff;
  font-size: 23px;
  transition: transform 0.35s var(--ease);
}

.stat-card:hover .stat-icon {
  transform: rotate(-8deg) scale(1.1);
}

.icon-blue {
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  box-shadow: 0 8px 16px rgba(79, 70, 229, 0.35);
}

.icon-green {
  background: linear-gradient(135deg, #34d399, #059669);
  box-shadow: 0 8px 16px rgba(16, 185, 129, 0.35);
}

.icon-orange {
  background: linear-gradient(135deg, #fbbf24, #f97316);
  box-shadow: 0 8px 16px rgba(245, 158, 11, 0.38);
}

.icon-purple {
  background: linear-gradient(135deg, #c084fc, #9333ea);
  box-shadow: 0 8px 16px rgba(168, 85, 247, 0.35);
}

.stat-info {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  gap: 5px;
  min-width: 0;
}

.stat-info span {
  color: var(--muted);
  font-size: 12px;
  font-weight: 600;
}

.stat-info strong {
  overflow: hidden;
  color: var(--navy);
  font-size: 26px;
  font-weight: 800;
  line-height: 1.1;
  text-overflow: ellipsis;
}

.stat-info small {
  color: #94a3b8;
  font-size: 11px;
}

/* =========================================================
   KHUNG BẢNG / THANH CÔNG CỤ
   ========================================================= */
.product-panel {
  min-width: 0;
  padding: 18px;
  overflow: hidden;
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: 18px;
  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
}

.toolbar {
  display: grid;
  grid-template-columns:
    minmax(180px, 1.7fr) minmax(150px, 1fr) minmax(150px, 1fr)
    auto;
  align-items: center;
  gap: 12px;
  padding-bottom: 18px;
  margin-bottom: 14px;
  border-bottom: 1px solid var(--line);
}

.search-box {
  display: flex;
  align-items: center;
  gap: 11px;
  min-width: 0;
  height: 46px;
  padding: 0 14px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  color: var(--muted);
  background: var(--soft);
  transition: all 0.25s var(--ease);
}

.search-box:hover {
  border-color: #c7d2fe;
}

.search-box:focus-within {
  color: var(--primary);
  background: #fff;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.search-box input {
  width: 100%;
  min-width: 0;
  padding: 0;
  border: 0;
  outline: 0;
  color: var(--navy);
  background: transparent;
  font-size: 13px;
}

.search-box input::placeholder {
  color: #94a3b8;
}

.clear-search {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border: 0;
  border-radius: 50%;
  background: #e2e8f0;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s;
}

.clear-search:hover {
  color: #fff;
  background: #f43f5e;
  transform: rotate(90deg);
}

.filter-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1px;
  height: 46px;
  min-width: 0;
  padding: 4px 14px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  background: var(--soft);
  transition: all 0.25s var(--ease);
}

.filter-box:hover {
  border-color: #c7d2fe;
}

.filter-box:focus-within {
  background: #fff;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.filter-box span {
  color: var(--primary);
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.4px;
}

.filter-box select {
  width: 100%;
  min-width: 0;
  padding: 0 18px 0 0;
  border: 0;
  outline: 0;
  color: var(--text);
  background-color: transparent;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
}

.view-buttons {
  display: flex;
  gap: 4px;
  justify-self: end;
  padding: 4px;
  border-radius: 12px;
  background: var(--soft);
  border: 1px solid var(--line);
}

.view-buttons button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 36px;
  border: 0;
  border-radius: 9px;
  color: var(--muted);
  background: transparent;
  cursor: pointer;
  transition: all 0.25s var(--ease);
}

.view-buttons button:hover:not(.active) {
  color: var(--primary);
  background: #e0e7ff;
}

.view-buttons button.active {
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.35);
}

/* =========================================================
   BẢNG
   ========================================================= */
.table-wrap {
  width: 100%;
  overflow-x: auto;
}

.product-table {
  width: 100%;
  min-width: 900px;
  border-collapse: separate;
  border-spacing: 0;
  color: var(--text);
  font-size: 12.5px;
}

.product-table thead th {
  padding: 15px 12px;
  color: #3730a3;
  background: linear-gradient(180deg, #eef2ff, #e0e7ff);
  font-size: 11.5px;
  font-weight: 800;
  letter-spacing: 0.3px;
  text-align: left;
  text-transform: uppercase;
  white-space: nowrap;
}

.product-table thead th:first-child {
  border-radius: 12px 0 0 12px;
}

.product-table thead th:last-child {
  border-radius: 0 12px 12px 0;
}

.product-table tbody td {
  height: 64px;
  padding: 8px 12px;
  border-bottom: 1px solid #eef2f7;
  vertical-align: middle;
  transition: background 0.25s;
}

.product-table tbody tr {
  transition: transform 0.25s var(--ease);
}

.product-table tbody tr:hover td {
  background: #f5f7ff;
}

.product-table tbody tr:hover td:first-child {
  box-shadow: inset 4px 0 0 var(--primary);
}

.product-table .check-column {
  width: 42px;
  text-align: center;
}

.product-table input[type="checkbox"] {
  width: 17px;
  height: 17px;
  accent-color: var(--primary);
  cursor: pointer;
}

.product-image {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 56px;
  height: 46px;
  overflow: hidden;
  border: 1px solid var(--line);
  border-radius: 10px;
  background: #fff;
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}

.product-table tbody tr:hover .product-image {
  transform: scale(1.12);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.18);
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.image-placeholder {
  color: #cbd5e1;
  font-size: 21px;
}

.product-name {
  max-width: 230px;
  overflow: hidden;
  color: var(--navy);
  font-weight: 700;
  text-overflow: ellipsis;
  white-space: nowrap;
  transition: color 0.2s;
}

.product-table tbody tr:hover .product-name {
  color: var(--primary);
}

.product-code {
  margin-top: 4px;
  color: #94a3b8;
  font-size: 11px;
}

.category-badge {
  display: inline-flex;
  align-items: center;
  padding: 5px 11px;
  border-radius: 999px;
  color: #4338ca;
  background: #e0e7ff;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
}

.price-cell {
  color: #4f46e5;
  font-size: 13px;
  font-weight: 800;
  white-space: nowrap;
}

/* =========================================================
   TRẠNG THÁI (có chấm nhấp nháy)
   ========================================================= */
.status-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  padding: 5px 12px;
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

.status-selling {
  color: #047857;
  background: #d1fae5;
}

.status-selling::before {
  animation: pulseDot 1.8s ease-in-out infinite;
}

.status-empty {
  color: #be123c;
  background: #ffe4e6;
}

.status-stopped {
  color: #475569;
  background: #e2e8f0;
}

/* =========================================================
   NÚT THAO TÁC
   ========================================================= */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 9px;
}

.action-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border: 0;
  border-radius: 11px;
  color: #fff;
  cursor: pointer;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
}

.action-btn:hover {
  color: #fff;
  transform: translateY(-3px) scale(1.08);
}

.action-btn:active {
  transform: scale(0.94);
}

.edit-btn {
  background: linear-gradient(135deg, #6366f1, #2563eb);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.3);
}

.edit-btn:hover {
  box-shadow: 0 10px 20px rgba(79, 70, 229, 0.45);
}

.delete-btn {
  background: var(--grad-danger);
  box-shadow: 0 5px 12px rgba(244, 63, 94, 0.28);
}

.delete-btn:hover {
  box-shadow: 0 10px 20px rgba(244, 63, 94, 0.45);
}

.empty-state {
  padding: 52px 15px !important;
  color: #94a3b8;
  text-align: center !important;
}

.empty-state i {
  font-size: 38px;
  color: #c7d2fe;
}

.empty-state p {
  margin: 12px 0 0;
}

/* =========================================================
   PHÂN TRANG
   ========================================================= */
.table-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 20px 7px 3px;
  color: var(--muted);
  font-size: 12px;
}

.pagination {
  display: flex;
  align-items: center;
  gap: 6px;
}

.pagination button {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 36px;
  height: 36px;
  padding: 0 10px;
  border: 1.5px solid var(--line);
  border-radius: 10px;
  color: #475569;
  background: #fff;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.25s var(--ease);
}

.pagination button:hover:not(:disabled):not(.active) {
  border-color: var(--primary);
  color: var(--primary);
  background: #eef2ff;
  transform: translateY(-2px);
}

.pagination button.active {
  border-color: transparent;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 6px 14px rgba(79, 70, 229, 0.35);
}

.pagination button:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

/* =========================================================
   CHẾ ĐỘ THẺ
   ========================================================= */
.product-cards {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 18px;
}

.product-card {
  position: relative;
  overflow: hidden;
  border: 1px solid var(--line);
  border-radius: 16px;
  background: #fff;
  transition: transform 0.35s var(--ease), box-shadow 0.35s var(--ease),
    border-color 0.35s;
}

.product-card:nth-child(2) { animation-delay: 0.04s; }
.product-card:nth-child(3) { animation-delay: 0.08s; }
.product-card:nth-child(4) { animation-delay: 0.12s; }
.product-card:nth-child(5) { animation-delay: 0.16s; }
.product-card:nth-child(6) { animation-delay: 0.2s; }
.product-card:nth-child(7) { animation-delay: 0.24s; }
.product-card:nth-child(8) { animation-delay: 0.28s; }

.product-card:hover {
  transform: translateY(-8px);
  border-color: #c7d2fe;
  box-shadow: var(--shadow-lg);
}

.card-product-image {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 180px;
  padding: 15px;
  overflow: hidden;
  background: linear-gradient(160deg, #f8faff, #eef2ff);
}

.card-product-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: transform 0.5s var(--ease);
}

.product-card:hover .card-product-image img {
  transform: scale(1.1);
}

.card-product-info {
  padding: 16px;
}

.card-product-info h3 {
  margin: 12px 0 6px;
  color: var(--navy);
  font-size: 14.5px;
  font-weight: 800;
  line-height: 1.35;
}

.card-product-info p {
  margin: 0 0 8px;
  color: #94a3b8;
  font-size: 11.5px;
}

.card-product-info > strong {
  display: block;
  margin-top: 4px;
  color: #4f46e5;
  font-size: 18px;
  font-weight: 800;
}

.card-product-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  margin-top: 13px;
  color: var(--muted);
  font-size: 11px;
  font-weight: 600;
}

.card-actions {
  display: flex;
  gap: 8px;
  margin-top: 15px;
}

.small-btn {
  flex: 1;
  min-height: 38px;
  padding: 0 10px;
  font-size: 12px;
}

/* =========================================================
   MODAL
   ========================================================= */
.modal.fade .modal-dialog {
  transform: translateY(30px) scale(0.96);
  transition: transform 0.4s var(--ease), opacity 0.3s;
}

.modal.show .modal-dialog {
  transform: none;
}

.custom-modal {
  overflow: hidden;
  border: 0;
  border-radius: 20px;
  box-shadow: 0 30px 80px rgba(15, 23, 42, 0.28);
}

.custom-modal .modal-header {
  align-items: flex-start;
  padding: 22px 26px;
  border-bottom: 0;
  background: var(--grad-primary);
  color: #fff;
}

.custom-modal .modal-title {
  color: #fff;
  font-size: 20px;
  font-weight: 800;
}

.custom-modal .modal-header p {
  margin: 5px 0 0;
  color: rgba(255, 255, 255, 0.85);
  font-size: 12.5px;
}

.custom-modal .btn-close {
  filter: invert(1) grayscale(1) brightness(2);
  opacity: 0.85;
  transition: transform 0.3s var(--ease), opacity 0.2s;
}

.custom-modal .btn-close:hover {
  opacity: 1;
  transform: rotate(90deg);
}

.custom-modal .modal-body {
  padding: 24px 26px;
  max-height: calc(100vh - 190px);
  overflow-y: auto;
}

.custom-modal .modal-footer {
  gap: 9px;
  padding: 16px 26px;
  border-top: 1px solid var(--line);
  background: #f8fafc;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 19px 16px;
}

.form-field {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 0;
  color: #334155;
  font-size: 12.5px;
  font-weight: 700;
}

.form-field span b {
  color: #f43f5e;
}

.form-field .form-control,
.form-field .form-select {
  min-height: 45px;
  border: 1.5px solid var(--line);
  border-radius: 11px;
  color: var(--navy);
  background-color: #f8fafc;
  box-shadow: none;
  font-size: 13px;
  transition: all 0.25s var(--ease);
}

.form-field .form-control:hover,
.form-field .form-select:hover {
  border-color: #c7d2fe;
}

.form-field .form-control:focus,
.form-field .form-select:focus {
  border-color: var(--primary);
  background-color: #fff;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

/* =========================================================
   XÁC NHẬN XÓA
   ========================================================= */
.delete-confirm {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.delete-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 66px;
  height: 66px;
  margin-bottom: 16px;
  border-radius: 50%;
  color: #fff;
  background: var(--grad-danger);
  box-shadow: 0 10px 24px rgba(244, 63, 94, 0.4);
  font-size: 24px;
  animation: pulseDot 2s ease-in-out infinite;
  color: #fff;
}

.delete-confirm p {
  margin: 0 0 8px;
  color: #475569;
}

.delete-confirm strong {
  margin-bottom: 10px;
  color: var(--navy);
}

.delete-confirm small {
  color: #f43f5e;
  font-weight: 600;
}

/* =========================================================
   KHU VỰC THÔNG TIN CHI TIẾT
   ========================================================= */
.detail-form-section {
  margin-top: 26px;
  padding: 20px;
  border: 1px solid var(--line);
  border-left: 4px solid var(--primary);
  border-radius: 14px;
  background: linear-gradient(180deg, #fafbff, #ffffff);
}

.detail-section-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 17px;
}

.detail-section-heading h6 {
  margin: 0 0 5px;
  color: var(--navy);
  font-size: 15px;
  font-weight: 800;
}

.detail-section-heading p {
  margin: 0;
  color: #94a3b8;
  font-size: 12px;
}

.spec-row {
  display: grid;
  grid-template-columns: 1fr 1.5fr 40px;
  gap: 10px;
  margin-bottom: 11px;
}

.spec-row .form-control,
.detail-field .form-control {
  border: 1.5px solid var(--line);
  border-radius: 10px;
  color: var(--navy);
  background: #fff;
  font-size: 13px;
  box-shadow: none;
  transition: all 0.25s var(--ease);
}

.spec-row .form-control {
  min-height: 43px;
}

.spec-row .form-control:focus,
.detail-field .form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.remove-spec-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 43px;
  border: 0;
  border-radius: 10px;
  color: #f43f5e;
  background: #ffe4e6;
  cursor: pointer;
  transition: all 0.25s var(--ease);
}

.remove-spec-btn:hover {
  color: #fff;
  background: #f43f5e;
  transform: scale(1.06);
  box-shadow: 0 6px 14px rgba(244, 63, 94, 0.35);
}

.detail-field {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 18px;
}

.detail-field label {
  color: #334155;
  font-size: 12.5px;
  font-weight: 700;
}

.detail-field textarea {
  resize: vertical;
}

.detail-field small {
  color: #94a3b8;
  font-size: 11px;
}

/* Thanh cuộn gọn gàng trong modal và bảng */
.custom-modal .modal-body::-webkit-scrollbar,
.table-wrap::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

.custom-modal .modal-body::-webkit-scrollbar-thumb,
.table-wrap::-webkit-scrollbar-thumb {
  border-radius: 8px;
  background: #c7d2fe;
}

.custom-modal .modal-body::-webkit-scrollbar-thumb:hover,
.table-wrap::-webkit-scrollbar-thumb:hover {
  background: #818cf8;
}

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 1200px) {
  .stats-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .toolbar {
    grid-template-columns: minmax(180px, 1fr) minmax(140px, 1fr);
  }

  .view-buttons {
    justify-self: start;
  }

  .product-cards {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (max-width: 768px) {
  .page-heading {
    align-items: flex-start;
    flex-direction: column;
  }

  .page-heading h1 {
    font-size: 24px;
  }

  .stats-grid {
    gap: 10px;
  }

  .stat-card {
    gap: 10px;
    min-height: 98px;
    padding: 13px;
  }

  .stat-icon {
    flex-basis: 42px;
    width: 42px;
    height: 42px;
    font-size: 17px;
    border-radius: 12px;
  }

  .stat-info strong {
    font-size: 20px;
  }

  .stat-info small {
    line-height: 1.4;
  }

  .toolbar {
    grid-template-columns: minmax(0, 1fr);
  }

  .product-panel {
    padding: 12px;
  }

  .table-footer {
    align-items: flex-start;
    flex-direction: column;
  }

  .pagination {
    flex-wrap: wrap;
  }

  .product-cards {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
  }

  .card-product-image {
    height: 135px;
  }

  .card-product-info {
    padding: 12px;
  }

  .form-grid {
    grid-template-columns: minmax(0, 1fr);
  }

  .custom-modal .modal-body {
    padding: 18px;
  }
}

@media (max-width: 576px) {
  .detail-section-heading {
    align-items: flex-start;
    flex-direction: column;
  }

  .spec-row {
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) 36px;
    gap: 6px;
  }
}

@media (max-width: 420px) {
  .stats-grid {
    grid-template-columns: minmax(0, 1fr);
  }

  .product-cards {
    grid-template-columns: minmax(0, 1fr);
  }
}

/* Tôn trọng người dùng tắt hiệu ứng chuyển động */
@media (prefers-reduced-motion: reduce) {
  .product-page *,
  .product-page *::before,
  .product-page *::after {
    animation: none !important;
    transition: none !important;
  }
}
.warranty-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 999px;
  color: #0e7490;
  background: #cffafe;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
  cursor: help;
  transition: transform 0.2s, box-shadow 0.2s;
}

.warranty-badge:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 10px rgba(6, 182, 212, 0.3);
}

.warranty-badge.warranty-none {
  color: #94a3b8;
  background: #f1f5f9;
}
</style>