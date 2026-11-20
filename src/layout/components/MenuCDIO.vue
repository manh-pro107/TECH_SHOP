<template>
  <aside
    class="tech-sidebar"
    :class="{ 'is-collapsed': collapsed }"
  >
    <!-- LOGO -->
    <div class="tech-sidebar__brand">
      <div class="tech-sidebar__logo">
        <i class="fa-solid fa-laptop"></i>
      </div>

      <div class="tech-sidebar__brand-text">
        <span class="tech-sidebar__brand-name">TechShop</span>
        <span class="tech-sidebar__brand-subtitle">ADMINISTRATION</span>
      </div>
    </div>

    <!-- MENU -->
    <nav class="tech-sidebar__nav">

      <div class="tech-sidebar__section-title">
        TỔNG QUAN
      </div>

      <router-link
        to="/admin/tongquan"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Tổng quan"
      >
        <i class="fa-solid fa-gauge-high"></i>
        <span>Tổng quan</span>
      </router-link>

      <div class="tech-sidebar__section-title">
        QUẢN LÝ
      </div>

      <router-link
        to="/admin/danhmuc"
        class="tech-sidebar__item"
        title="Quản lý danh mục"
      >
        <i class="fa-solid fa-layer-group"></i>
        <span>Quản lý danh mục</span>
      </router-link>

      <router-link
        to="/admin/sanpham"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý sản phẩm"
      >
        <i class="fa-solid fa-box"></i>
        <span>Quản lý sản phẩm</span>
      </router-link>

      <router-link
        to="/admin/phanquyen"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý người dùng"
      >
        <i class="fa-solid fa-user-shield"></i>
        <span>Quản lý người dùng</span>
      </router-link>

      <router-link
        to="/admin/donhang"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý đơn hàng"
      >
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Quản lý đơn hàng</span>
      </router-link>

      <router-link
        to="/admin/voucher"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý voucher"
      >
        <i class="fa-solid fa-ticket"></i>
        <span>Quản lý voucher</span>
      </router-link>

      <div class="tech-sidebar__section-title">
        CHĂM SÓC KHÁCH HÀNG
      </div>

      <router-link
        to="/admin/chamsockh"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Chăm sóc khách hàng"
      >
        <i class="fa-solid fa-headset"></i>
        <span>Chăm sóc khách hàng</span>
      </router-link>

      <router-link
        to="/admin/binhluan"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý bình luận"
      >
        <i class="fa-regular fa-comments"></i>
        <span>Quản lý bình luận</span>
      </router-link>

      <router-link
        to="/admin/quanlykho"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý Kho"
      >
      <i class="fa-solid fa-warehouse"></i>
        <span>Quản lý Kho</span>
      </router-link>

      <router-link
        to="/admin/chatbot"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Quản lý chatbot"
      >
        <i class="fa-solid fa-robot"></i>
        <span>Quản lý chatbot</span>
      </router-link>

      <div class="tech-sidebar__section-title tech-sidebar__section-title--report">
        BÁO CÁO
      </div>

      <router-link
        to="/admin/baocao"
        class="tech-sidebar__item"
				active-class="is-active"
        title="Báo cáo doanh thu"
      >
        <i class="fa-solid fa-chart-pie"></i>
        <span>Báo cáo doanh thu</span>
      </router-link>

    </nav>

    <!-- THẺ CUỐI MENU -->
    <div class="tech-sidebar__bottom">
      <div class="tech-sidebar__illustration">
        <i class="fa-solid fa-desktop"></i>
        <i class="fa-solid fa-microchip"></i>
        <i class="fa-solid fa-mobile-screen-button"></i>
      </div>

      <div class="tech-sidebar__bottom-title">
        TechShop Admin
      </div>

      <p class="tech-sidebar__bottom-description">
        Quản lý dễ dàng · Kinh doanh hiệu quả
      </p>

      <div class="tech-sidebar__status">
        <span class="tech-sidebar__status-dot"></span>
        Hệ thống quản lý
      </div>
    </div>
  </aside>
