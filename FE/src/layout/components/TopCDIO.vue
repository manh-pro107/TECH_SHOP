<template>
    <header class="top-wrapper">
      <div class="topbar">
  
        <!-- LEFT -->
        <div class="left">
          <div class="logo-box">
            <div class="logo-icon">
              <i class='bx bx-laptop'></i>
            </div>
            <span class="logo-text">TechShop</span>
          </div>
        </div>
  
        <!-- CENTER -->
        <div class="center">
          <div class="search-box">
            <i class="bx bx-search"></i>
            <input type="text" placeholder="Search product" />
            <div class="shortcut">
              <span>K</span>
              <span>⌘</span>
            </div>
          </div>
        </div>
  
        <!-- RIGHT -->
        <div class="right d-flex align-items-center gap-3">

<!-- 🔔 Notifications -->
<div class="dropdown">
  <div class="icon position-relative" data-bs-toggle="dropdown">
	<i class="bx bx-bell"></i>
	<span class="badge">3</span>
  </div>

  <ul class="dropdown-menu dropdown-menu-end p-2 shadow">
	<li class="fw-bold px-2">Thông báo</li>
	<li><hr class="dropdown-divider"></li>
	<li><a class="dropdown-item">Có đơn hàng mới</a></li>
	<li><a class="dropdown-item">Khách hàng đăng ký</a></li>
	<li><a class="dropdown-item">Sản phẩm mới</a></li>
  </ul>
</div>

<!-- ❓ Help -->
<!-- <div class="dropdown">
  <div class="icon" data-bs-toggle="dropdown">
	<i class="bx bx-help-circle"></i>
  </div>

  <ul class="dropdown-menu dropdown-menu-end shadow">
	<li><a class="dropdown-item">Trung tâm hỗ trợ</a></li>
	<li><a class="dropdown-item">Liên hệ</a></li>
  </ul>
</div> -->

<!-- 👤 User -->
<div class="dropdown">
  <div class="user d-flex align-items-center gap-2" data-bs-toggle="dropdown">
	
	<div class="avatar">★</div>

	<div class="info">
	  <div class="name">{{ admin.HoTen }}</div>
<div class="role">Admin</div>
	  
	</div>

	<i class="bx bx-chevron-down"></i>
  </div>

  <ul class="dropdown-menu dropdown-menu-end shadow">
	<li><a class="dropdown-item"><i class="bx bx-user me-2"></i>Profile</a></li>
	<li><a class="dropdown-item"><i class="bx bx-cog me-2"></i>Settings</a></li>
	<li><hr class="dropdown-divider"></li>
	<li><a class="dropdown-item text-danger"><i class="bx bx-log-out me-2"></i>Logout</a></li>
  </ul>
</div>

</div>
  
      </div>
    </header>
  </template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            admin: {
                HoTen: "Đang tải..."
            }
        }
    },

    mounted() {
        axios
            .get("http://127.0.0.1:8000/api/nguoi-dung/get-data")
            .then((res) => {
                if (res.data.status) {
                    const danhSach = res.data.data;

                    const admin = danhSach.find(
                        (item) => Number(item.MaQuyen) === 1
                    );

                    if (admin) {
                        this.admin = admin;
                    }
                }
            })
            .catch((error) => {
                console.log("Lỗi lấy thông tin admin:", error);
            });
    }
}
</script>
<style scoped>

/* ICON */
.icon {
  width: 40px;
  height: 40px;
  background: #f1f3f7;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.3s;
  position: relative;
}

.icon:hover {
  background: #ff6a00;
  color: #fff;
  transform: translateY(-2px);
}

/* Badge số */
.badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #ff3b3b;
  color: #fff;
  font-size: 10px;
  padding: 3px 6px;
  border-radius: 50%;
}

/* USER */
.user {
  background: #f9fafc;
  padding: 6px 12px;
  border-radius: 50px;
  cursor: pointer;
  transition: 0.3s;
}

.user:hover {
  background: #eef2f7;
}

.avatar {
  width: 35px;
  height: 35px;
  background: linear-gradient(135deg, #ff6a00, #ffb347);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: bold;
}

.name {
  font-weight: 600;
  font-size: 14px;
}

.role {
  font-size: 12px;
  color: #999;
}

/* Dropdown đẹp hơn */
.dropdown-menu {
  border-radius: 12px;
  border: none;
}
/* nền ngoài */
.top-wrapper {
  background: #f5f7fb;
  padding: 20px;
}

/* thanh chính */
.topbar {
  max-width: 1200px;
  margin: auto;
  background: #fff;
  border-radius: 20px;
  padding: 12px 20px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
.topbar {
  max-width: unset;
  margin: 0;
  margin-left: 10px;
  margin-right: 10px;
  margin-top: 10px;
}

/* LEFT */
.logo-box {
	display: flex;
  align-items: center;
  gap: 10px;

  background: #f3f4f6;
  padding: 3px 10px;
  border-radius: 30px;
  margin: 5px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05); /* nhẹ nhẹ */
}
.logo-box:hover {
  transform: translateY(-2px);
  transition: 0.3s;
}

/* .logo-icon {
  width: 40px;
  height: 40px;
  background: #ff6a00;
  border-radius: 12px;

  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
} */

.logo-text {
  font-weight: 700;
  font-size: 18px;

  background: linear-gradient(270deg, #8e715d, #21a147, #ff9a44);
  background-size: 200% 200%;

  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;

  animation: gradientMove 3s ease infinite;
}

@keyframes gradientMove {
  0% { background-position: 0% }
  50% { background-position: 100% }
  100% { background-position: 0% }
}
/* CENTER SEARCH */
.center {
  flex: 1;
  display: flex;
  justify-content: center;
}

.search-box {
  width: 400px;
  background: #f1f3f7;
  border-radius: 30px;
  padding: 8px 15px;

  display: flex;
  align-items: center;
  gap: 10px;
}

.search-box input {
  border: none;
  outline: none;
  background: transparent;
  flex: 1;
}

.shortcut {
  display: flex;
  gap: 5px;
}

.shortcut span {
  background: #fff;
  border-radius: 6px;
  padding: 2px 6px;
  font-size: 12px;
}

/* RIGHT */
.right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.icon {
  width: 40px;
  height: 40px;
  background: #f1f3f7;
  border-radius: 50%;

  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.3s;
}

.icon:hover {
  background: #ff6a00;
  color: white;
}

/* USER */
.user {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #f1f3f7;
  padding: 5px 10px;
  border-radius: 20px;
  cursor: pointer;
}

.avatar {
  width: 35px;
  height: 35px;
  background: #ff6a00;
  border-radius: 50%;

  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.name {
  font-weight: 600;
  font-size: 14px;
}

.role {
  font-size: 12px;
  color: #999;
}

.logo-icon {
  width: 45px;
  height: 45px;

  background: linear-gradient(135deg, #ff7a18, #ff3d00); /* màu cam xịn */
  border-radius: 50%; /* 🔥 tròn */

  display: flex;
  align-items: center;
  justify-content: center;

  color: #fff;
  font-size: 20px;

  box-shadow: 0 8px 20px rgba(255, 106, 0, 0.4); /* 🔥 bóng */
}
</style>
