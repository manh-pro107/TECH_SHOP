<template>
  <div class="top-client">
    <div class="top-inner">
      <!-- LOGO -->
      <div class="brand-box" @click="$router.push('/')">
        <div class="brand-icon">
          <i class="fa-solid fa-laptop"></i>
        </div>

        <div class="brand-text">
          <div class="brand-name">Tech<span>Shop</span></div>
          <div class="brand-sub">COMPUTER STORE</div>
        </div>
      </div>

      <!-- TÌM KIẾM -->
      <div class="search-area">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass search-icon"></i>

          <input
            type="text"
            class="search-input"
            placeholder="Bạn đang tìm kiếm sản phẩm nào?"
            v-model="keyword"
            @keyup.enter="timKiem"
          />

          <button class="search-button" @click="timKiem">
            Tìm kiếm
          </button>
        </div>
      </div>

      <!-- CÁC CHỨC NĂNG -->
      <div class="top-actions">
        <!-- LỊCH SỬ MUA -->
        <!-- LỊCH SỬ MUA HÀNG -->
<!-- LỊCH SỬ MUA HÀNG + THÔNG BÁO -->
<div
  class="action-item order-action"
  title="Xem lịch sử và các cập nhật đơn hàng"
  @click="moLichSuDonHang"
>
  <div class="action-icon order-action-icon">
    <i class="fa-regular fa-bell"></i>
  </div>

  <span
    v-if="orderUnreadCount > 0"
    class="order-notice-badge"
  >
    {{ orderUnreadCount > 99 ? "99+" : orderUnreadCount }}
  </span>

  <div class="action-content">
    <span class="action-title">Đơn hàng</span>
    <small>
      {{
        orderUnreadCount > 0
          ? orderUnreadCount + " cập nhật mới"
          : "Lịch sử mua"
      }}
    </small>
  </div>
</div>

        <!-- GIỎ HÀNG -->
        <div class="dropdown">
          <div class="action-item cart-trigger" data-bs-toggle="dropdown">
            <div class="action-icon cart-icon">
              <i class="fa-solid fa-cart-shopping"></i>

              <span class="badge-cart">
                {{ cart.length }}
              </span>
            </div>

            <div class="action-content">
              <span class="action-title">Giỏ hàng</span>
              <small>{{ cart.length }} sản phẩm</small>
            </div>
          </div>

          <!-- DANH SÁCH GIỎ HÀNG -->
          <div class="dropdown-menu dropdown-menu-end cart-dropdown">
            <!-- ĐẦU GIỎ HÀNG -->
            <div class="cart-header">
              <div>
                <strong>Giỏ hàng</strong>

                <span>
                  Đã chọn {{ soLuongDaChon }}/{{ cart.length }} sản phẩm
                </span>
              </div>

              <label class="chon-tat-ca" @click.stop>
                <input
                  type="checkbox"
                  :checked="tatCaDaChon"
                  @click.stop
                  @change="chonTatCa($event.target.checked)"
                />

                <span>Chọn tất cả</span>
              </label>

              <div class="cart-header-icon">
                <i class="fa-solid fa-cart-shopping"></i>
              </div>
            </div>

            <!-- GIỎ HÀNG TRỐNG -->
            <div v-if="cart.length === 0" class="empty-cart">
              <div class="empty-icon">
                <i class="fa-solid fa-cart-shopping"></i>
              </div>

              <h6>Giỏ hàng đang trống</h6>
              <p>Thêm sản phẩm để bắt đầu mua sắm</p>
            </div>

            <!-- MỖI SẢN PHẨM -->
            <div
              v-for="item in cart"
              :key="item.MaGH"
              class="cart-item"
            >
              <!-- CHỌN SẢN PHẨM -->
              <div class="cart-select">
                <input
                  type="checkbox"
                  :checked="daChon(item.MaGH)"
                  @click.stop
                  @change="chonSanPham(item.MaGH, $event.target.checked)"
                  :aria-label="'Chọn ' + item.ten"
                />
              </div>

              <!-- ẢNH SẢN PHẨM -->
              <div class="cart-image">
                <img :src="item.hinh" :alt="item.ten" />
              </div>

              <!-- THÔNG TIN SẢN PHẨM -->
              <div class="cart-info">
                <h6>{{ item.ten }}</h6>

                <div class="cart-price">
                  {{ Number(item.gia).toLocaleString("vi-VN") }}đ
                </div>

                <div class="qty-row">
                  <div class="qty-box">
                    <button
                      :disabled="item.soluong <= 1"
                      @click.stop="giamSL(item.MaGH)"
                    >
                      <i class="fa-solid fa-minus"></i>
                    </button>

                    <span>{{ item.soluong }}</span>

                    <button
                      :disabled="
                        item.soluong >= item.soLuongKhaDung
                      "
                      @click.stop="tangSL(item.MaGH)"
                    >
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- XÓA SẢN PHẨM -->
              <button
                class="remove-btn"
                @click.stop="xoaSP(item.MaGH)"
                aria-label="Xóa sản phẩm"
              >
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>

            <!-- TỔNG TIỀN -->
            <div class="cart-footer" v-if="cart.length > 0">
              <div class="total-row">
                <span>
                  Tổng tiền ({{ soLuongDaChon }} đã chọn)
                </span>

                <strong>
                  {{ tongTien.toLocaleString("vi-VN") }}đ
                </strong>
              </div>

              <button
                class="checkout-btn"
                :disabled="soLuongDaChon === 0"
                @click="muaHang"
              >
                <span>Mua {{ soLuongDaChon }} sản phẩm</span>
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- TÀI KHOẢN -->
<div class="dropdown">
  <div
    class="action-item account-trigger"
    data-bs-toggle="dropdown"
    aria-expanded="false"
    role="button"
    tabindex="0"
  >
  <div class="action-icon account-avatar">
  <img
    v-if="anhDaiDien"
    :src="anhDaiDien"
    :alt="user?.HoTen || 'Ảnh đại diện'"
  />

  <i v-else class="fa-regular fa-user"></i>
