<template>
  <header class="tech-topbar">
    <!-- Nút menu -->
    <button
      type="button"
      class="tech-topbar__menu-button"
      aria-label="Menu"
      @click="toggleSidebar"
    >
      <i class="bx bx-menu"></i>
    </button>

    <!-- Tìm kiếm -->
    <div class="tech-topbar__search">
      <i class="bx bx-search"></i>

      <input
        v-model="searchText"
        type="text"
        placeholder="Tìm kiếm sản phẩm, đơn hàng, người dùng..."
        @keyup.enter="search"
      />

      <span class="tech-topbar__shortcut">K</span>
      <span class="tech-topbar__shortcut">⌘</span>
    </div>

    <div class="tech-topbar__actions">
      <!-- Thông báo -->
      <div class="dropdown">
        <button
          type="button"
          class="tech-topbar__icon-button"
          data-bs-toggle="dropdown"
          aria-label="Thông báo"
        >
          <i class="bx bx-bell"></i>
          <span class="tech-topbar__badge">3</span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end tech-topbar__dropdown">
          <li class="tech-topbar__dropdown-heading">Thông báo</li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <span class="dropdown-item">Có đơn hàng mới</span>
          </li>
          <li>
            <span class="dropdown-item">Khách hàng đăng ký</span>
          </li>
          <li>
            <span class="dropdown-item">Sản phẩm mới</span>
          </li>
        </ul>
      </div>

      <!-- Trợ giúp -->
      <button
        type="button"
        class="tech-topbar__icon-button tech-topbar__help"
        aria-label="Trợ giúp"
        title="Trợ giúp"
      >
        <i class="bx bx-help-circle"></i>
      </button>

      
<!-- Tài khoản -->
<div class="dropdown">
  <button
    type="button"
    class="tech-topbar__user"
    :aria-expanded="showUserDropdown"
    @click.stop="showUserDropdown = !showUserDropdown"
  >
    <span class="tech-topbar__avatar">
      <i class="bx bx-star"></i>
    </span>

    <span class="tech-topbar__user-info">
      <span class="tech-topbar__name">
        {{ admin.HoTen }}
      </span>
      <span class="tech-topbar__role">Admin</span>
    </span>

    <i class="bx bx-chevron-down tech-topbar__chevron"></i>
  </button>

  <ul
    v-if="showUserDropdown"
    class="dropdown-menu dropdown-menu-end tech-topbar__dropdown show"
    @click.stop
  >
    <li>
      <span class="dropdown-item">
        <i class="bx bx-user me-2"></i>
        {{ admin.HoTen }}
      </span>
    </li>

    <li>
      <hr class="dropdown-divider" />
    </li>

    <li>
      <button
        type="button"
        class="dropdown-item text-danger"
        @click="logoutNotice"
      >
        <i class="bx bx-log-out me-2"></i>
        Đăng xuất
      </button>
    </li>
  </ul>
</div>

    </div>
  </header>
</template>


<script>
export default {
  name: "TopCDIO",

  data() {
    return {
      admin: {
        HoTen: localStorage.getItem("admin_name") || "Đang tải..."
      },
      searchText: "",
      showUserDropdown: false
    };
  },

  mounted() {
    this.kiemTraDangNhap();
  },

  methods: {
    toggleSidebar() {
      this.$emit("toggle-sidebar");
    },

    kiemTraDangNhap() {
      const token = localStorage.getItem("admin_token");
      const ten = localStorage.getItem("admin_name");
      const daDangNhap =
        localStorage.getItem("admin_logged_in");

      if (!token || daDangNhap !== "true") {
        this.chuyenTrangDangNhap();
        return;
      }

      this.admin.HoTen = ten || "Người dùng";
    },

    search() {
      const keyword = this.searchText.trim();

      if (!keyword) return;

      alert("Từ khóa tìm kiếm: " + keyword);
    },

    logoutNotice() {
      this.showUserDropdown = false;

      const xacNhan = window.confirm(
        "Bạn có chắc chắn muốn đăng xuất không?"
      );

      if (!xacNhan) return;

      this.dangXuat();
    },

    dangXuat() {
      localStorage.removeItem("admin_token");
      localStorage.removeItem("admin_name");
      localStorage.removeItem("admin_logged_in");

      this.chuyenTrangDangNhap();
    },

    chuyenTrangDangNhap() {
      const loginPath = "/admin/dang-nhap";

      // Dùng đúng đường dẫn đã khai báo trong src/router/index.js.
      if (this.$route.path === loginPath) return;

      this.$router.replace({
        path: loginPath,
        query: { redirect: this.$route.fullPath },
      });
    }
  }
};
</script>

<style scoped>
.tech-topbar,
.tech-topbar * {
  box-sizing: border-box;
}

.tech-topbar {
  position: relative;
  z-index: 20;

  min-height: 72px;
  width: 100%;
  padding: 12px 24px;

  display: flex;
  align-items: center;
  gap: 24px;

  background: rgba(255, 255, 255, 0.97);
  border-bottom: 1px solid #e7edf7;
  box-shadow: 0 4px 18px rgba(28, 57, 100, 0.035);
}

/* Nút menu */

.tech-topbar__menu-button {
  width: 40px;
  height: 40px;
  flex-shrink: 0;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  color: #18345c;
  font-size: 25px;
  background: transparent;
  border: 0;
  border-radius: 11px;
  cursor: pointer;
  transition: background 0.2s ease, color 0.2s ease;
}