</template>
<script>
export default {
  name: "MenuCDIO",

  props: {
    collapsed: {
      type: Boolean,
      default: false
    }
  }
};
</script>
  
  <style scoped>
  /* ========================================
	 TECHSHOP SIDEBAR
	 Toàn bộ CSS chỉ áp dụng trong component này
  ======================================== */
  
  
.tech-sidebar {
  --sidebar-bg: #0d1b32;
  --sidebar-text: #d8e5fa;
  --sidebar-muted: #91a7c7;
  --sidebar-blue: #1677ff;

  box-sizing: border-box;
  width: 288px;
  min-width: 288px;
  height: 100vh;
  margin: 0;
  padding: 22px 15px 16px;

  display: flex;
  flex-direction: column;
  flex-shrink: 0;

  color: var(--sidebar-text);
  background:
    radial-gradient(
      circle at 0% 0%,
      rgba(35, 112, 230, 0.18),
      transparent 38%
    ),
    linear-gradient(180deg, #142746 0%, var(--sidebar-bg) 100%);

  border: none;
  border-radius: 0;
  box-shadow: none;

  overflow: hidden;
}

  
  /* Logo */
  
  .tech-sidebar__brand {
	display: flex;
	align-items: center;
	gap: 12px;
	padding: 5px 9px 25px;
	margin-bottom: 18px;
	border-bottom: 1px solid rgba(255, 255, 255, 0.09);
  }
  
  .tech-sidebar__logo {
	width: 48px;
	height: 48px;
	flex-shrink: 0;
  
	display: flex;
	align-items: center;
	justify-content: center;
  
	color: #fff;
	font-size: 22px;
  
	background: linear-gradient(135deg, #258bff, #3158ef);
	border: 1px solid rgba(255, 255, 255, 0.25);
	border-radius: 15px;
	box-shadow: 0 7px 20px rgba(22, 119, 255, 0.3);
  }
  
  .tech-sidebar__brand-text {
	min-width: 0;
	display: flex;
	flex-direction: column;
	gap: 4px;
  }
  
  .tech-sidebar__brand-name {
	color: #58a4ff;
	font-size: 25px;
	font-weight: 800;
	letter-spacing: -0.8px;
	line-height: 1.1;
  }
  
  .tech-sidebar__brand-subtitle {
	color: #9db6da;
	font-size: 9px;
	font-weight: 700;
	letter-spacing: 2px;
  }
  
  /* Khu vực menu */
  
  .tech-sidebar__nav {
	display: flex;
	flex-direction: column;
	gap: 6px;
	min-height: 0;
	flex: 1;
	overflow-y: auto;
	overflow-x: hidden;
	scrollbar-width: thin;
	scrollbar-color: #344d70 transparent;
  }
  
  .tech-sidebar__section-title {
	padding: 8px 12px;
	margin: 0 0 5px;
  
	color: var(--sidebar-muted);
	font-size: 10px;
	font-weight: 800;
	letter-spacing: 1.5px;
  }
  
  .tech-sidebar__section-title--report {
	margin-top: 14px;
  }
  
  /* Mỗi mục menu */
  
  .tech-sidebar__item {
	position: relative;
	box-sizing: border-box;
	min-height: 49px;
	width: 100%;
	padding: 0 13px;
  
	display: flex;
	align-items: center;
	gap: 13px;
  
	color: var(--sidebar-text);
	text-decoration: none;
	font-size: 13px;
	font-weight: 500;
  
	border: 1px solid transparent;
	border-radius: 12px;
	background: transparent;
  
	transition:
	  background 0.22s ease,
	  color 0.22s ease,
	  border-color 0.22s ease,
	  transform 0.22s ease,
	  box-shadow 0.22s ease;
  }
  
  .tech-sidebar__item > i:first-child {
	width: 20px;
	flex-shrink: 0;
	color: #9eb6d8;
	font-size: 17px;
	text-align: center;
	transition: color 0.22s ease;
  }
  
  .tech-sidebar__item > span {
	min-width: 0;
	flex: 1;
  }
  
  .tech-sidebar__item:hover {
	color: #fff;
	background: rgba(255, 255, 255, 0.075);
	border-color: rgba(255, 255, 255, 0.06);
	transform: translateX(3px);
  }
  
  .tech-sidebar__item:hover > i:first-child {
	color: #69b1ff;
  }
  
  /* Mục hiện tại */
  
  .tech-sidebar__item.is-active {
	color: #fff;
	font-weight: 700;
  
	background: linear-gradient(105deg, #176fe9, #1454b6);
	border-color: rgba(113, 174, 255, 0.3);
	box-shadow: 0 7px 18px rgba(0, 88, 220, 0.2);
  }
  
  .tech-sidebar__item.is-active::before {
	content: "";
	position: absolute;
	top: 11px;
	bottom: 11px;
	left: 0;
	width: 3px;
  
	background: #a9d7ff;
	border-radius: 0 5px 5px 0;
  }
  
  .tech-sidebar__item.is-active > i:first-child {
	color: #fff;
  }
  
  .tech-sidebar__arrow {
	margin-left: auto;
	color: #c8e0ff !important;
	font-size: 10px !important;
  }
  
  /* Thẻ cuối menu */
  
  .tech-sidebar__bottom {
	flex-shrink: 0;
	margin-top: 18px;
	padding: 20px 10px 16px;
  
	text-align: center;
	background: linear-gradient(
	  145deg,
	  rgba(37, 91, 157, 0.38),
	  rgba(23, 48, 83, 0.68)
	);
  
	border: 1px solid rgba(146, 190, 255, 0.12);
	border-radius: 15px;
  }
  
  .tech-sidebar__illustration {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 18px;
	margin-bottom: 16px;
	color: #65b2ff;
  }
  
  .tech-sidebar__illustration i {
	font-size: 25px;
	transition: transform 0.25s ease;
  }
  
  .tech-sidebar__bottom:hover .tech-sidebar__illustration i {
	transform: translateY(-3px);
  }
  
  .tech-sidebar__illustration i:nth-child(2) {
	color: #9294ff;
	font-size: 29px;
  }
  
  .tech-sidebar__bottom-title {
	color: #fff;
	font-size: 13px;
	font-weight: 800;
  }
  
  .tech-sidebar__bottom-description {
	margin: 9px 0 13px;
	color: #a9bfdf;
	font-size: 10px;
	line-height: 1.6;
  }
  
  .tech-sidebar__status {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 7px;
	padding: 6px 10px;
  
	color: #b8f5db;
	font-size: 10px;
	background: rgba(19, 170, 117, 0.12);
	border: 1px solid rgba(61, 220, 159, 0.14);
	border-radius: 30px;
  }
  
  .tech-sidebar__status-dot {
	width: 7px;
	height: 7px;
	background: #2bd49b;
	border-radius: 50%;
	box-shadow: 0 0 9px rgba(43, 212, 155, 0.5);
  }
  
  /* Màn hình nhỏ */
  
  
@media (max-width: 992px) {
  .tech-sidebar {
    width: 245px;
    min-width: 245px;
    margin: 0;
  }

  .tech-sidebar__brand-name {
    font-size: 22px;
  }
}

  
  @media (max-height: 650px) {
	.tech-sidebar {
	  height: calc(100vh - 12px);
	  margin-top: 6px;
	  margin-bottom: 6px;
	  padding-top: 14px;
	}
  
	.tech-sidebar__brand {
	  padding-bottom: 15px;
	  margin-bottom: 10px;
	}
  
	.tech-sidebar__item {
	  min-height: 42px;
	}
  
	.tech-sidebar__bottom {
	  margin-top: 10px;
	  padding-top: 12px;
	  padding-bottom: 10px;
	}
  }

	/* =========================================
   HIỆU ỨNG THU GỌN / MỞ RỘNG SIDEBAR
========================================= */

.tech-sidebar {
  box-sizing: border-box;
  flex: 0 0 288px;

  width: 288px;
  min-width: 288px;

  transition:
    width 0.32s cubic-bezier(0.4, 0, 0.2, 1),
    min-width 0.32s cubic-bezier(0.4, 0, 0.2, 1),
    flex-basis 0.32s cubic-bezier(0.4, 0, 0.2, 1),
    padding 0.32s ease;
}

/* Logo */
.tech-sidebar__brand-text {
  white-space: nowrap;
  overflow: hidden;

  transition:
    opacity 0.2s ease,
    transform 0.3s ease;
}

/* Tiêu đề nhóm */
.tech-sidebar__section-title {
  max-height: 40px;
  overflow: hidden;
  white-space: nowrap;

  transition:
    max-height 0.3s ease,
    opacity 0.2s ease,
    padding 0.3s ease,
    margin 0.3s ease;
}

/* Tên menu */
.tech-sidebar__item {
  white-space: nowrap;
}

.tech-sidebar__item > span {
  overflow: hidden;
  white-space: nowrap;

  transition:
    opacity 0.2s ease,
    max-width 0.3s ease,
    transform 0.3s ease;
}

.tech-sidebar__item > i:first-child {
  flex-shrink: 0;
  transition: transform 0.25s ease, color 0.25s ease;
}

/* Thẻ cuối */
.tech-sidebar__bottom {
  overflow: hidden;
  transition:
    opacity 0.2s ease,
    max-height 0.3s ease,
    padding 0.3s ease,
    margin 0.3s ease;
}

/* =========================================
   TRẠNG THÁI THU GỌN
========================================= */

.tech-sidebar.is-collapsed {
  flex-basis: 82px;
  width: 82px;
  min-width: 82px;

  padding-left: 10px;
  padding-right: 10px;
}

/* Ẩn chữ logo */
.tech-sidebar.is-collapsed .tech-sidebar__brand {
  justify-content: center;
  padding-left: 0;
  padding-right: 0;
}

.tech-sidebar.is-collapsed .tech-sidebar__brand-text {
  width: 0;
  max-width: 0;
  opacity: 0;
  transform: translateX(-8px);
}

/* Ẩn tiêu đề nhóm */
.tech-sidebar.is-collapsed .tech-sidebar__section-title {
  max-height: 0;
  padding-top: 0;
  padding-bottom: 0;
  margin: 0;
  opacity: 0;
}

/* Căn icon giữa */
.tech-sidebar.is-collapsed .tech-sidebar__item {
  justify-content: center;
  gap: 0;
  padding-left: 0;
  padding-right: 0;
}

.tech-sidebar.is-collapsed .tech-sidebar__item > span {
  max-width: 0;
  opacity: 0;
  transform: translateX(-8px);
}

.tech-sidebar.is-collapsed .tech-sidebar__item > i:first-child {
  margin: 0;
  font-size: 19px;
}

/* Ẩn mũi tên */
.tech-sidebar.is-collapsed .tech-sidebar__arrow {
  display: none;
}

/* Ẩn thẻ cuối */
.tech-sidebar.is-collapsed .tech-sidebar__bottom {
  max-height: 0;
  margin: 0;
  padding-top: 0;
  padding-bottom: 0;
  opacity: 0;
  border: 0;
}

/* Hover icon khi thu gọn */
.tech-sidebar.is-collapsed .tech-sidebar__item:hover > i:first-child {
  transform: scale(1.15);
}

/* Logo căn giữa */
.tech-sidebar.is-collapsed .tech-sidebar__brand {
  margin-bottom: 18px;
}
  </style>