</div>

    <div class="account-trigger-text">
      <span class="action-title">
        {{
          isLoggedIn
            ? user?.HoTen || user?.TenND || user?.Email || "Tài khoản"
            : "Tài khoản"
        }}
      </span>

      <small>
        {{ isLoggedIn ? "Tài khoản của bạn" : "Đăng nhập / Đăng ký" }}
      </small>
    </div>

    <i class="fa-solid fa-chevron-down account-arrow"></i>
  </div>

  <ul class="dropdown-menu dropdown-menu-end user-dropdown">

    <!-- CHƯA ĐĂNG NHẬP -->
    <template v-if="!isLoggedIn">
      <li>
        <button
          type="button"
          class="account-menu-btn"
          @click="$router.push('/dang-nhap')"
        >
          <span class="account-menu-icon login-icon">
            <i class="fa-solid fa-right-to-bracket"></i>
          </span>

          <span>
            <strong>Đăng nhập</strong>
            <small>Truy cập tài khoản của bạn</small>
          </span>
        </button>
      </li>

      <li>
        <button
          type="button"
          class="account-menu-btn"
          @click="$router.push('/dang-ky')"
        >
          <span class="account-menu-icon register-icon">
            <i class="fa-solid fa-user-plus"></i>
          </span>

          <span>
            <strong>Đăng ký</strong>
            <small>Tạo tài khoản TECHSHOP mới</small>
          </span>
        </button>
      </li>
    </template>

    <!-- ĐÃ ĐĂNG NHẬP -->
    <!-- ĐÃ ĐĂNG NHẬP -->
<li v-else class="account-menu-group">

<button
  type="button"
  class="account-menu-btn"
  @click="$router.push('/thong-tin-ca-nhan')"
>
  <span class="account-menu-icon login-icon">
    <i class="fa-solid fa-user-gear"></i>
  </span>

  <span>
    <strong>Quản lý thông tin cá nhân</strong>
    <small>Sửa hồ sơ và đổi mật khẩu</small>
  </span>
</button>

<button
  type="button"
  class="account-menu-btn logout-btn"
  @click="dangXuat"
>
  <span class="account-menu-icon logout-icon">
    <i class="fa-solid fa-right-from-bracket"></i>
  </span>

  <span>
    <strong>Đăng xuất</strong>
    <small>Thoát tài khoản hiện tại</small>
  </span>
</button>

</li>

  </ul>
</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

const API = "http://127.0.0.1:8000/api";