.tech-topbar__menu-button:hover {
  color: #1677ff;
  background: #eff5ff;
}

/* Thanh tìm kiếm */

.tech-topbar__search {
  width: min(100%, 650px);
  height: 44px;
  padding: 0 12px 0 16px;

  display: flex;
  align-items: center;
  gap: 10px;

  background: #f2f6fc;
  border: 1px solid #edf2f9;
  border-radius: 30px;

  transition:
    background 0.2s ease,
    border-color 0.2s ease,
    box-shadow 0.2s ease;
}

.tech-topbar__search:focus-within {
  background: #fff;
  border-color: #8bbcff;
  box-shadow: 0 0 0 4px rgba(22, 119, 255, 0.08);
}

.tech-topbar__search > i {
  flex-shrink: 0;
  color: #6983a9;
  font-size: 19px;
}

.tech-topbar__search input {
  width: 100%;
  min-width: 0;
  padding: 0;

  color: #203958;
  font-family: inherit;
  font-size: 13px;

  background: transparent;
  border: 0;
  outline: none;
  box-shadow: none;
}

.tech-topbar__search input::placeholder {
  color: #96a5bb;
}

.tech-topbar__shortcut {
  min-width: 25px;
  height: 26px;
  padding: 0 5px;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  color: #6d83a3;
  font-size: 11px;
  font-weight: 600;

  background: #fff;
  border: 1px solid #e5ecf6;
  border-radius: 7px;
}

/* Cụm bên phải */

.tech-topbar__actions {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-left: auto;
}

.tech-topbar__icon-button {
  position: relative;
  width: 44px;
  height: 44px;
  flex-shrink: 0;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  color: #28466e;
  font-size: 21px;
  background: #f1f5fc;
  border: 1px solid transparent;
  border-radius: 50%;
  cursor: pointer;

  transition:
    color 0.2s ease,
    background 0.2s ease,
    transform 0.2s ease;
}

.tech-topbar__icon-button:hover {
  color: #1677ff;
  background: #e7f1ff;
  transform: translateY(-2px);
}

.tech-topbar__badge {
  position: absolute;
  top: -4px;
  right: -3px;

  min-width: 19px;
  height: 19px;
  padding: 0 4px;

  display: flex;
  align-items: center;
  justify-content: center;

  color: #fff;
  font-size: 10px;
  font-weight: 700;

  background: #ff4058;
  border: 2px solid #fff;
  border-radius: 20px;
}

/* Tài khoản */

.tech-topbar__user {
  min-height: 48px;
  max-width: 270px;
  padding: 5px 12px;

  display: flex;
  align-items: center;
  gap: 10px;

  text-align: left;
  background: #f1f5fc;
  border: 1px solid transparent;
  border-radius: 30px;
  cursor: pointer;

  transition:
    background 0.2s ease,
    border-color 0.2s ease;
}

.tech-topbar__user:hover,
.tech-topbar__user[aria-expanded="true"] {
  background: #eaf2ff;
  border-color: #d9e8ff;
}

.tech-topbar__avatar {
  width: 38px;
  height: 38px;
  flex-shrink: 0;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  color: #fff;
  font-size: 20px;

  background: linear-gradient(135deg, #ff8a26, #ff5b00);
  border-radius: 50%;
  box-shadow: 0 4px 10px rgba(255, 103, 0, 0.2);
}

.tech-topbar__user-info {
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.tech-topbar__name {
  max-width: 155px;
  overflow: hidden;

  color: #18345c;
  font-size: 13px;
  font-weight: 750;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.tech-topbar__role {
  color: #8495ad;
  font-size: 11px;
}

.tech-topbar__chevron {
  margin-left: 4px;
  color: #607896;
  font-size: 16px;
}

/* Dropdown */

.tech-topbar__dropdown {
  min-width: 210px;
  padding: 8px;

  border: 1px solid #e9eef6;
  border-radius: 14px;
  box-shadow: 0 12px 32px rgba(20, 43, 78, 0.13);
}

.tech-topbar__dropdown-heading {
  padding: 8px 10px;
  color: #1d3557;
  font-size: 13px;
  font-weight: 750;
}

.tech-topbar__dropdown .dropdown-item {
  padding: 10px;
  color: #50627c;
  font-size: 13px;
  border-radius: 8px;
}

.tech-topbar__dropdown .dropdown-item:hover {
  color: #176fe9;
  background: #eff5ff;
}

/* Responsive */

@media (max-width: 768px) {
  .tech-topbar {
    min-height: 64px;
    padding: 10px 12px;
    gap: 10px;
  }

  .tech-topbar__search {
    flex: 1;
    width: auto;
    height: 40px;
    padding-left: 11px;
  }

  .tech-topbar__search input {
    font-size: 12px;
  }

  .tech-topbar__shortcut,
  .tech-topbar__help {
    display: none;
  }

  .tech-topbar__actions {
    gap: 7px;
  }

  .tech-topbar__icon-button {
    width: 38px;
    height: 38px;
  }

  .tech-topbar__user {
    min-height: 40px;
    padding: 3px 6px;
  }

  .tech-topbar__avatar {
    width: 32px;
    height: 32px;
  }

  .tech-topbar__name,
  .tech-topbar__role,
  .tech-topbar__chevron {
    display: none;
  }
}

@media (max-width: 420px) {
  .tech-topbar {
    gap: 5px;
    padding: 8px;
  }

  .tech-topbar__menu-button {
    width: 32px;
  }

  .tech-topbar__search input::placeholder {
    color: transparent;
  }
}
</style>