export default {
  data() {
    return {
      cart: [],
      selectedMaGH: [],
      daKhoiTaoChon: false,

      keyword: "",
      user: null,
      isLoggedIn: false,

      // Số đơn hàng đang chờ xác nhận
          // Thông báo trạng thái đơn hàng chưa đọc
      orderUnreadCount: 0,
      orderNotifications: [],
      orderPollTimer: null,
    };
  },

  computed: {
    // LẤY ẢNH ĐẠI DIỆN TÀI KHOẢN
anhDaiDien() {
  const avatar =
    this.user?.AnhDaiDien ||
    this.user?.HinhAnhDaiDien ||
    this.user?.HinhAnh ||
    this.user?.Avatar ||
    this.user?.avatar ||
    this.user?.anh_dai_dien;

  if (!avatar) return "";

  const value = String(avatar).trim();

  // Nếu đã là URL đầy đủ thì sử dụng luôn
  if (/^(https?:\/\/|data:)/i.test(value)) {
    return value;
  }

  // Nếu là đường dẫn lưu trong Laravel Storage
  const baseURL = API.replace(/\/api$/, "");
  const path = value.replace(/^\/+/, "");

  if (path.toLowerCase().startsWith("storage/")) {
    return `${baseURL}/${path}`;
  }

  return `${baseURL}/storage/${path}`;
},
    // Đếm số dòng sản phẩm đang chọn
    soLuongDaChon() {
      return this.cart.filter((item) =>
        this.daChon(item.MaGH)
      ).length;
    },

    // Kiểm tra tất cả sản phẩm đã được chọn chưa
    tatCaDaChon() {
      return (
        this.cart.length > 0 &&
        this.cart.every((item) => this.daChon(item.MaGH))
      );
    },

    // Chỉ tính tổng tiền những sản phẩm được chọn
    tongTien() {
      return this.cart.reduce((sum, item) => {
        if (!this.daChon(item.MaGH)) {
          return sum;
        }

        return (
          sum +
          Number(item.gia || 0) * Number(item.soluong || 0)
        );
      }, 0);
    },
  },

  mounted() {
  this.loadCart();
  this.loadAccount();
  this.loadOrderNotification();

  // Kiểm tra trạng thái đơn hàng định kỳ mỗi 20 giây
  this.orderPollTimer = window.setInterval(() => {
    this.loadOrderNotification();
  }, 20000);

  window.addEventListener("storage", this.loadCart);
  window.addEventListener("storage", this.loadAccount);
  window.addEventListener("storage", this.syncOrderNotifications);

  window.addEventListener(
    "techshop:orders-updated",
    this.loadOrderNotification
  );

  window.addEventListener(
    "techshop:account-updated",
    this.loadAccount
  );

  window.addEventListener("focus", this.loadOrderNotification);
},

beforeUnmount() {
  if (this.orderPollTimer) {
    clearInterval(this.orderPollTimer);
    this.orderPollTimer = null;
  }

  window.removeEventListener("storage", this.loadCart);
  window.removeEventListener("storage", this.loadAccount);
  window.removeEventListener("storage", this.syncOrderNotifications);

  window.removeEventListener(
    "techshop:orders-updated",
    this.loadOrderNotification
  );

  window.removeEventListener(
    "techshop:account-updated",
    this.loadAccount
  );

  window.removeEventListener("focus", this.loadOrderNotification);
},

beforeUnmount() {
  window.removeEventListener("storage", this.loadCart);
  window.removeEventListener("storage", this.loadAccount);
  window.removeEventListener("storage", this.loadOrderNotification);

  window.removeEventListener(
    "techshop:orders-updated",
    this.loadOrderNotification
  );

  window.removeEventListener(
    "focus",
    this.loadOrderNotification
  );
},

  methods: {
    // =========================
// CẬP NHẬT THÔNG BÁO ĐƠN HÀNG
// =========================
// ========================
// TẠO KHÓA THÔNG BÁO RIÊNG CHO TỪNG TÀI KHOẢN
// ========================
getOrderNotificationKeys() {
  const identity = String(
    this.user?.MaND || this.user?.Email || "default"
  ).replace(/[^a-zA-Z0-9_-]/g, "_");

  return {
    snapshot: `techshop_order_snapshot_${identity}`,
    notifications: `techshop_order_notifications_${identity}`,
  };
},

// ========================
// ĐỌC SỐ THÔNG BÁO CHƯA XEM
// ========================
syncOrderNotifications() {
  const keys = this.getOrderNotificationKeys();

  try {
    this.orderNotifications = JSON.parse(
      localStorage.getItem(keys.notifications) || "[]"
    );

    this.orderUnreadCount = this.orderNotifications.filter(
      item => !item.read
    ).length;
  } catch {
    this.orderNotifications = [];
    this.orderUnreadCount = 0;
  }
},

// ========================
// TÊN TRẠNG THÁI ĐƠN HÀNG
// ========================
tenTrangThaiDonHang(status) {
  const labels = {
    ChoXacNhan: "Chờ xác nhận",
    DaXacNhan: "Đã xác nhận",
    DangChuanBi: "Đang chuẩn bị hàng",
    DangGiao: "Đang giao hàng",
    DaGiao: "Đã giao hàng",
    DaHuy: "Đã hủy",
  };

  return labels[status] || status || "Đang cập nhật";
},

// ========================
// KIỂM TRA THAY ĐỔI TRẠNG THÁI ĐƠN HÀNG
// ========================
async loadOrderNotification() {
  const token = localStorage.getItem("token");
  const checkLogin = localStorage.getItem("isLogin");

  if (!token || checkLogin !== "true") {
    this.orderUnreadCount = 0;
    this.orderNotifications = [];
    return;
  }

  try {
    const response = await axios.get(
      `${API}/don-hang/get-data`,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );

    if (response.data?.status !== true) return;

    const orders = Array.isArray(response.data.data)
      ? response.data.data
      : [];

    const keys = this.getOrderNotificationKeys();

    let previousSnapshot = null;
    let notifications = [];

    try {
      const savedSnapshot = localStorage.getItem(keys.snapshot);

      if (savedSnapshot) {
        previousSnapshot = JSON.parse(savedSnapshot);
      }

      notifications = JSON.parse(
        localStorage.getItem(keys.notifications) || "[]"
      );
    } catch {
      previousSnapshot = null;
      notifications = [];
    }

    const currentSnapshot = {};

    // Lần đầu chạy: lưu trạng thái làm mốc
    // Không tạo thông báo hàng loạt cho đơn hàng cũ.
    if (!previousSnapshot) {
      orders.forEach(order => {
        currentSnapshot[String(order.MaDH)] = order.TrangThaiDH;
      });

      localStorage.setItem(
        keys.snapshot,
        JSON.stringify(currentSnapshot)
      );

      localStorage.setItem(
        keys.notifications,
        JSON.stringify(notifications)
      );

      this.syncOrderNotifications();
      return;
    }

    // So sánh trạng thái cũ và mới
    orders.forEach(order => {
      const id = String(order.MaDH);
      const currentStatus = order.TrangThaiDH;
      const oldStatus = previousSnapshot[id];

      currentSnapshot[id] = currentStatus;

      if (
        oldStatus &&
        currentStatus &&
        oldStatus !== currentStatus
      ) {
        notifications.unshift({
          id: `${id}_${Date.now()}`,
          MaDH: order.MaDH,
          TrangThaiCu: oldStatus,
          TrangThaiMoi: currentStatus,
          TieuDe: `Đơn hàng #${id} vừa cập nhật`,
          NoiDung: `Trạng thái mới: ${this.tenTrangThaiDonHang(currentStatus)}`,
          NgayTao: new Date().toISOString(),
          read: false,
        });
      }
    });

    // Chỉ lưu 100 thông báo gần nhất
    notifications = notifications.slice(0, 100);

    localStorage.setItem(
      keys.snapshot,
      JSON.stringify(currentSnapshot)
    );

    localStorage.setItem(
      keys.notifications,
      JSON.stringify(notifications)
    );

    this.syncOrderNotifications();

  } catch (error) {
    console.error("Lỗi kiểm tra thông báo đơn hàng:", error);
  }
},
// ========================
// MỞ LỊCH SỬ ĐƠN HÀNG
// ========================
moLichSuDonHang() {
  // Chuyển sang trang lịch sử mua hàng
  this.$router.push("/lich-su-mua");

  // Đánh dấu tất cả thông báo đã đọc
  const keys = this.getOrderNotificationKeys();

  try {
    const notifications = JSON.parse(
      localStorage.getItem(keys.notifications) || "[]"
    );

    const readNotifications = notifications.map(item => ({
      ...item,
      read: true,
    }));

    localStorage.setItem(
      keys.notifications,
      JSON.stringify(readNotifications)
    );

    this.orderNotifications = readNotifications;
    this.orderUnreadCount = 0;
  } catch (error) {
    console.error("Lỗi đánh dấu thông báo đã đọc:", error);
  }
},

    // ========================
    // KIỂM TRA SẢN PHẨM ĐÃ CHỌN
    // ========================
    daChon(maGH) {
      return this.selectedMaGH.includes(String(maGH));
    },

    // ========================
    // CHỌN / BỎ CHỌN MỘT SẢN PHẨM
    // ========================
    chonSanPham(maGH, daChon) {
      const id = String(maGH);

      if (daChon) {
        if (!this.selectedMaGH.includes(id)) {
          this.selectedMaGH.push(id);
        }
      } else {
        this.selectedMaGH = this.selectedMaGH.filter(
          (ma) => ma !== id
        );
      }
    },

    // ========================
    // CHỌN TẤT CẢ / BỎ CHỌN TẤT CẢ
    // ========================
    chonTatCa(daChon) {
      this.selectedMaGH = daChon
        ? this.cart.map((item) => String(item.MaGH))
        : [];
    },

    // ========================
    // LẤY THÔNG TIN TÀI KHOẢN
    // ========================
    loadAccount() {
      const token = localStorage.getItem("token");
      const checkLogin = localStorage.getItem("isLogin");

      this.isLoggedIn =
        Boolean(token) && checkLogin === "true";

      try {
        this.user = this.isLoggedIn
          ? JSON.parse(localStorage.getItem("user") || "null")
          : null;
      } catch {
        this.user = null;
        this.isLoggedIn = false;
      }
    },

    // ========================
    // ĐI ĐẾN TRANG THANH TOÁN
    // ========================
    muaHang() {
      if (this.selectedMaGH.length === 0) {
        this.$toast.error("Vui lòng chọn sản phẩm muốn mua.");
        return;
      }

      // Chỉ lưu mã các dòng giỏ hàng được chọn
      localStorage.setItem(
        "checkoutSelectedMaGH",
        JSON.stringify(this.selectedMaGH)
      );

      this.$router.push("/thanh-toantoan");
    },

    // ========================
    // LẤY GIỎ HÀNG TỪ DATABASE
    // ========================
    async loadCart() {
      const token = localStorage.getItem("token");

      if (!token) {
        this.cart = [];
        this.selectedMaGH = [];
        this.daKhoiTaoChon = false;
        return;
      }

      try {
        const response = await axios.get(
          `${API}/gio-hang/get-data`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (
          response.data.status === true &&
          Array.isArray(response.data.data)
        ) {
          this.cart = response.data.data.map((row) => {
            const sp = row.san_pham || row.sanPham || {};
            const kho = sp.ton_kho || sp.tonKho || {};

            const soLuongTon = Number(
              kho.SoLuongTon ?? sp.SoLuongTon ?? 0
            );

            const soLuongDangGiu = Number(
              kho.SoLuongDangGiu ?? sp.SoLuongDangGiu ?? 0
            );

            return {
              MaGH: row.MaGH,
              MaSP: row.MaSP ?? sp.MaSP,
              ten: sp.TenSP || "Sản phẩm",
              gia: Number(sp.GiaBan || 0),
              hinh: sp.HinhAnh || "",
              soluong: Number(row.SoLuong || 1),

              soLuongKhaDung: Math.max(
                0,
                soLuongTon - soLuongDangGiu
              ),

              TrangThaiSP: sp.TrangThaiSP,
            };
          });

          const danhSachMaGH = this.cart.map(
            (item) => String(item.MaGH)
          );

          if (!this.daKhoiTaoChon) {
            // Lần đầu mở giỏ: mặc định chọn tất cả
            this.selectedMaGH = [...danhSachMaGH];
            this.daKhoiTaoChon = true;
          } else {
            // Khi cập nhật giỏ: giữ các lựa chọn còn tồn tại
            this.selectedMaGH = this.selectedMaGH.filter(
              (ma) => danhSachMaGH.includes(ma)
            );
          }
        } else {
          this.cart = [];
          this.selectedMaGH = [];
          this.daKhoiTaoChon = true;
        }
      } catch (error) {
        console.error("Lỗi tải giỏ hàng:", error);

        this.cart = [];
        this.selectedMaGH = [];
        this.daKhoiTaoChon = false;

        if (error.response?.status === 401) {
          this.$toast.error(
            "Phiên đăng nhập hết hạn. Vui lòng đăng nhập lại."
          );
        }
      }
    },

    // ========================
    // TĂNG SỐ LƯỢNG
    // ========================
    async tangSL(maGH) {
      const item = this.cart.find(
        (sp) => String(sp.MaGH) === String(maGH)
      );

      if (!item) return;

      if (item.TrangThaiSP === "NgungBan") {
        this.$toast.error("Sản phẩm đã ngừng kinh doanh.");
        return;
      }

      if (item.soluong >= item.soLuongKhaDung) {
        this.$toast.error(
          `Chỉ còn ${item.soLuongKhaDung} sản phẩm có thể bán.`
        );
        return;
      }

      try {
        const token = localStorage.getItem("token");

        const response = await axios.put(
          `${API}/gio-hang/update`,
          {
            MaGH: item.MaGH,
            SoLuong: item.soluong + 1,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.data.status === true) {
          await this.loadCart();
          this.$toast.success("Đã tăng số lượng.");
        } else {
          this.$toast.error(
            response.data.message || "Không thể tăng số lượng."
          );
        }
      } catch (error) {
        console.error("Lỗi tăng số lượng:", error);

        this.$toast.error(
          error.response?.data?.message ||
          "Không thể cập nhật số lượng sản phẩm."
        );
      }
    },

    // ========================
    // GIẢM SỐ LƯỢNG
    // ========================
    async giamSL(maGH) {
      const item = this.cart.find(
        (sp) => String(sp.MaGH) === String(maGH)
      );

      if (!item || item.soluong <= 1) return;

      try {
        const token = localStorage.getItem("token");

        const response = await axios.put(
          `${API}/gio-hang/update`,
          {
            MaGH: item.MaGH,
            SoLuong: item.soluong - 1,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.data.status === true) {
          await this.loadCart();
        } else {
          this.$toast.error(
            response.data.message || "Không thể giảm số lượng."
          );
        }
      } catch (error) {
        console.error("Lỗi giảm số lượng:", error);

        this.$toast.error(
          error.response?.data?.message ||
          "Không thể cập nhật số lượng sản phẩm."
        );
      }
    },

    // ========================
    // XÓA SẢN PHẨM KHỎI GIỎ
    // ========================
    async xoaSP(maGH) {
      const item = this.cart.find(
        (sp) => String(sp.MaGH) === String(maGH)
      );

      if (!item) return;

      try {
        const token = localStorage.getItem("token");

        const response = await axios.delete(
          `${API}/gio-hang/delete`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
            data: {
              id: item.MaGH,
            },
          }
        );

        if (response.data.status === true) {
          await this.loadCart();
          this.$toast.success("Đã xóa sản phẩm khỏi giỏ hàng.");
        } else {
          this.$toast.error(
            response.data.message || "Không thể xóa sản phẩm."
          );
        }
      } catch (error) {
        console.error("Lỗi xóa sản phẩm:", error);

        this.$toast.error(
          error.response?.data?.message ||
          "Không thể xóa sản phẩm khỏi giỏ hàng."
        );
      }
    },

    // ========================
    // ĐĂNG XUẤT
    // ========================
    async dangXuat() {
      const token = localStorage.getItem("token");

      try {
        if (token) {
          await axios.post(
            `${API}/client/dang-xuat`,
            {},
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );
        }
      } catch (error) {
        console.error("Lỗi gọi API đăng xuất:", error);
      } finally {
        localStorage.removeItem("token");
        localStorage.removeItem("isLogin");
        localStorage.removeItem("user");
        localStorage.removeItem("checkoutSelectedMaGH");

        this.user = null;
        this.isLoggedIn = false;
        this.cart = [];
        this.selectedMaGH = [];

        this.$toast.success("Đăng xuất thành công!");
        this.$router.push("/");
      }
    },

    // ========================
    // TÌM KIẾM
    // ========================
    timKiem() {
      this.$router.push({
        path: "/tim-kiem",
        query: {
          q: this.keyword,
        },
      });
    },
  },
};
</script>
<style scoped>


/* Chọn sản phẩm trong giỏ */
.cart-select {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.cart-select input,
.chon-tat-ca input {
  width: 17px;
  height: 17px;
  accent-color: #ef4444;
  cursor: pointer;
}

.chon-tat-ca {
  display: flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  cursor: pointer;
  font-size: 11px;
  color: #555;
}

/* Không cho bấm mua khi chưa chọn sản phẩm */
.checkout-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Căn chỉnh dòng sản phẩm sau khi thêm ô checkbox */
.cart-item {
  align-items: center;
}

.cart-select {
  align-self: center;
}

/* =====================================================
   TOP
===================================================== */

.top-client {
  position: sticky;

  top: 0;

  z-index: 9999;

  background: rgba(255, 255, 255, 0.92);

  backdrop-filter: blur(20px);

  -webkit-backdrop-filter: blur(20px);

  border-bottom: 1px solid rgba(0, 0, 0, 0.07);

  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
}

/* =====================================================
   INNER
===================================================== */

.top-inner {
  width: 100%;

  padding: 14px 35px;

  display: flex;

  align-items: center;

  gap: 28px;
}

/* =====================================================
   BRAND
===================================================== */

.brand-box {
  display: flex;

  align-items: center;

  gap: 12px;

  min-width: 205px;

  cursor: pointer;

  user-select: none;

  transition: 0.25s ease;
}

.brand-box:hover {
  transform: translateY(-2px);
}

.brand-icon {
  width: 48px;

  height: 48px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 15px;

  color: white;

  font-size: 20px;

  background: linear-gradient(135deg, #ef4444, #b91c1c);

  box-shadow: 0 10px 22px rgba(239, 68, 68, 0.25);

  transition: 0.3s ease;
}

.brand-box:hover .brand-icon {
  transform: rotate(-5deg) scale(1.05);
}

.brand-text {
  line-height: 1;
}

.brand-name {
  font-size: 23px;

  font-weight: 900;

  color: #171717;

  letter-spacing: -0.8px;
}

.brand-name span {
  color: #ef4444;
}

.brand-sub {
  margin-top: 6px;

  font-size: 7px;

  font-weight: 800;

  color: #9ca3af;

  letter-spacing: 2.8px;
}

/* =====================================================
   SEARCH
===================================================== */

.search-area {
  flex: 1;

  max-width: 760px;
}

.search-box {
  position: relative;

  width: 100%;

  height: 52px;

  display: flex;

  align-items: center;

  padding-left: 48px;

  padding-right: 8px;

  border-radius: 17px;

  background: #f5f6f8;

  border: 1px solid #e7e8ec;

  transition: 0.3s ease;
}

.search-box:focus-within {
  background: white;

  border-color: rgba(239, 68, 68, 0.45);

  box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.07);
}

.search-icon {
  position: absolute;

  left: 18px;

  color: #9ca3af;

  font-size: 15px;

  transition: 0.25s ease;
}

.search-box:focus-within .search-icon {
  color: #ef4444;
}

.search-input {
  width: 100%;

  height: 100%;

  border: none;

  outline: none;

  background: transparent;

  color: #222;

  font-size: 14px;
}

.search-input::placeholder {
  color: #a5a9b2;
}

.search-button {
  height: 38px;

  padding: 0 18px;

  border: none;

  border-radius: 12px;

  color: white;

  font-weight: 700;

  font-size: 12px;

  background: linear-gradient(135deg, #ef4444, #dc2626);

  cursor: pointer;

  transition: 0.25s ease;

  box-shadow: 0 7px 18px rgba(239, 68, 68, 0.2);
}

.search-button:hover {
  transform: translateY(-1px);

  box-shadow: 0 10px 22px rgba(239, 68, 68, 0.28);
}

/* =====================================================
   ACTIONS
===================================================== */

.top-actions {
  display: flex;

  align-items: center;

  gap: 6px;

  margin-left: auto;
}

.action-item {
  position: relative;

  min-height: 48px;

  padding: 6px 10px;

  display: flex;

  align-items: center;

  gap: 10px;

  border-radius: 14px;

  cursor: pointer;

  transition: 0.25s ease;
}

.action-item:hover {
  background: #f5f6f8;
}

.action-icon {
  position: relative;

  width: 40px;

  height: 40px;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 12px;

  background: #f3f4f6;

  color: #444;

  font-size: 16px;

  transition: 0.25s ease;
}

.action-item:hover .action-icon {
  background: rgba(239, 68, 68, 0.1);

  color: #ef4444;
}

.action-content {
  display: flex;

  flex-direction: column;

  gap: 3px;

  min-width: 62px;
}

.action-title {
  color: #292929;

  font-size: 12px;

  font-weight: 800;
}

.action-content small {
  color: #9ca3af;

  font-size: 9px;
}

/* =====================================================
   CART BADGE
===================================================== */

.badge-cart {
  position: absolute;

  top: -6px;

  right: -6px;

  min-width: 18px;

  height: 18px;

  padding: 0 5px;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 999px;

  background: #ef4444;

  color: white;

  font-size: 9px;

  font-weight: 800;

  border: 2px solid white;

  box-shadow: 0 3px 10px rgba(239, 68, 68, 0.25);
}

/* =====================================================
   CART DROPDOWN
===================================================== */

.cart-dropdown {
    width: 410px;
    margin-top: 12px !important;
    padding: 0;
    border: 1px solid #eceef2;
    border-radius: 20px;

    /* Không để giỏ hàng vượt khỏi chiều cao màn hình */
    max-height: calc(100vh - 100px);

    /* Có thanh cuộn khi danh sách quá dài */
    overflow-y: auto;
    overflow-x: hidden;
    overscroll-behavior: contain;

    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 25px 70px rgba(15, 23, 42, 0.14);
}

/* =====================================================
   CART HEADER
===================================================== */

.cart-header {
  display: flex;

  align-items: center;

  justify-content: space-between;

  padding: 18px 20px;

  border-bottom: 1px solid #f0f1f3;
}

.cart-header > div:first-child {
  display: flex;

  flex-direction: column;

  gap: 4px;
}

.cart-header strong {
  color: #202124;

  font-size: 17px;
}

.cart-header span {
  color: #9ca3af;

  font-size: 10px;
}

.cart-header-icon {
  width: 39px;

  height: 39px;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 12px;

  background: rgba(239, 68, 68, 0.09);

  color: #ef4444;
}

/* =====================================================
   EMPTY
===================================================== */

.empty-cart {
  padding: 42px 25px;

  text-align: center;
}

.empty-icon {
  width: 65px;

  height: 65px;

  margin: 0 auto 14px;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 20px;

  background: #f5f6f8;

  color: #c5c8ce;

  font-size: 26px;
}

.empty-cart h6 {
  margin: 0 0 6px;

  color: #333;

  font-size: 14px;
}

.empty-cart p {
  margin: 0;

  color: #a0a5ad;

  font-size: 11px;
}

/* =====================================================
   ITEM
===================================================== */

.cart-item {
  position: relative;

  display: flex;

  gap: 12px;

  padding: 15px 18px;

  border-bottom: 1px solid #f0f1f3;

  transition: 0.2s ease;
}

.cart-item:hover {
  background: #fafafa;
}

.cart-image {
  width: 76px;

  height: 76px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 14px;

  background: #f6f7f8;

  overflow: hidden;
}

.cart-image img {
  width: 100%;

  height: 100%;

  object-fit: contain;
}

.cart-info {
  flex: 1;

  min-width: 0;
}

.cart-info h6 {
  margin: 2px 0 7px;

  padding-right: 22px;

  color: #252525;

  font-size: 13px;

  font-weight: 700;

  line-height: 1.4;

  display: -webkit-box;

  -webkit-line-clamp: 2;

  -webkit-box-orient: vertical;

  overflow: hidden;
}

.cart-price {
  color: #ef4444;

  font-size: 13px;

  font-weight: 800;
}

.qty-row {
  margin-top: 9px;
}

.qty-box {
  width: fit-content;

  display: flex;

  align-items: center;

  gap: 10px;

  padding: 4px;

  border: 1px solid #e7e8ec;

  border-radius: 10px;
}

.qty-box button {
  width: 25px;

  height: 25px;

  border: none;

  border-radius: 7px;

  background: #f4f5f7;

  color: #555;

  cursor: pointer;

  font-size: 9px;

  transition: 0.2s ease;
}

.qty-box button:hover {
  background: #ef4444;

  color: white;
}

.qty-box span {
  min-width: 18px;

  text-align: center;

  color: #333;

  font-size: 11px;

  font-weight: 800;
}

.remove-btn {
  position: absolute;

  right: 16px;

  top: 16px;

  border: none;

  background: transparent;

  color: #c5c8ce;

  cursor: pointer;

  transition: 0.2s ease;
}

.remove-btn:hover {
  color: #ef4444;

  transform: scale(1.1);
}

/* =====================================================
   FOOTER CART
===================================================== */

.cart-footer {
  padding: 17px 18px 18px;

  background: #fcfcfd;
}

.total-row {
  display: flex;

  align-items: center;

  justify-content: space-between;

  margin-bottom: 13px;
}

.total-row span {
  color: #777d87;

  font-size: 12px;
}

.total-row strong {
  color: #22c55e;

  font-size: 18px;
}

.checkout-btn {
  width: 100%;

  height: 46px;

  display: flex;

  align-items: center;

  justify-content: center;

  gap: 8px;

  border: none;

  border-radius: 12px;

  color: white;

  background: linear-gradient(135deg, #22c55e, #16a34a);

  font-size: 13px;

  font-weight: 800;

  cursor: pointer;

  transition: 0.25s ease;
}

.checkout-btn:hover {
  transform: translateY(-2px);

  box-shadow: 0 10px 22px rgba(34, 197, 94, 0.2);
}

/* =====================================================
   USER DROPDOWN
===================================================== */

.user-dropdown {
  width: 215px;

  padding: 8px;

  margin-top: 12px !important;

  border: 1px solid #eceef2;

  border-radius: 17px;

  box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
}

.logout-btn {
  width: 100%;

  display: flex;

  align-items: center;

  gap: 11px;

  padding: 10px;

  border: none;

  border-radius: 12px;

  background: transparent;

  text-align: left;

  cursor: pointer;
}

.logout-btn:hover {
  background: #fff1f2;
}

.logout-icon {
  width: 38px;

  height: 38px;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 11px;

  background: #fff1f2;

  color: #ef4444;
}

.logout-btn strong {
  display: block;

  color: #333;

  font-size: 12px;
}

.logout-btn small {
  display: block;

  margin-top: 3px;

  color: #9ca3af;

  font-size: 9px;
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1200px) {
  .top-inner {
    padding: 13px 20px;

    gap: 15px;
  }

  .brand-box {
    min-width: 175px;
  }

  .action-content {
    display: none;
  }
}

@media (max-width: 768px) {
  .top-inner {
    flex-wrap: wrap;

    padding: 12px 15px;
  }

  .brand-box {
    min-width: auto;
  }

  .search-area {
    order: 3;

    flex-basis: 100%;

    max-width: none;
  }

  .search-button {
    padding: 0 13px;
  }

  .action-item {
    padding: 4px;
  }
}

@media (max-width: 480px) {
  .brand-name {
    font-size: 20px;
  }

  .brand-icon {
    width: 42px;

    height: 42px;
  }

  .search-box {
    height: 48px;
  }

  .cart-dropdown {
    width: calc(100vw - 25px);

    max-width: 410px;
  }
}

.order-action {
  position: relative;
}

.order-action-icon {
  position: relative;
}

.order-notice-badge {
  position: absolute;
  top: 0;
  left: 36px;
  z-index: 2;

  display: flex;
  align-items: center;
  justify-content: center;

  min-width: 19px;
  height: 19px;
  padding: 0 5px;

  border: 2px solid #fff;
  border-radius: 999px;

  color: #fff;
  background: #ef4444;

  font-size: 9px;
  font-weight: 900;
  line-height: 1;

  box-shadow: 0 3px 9px rgba(239, 68, 68, 0.22);
}



/* TÀI KHOẢN */
.account-trigger {
  min-width: 180px;
  gap: 10px;
}

.account-trigger-text {
  display: flex;
  flex-direction: column;
  gap: 4px;
  min-width: 0;
}

.account-trigger-text .action-title {
  max-width: 145px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.account-arrow {
  margin-left: auto;
  color: #9ca3af;
  font-size: 10px;
  transition: transform 0.2s;
}

.dropdown.show .account-arrow {
  transform: rotate(180deg);
}

/* MENU */
.user-dropdown {
  min-width: 245px;
  padding: 9px;
  margin-top: 12px !important;
  border: 1px solid #e9edf4;
  border-radius: 16px;
  box-shadow: 0 18px 45px rgba(15, 23, 42, 0.13);
}

.user-dropdown li + li {
  margin-top: 5px;
}

.account-menu-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 11px;
  background: transparent;
  text-align: left;
  cursor: pointer;
  transition: background 0.2s;
}

.account-menu-btn:hover {
  background: #f5f7fb;
}

.account-menu-btn > span:last-child {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.account-menu-btn strong {
  color: #252f43;
  font-size: 13px;
}

.account-menu-btn small {
  color: #929bad;
  font-size: 10px;
}

.account-menu-icon {
  display: grid;
  flex-shrink: 0;
  width: 39px;
  height: 39px;
  place-items: center;
  border-radius: 11px;
}

.login-icon {
  background: #edf2ff;
  color: #4165e8;
}

.register-icon {
  background: #e9f8f1;
  color: #15976a;
}

.logout-icon {
  background: #fff0f0;
  color: #ef4444;
}

.account-menu-btn.logout-btn:hover {
  background: #fff3f3;
}

.order-notice-badge {
  position: absolute;
  top: 0;
  left: 36px;
  z-index: 5;
  min-width: 19px;
  height: 19px;
  padding: 0 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #fff;
  border-radius: 999px;
  color: #fff;
  background: #ef4444;
  font-size: 9px;
  font-weight: 900;
  line-height: 1;
  box-shadow: 0 3px 9px rgba(239, 68, 68, .22);
}

.account-menu-group {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.account-menu-group .account-menu-btn {
  width: 100%;
}

/* ẢNH ĐẠI DIỆN TRÊN TOP CLIENT */
.account-avatar {
  width: 40px;
  height: 40px;
  min-width: 40px;
  padding: 0;
  border-radius: 50%;
  overflow: hidden;
  background: #f1f3f5;
  border: 2px solid #e5e7eb;
  flex-shrink: 0;
}

.account-avatar img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.account-avatar i {
  font-size: 17px;
}
</style>