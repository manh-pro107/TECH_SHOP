
<template>
  <div
    class="admin-layout"
    :class="{ 'sidebar-collapsed': sidebarCollapsed }"
  >
    <!-- SIDEBAR BÊN TRÁI -->
    <aside class="admin-sidebar">
      <MenuCDIO :collapsed="sidebarCollapsed" />
    </aside>

    <!-- KHU VỰC BÊN PHẢI -->
    <div class="admin-workspace">

      <!-- TOPBAR -->
      <div class="admin-header">
        <TopCDIO @toggle-sidebar="toggleSidebar" />
      </div>

      <!-- NỘI DUNG CÁC TRANG ADMIN -->
      <main class="admin-content">
        <div class="admin-page">
          <router-view />
        </div>

        <!-- FOOTER -->
        <footer class="admin-footer">
          <FootedCDIO />
        </footer>
      </main>

    </div>
  </div>
</template>

<script>
import TopCDIO from '../components/TopCDIO.vue';
import MenuCDIO from '../components/MenuCDIO.vue';
import FootedCDIO from '../components/FootedCDIO.vue';

export default {
  name: 'AdminLayout',

  components: {
    TopCDIO,
    MenuCDIO,
    FootedCDIO
  },

  data() {
    return {
      // Mặc định Sidebar mở rộng
      sidebarCollapsed: false
    };
  },

  methods: {
    // BẬT / TẮT SIDEBAR
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed;
    }
  }
};
</script>

<style>
/* =========================================
   TECHSHOP ADMIN LAYOUT
========================================= */

.admin-layout,
.admin-layout * {
  box-sizing: border-box;
}

.admin-layout {
  --admin-sidebar-width: 288px;
  --admin-bg: #f3f6fc;
  --admin-border: #e5edf8;
  --admin-text: #172b4d;

  display: flex;
  align-items: stretch;

  width: 100%;
  min-height: 100vh;
  margin: 0;

  color: var(--admin-text);
  background: var(--admin-bg);

  font-family: "Roboto", Arial, sans-serif;

  overflow-x: hidden;
}

/* =========================================
   SIDEBAR
========================================= */

.admin-sidebar {
  position: relative;
  z-index: 30;

  flex: 0 0 var(--admin-sidebar-width);

  width: var(--admin-sidebar-width);
  min-width: 0;
  min-height: 100vh;

  overflow: hidden;
  background: #10213d;

  transition:
    width 0.32s cubic-bezier(0.4, 0, 0.2, 1),
    flex-basis 0.32s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Sidebar con chiếm toàn bộ chiều rộng khung cha */
.admin-sidebar .tech-sidebar {
  width: 100%;
  min-width: 0;
  max-width: none;
  flex-basis: auto;
  height: 100vh;
}

/* =========================================
   SIDEBAR THU GỌN
========================================= */

.admin-layout.sidebar-collapsed {
  --admin-sidebar-width: 82px;
}

/* =========================================
   KHU VỰC BÊN PHẢI
========================================= */

.admin-workspace {
  display: flex;
  flex: 1 1 0;
  flex-direction: column;

  width: 0;
  min-width: 0;
  min-height: 100vh;

  transition: width 0.32s ease;
}

/* =========================================
   TOPBAR
========================================= */

.admin-header {
  position: sticky;
  top: 0;
  z-index: 20;

  flex: 0 0 auto;

  width: 100%;
  min-width: 0;
  min-height: 70px;

  background: #ffffff;
  border-bottom: 1px solid var(--admin-border);

  box-shadow: 0 4px 18px rgba(30, 65, 115, 0.035);
}

/* =========================================
   NỘI DUNG ROUTER
========================================= */

.admin-content {
  display: flex;
  flex: 1 0 auto;
  flex-direction: column;

  width: 100%;
  min-width: 0;

  padding: 24px;

  background:
    radial-gradient(
      ellipse at top right,
      rgba(220, 234, 255, 0.35),
      transparent 48%
    ),
    var(--admin-bg);
}

.admin-page {
  flex: 1 0 auto;

  width: 100%;
  min-width: 0;
}

/* =========================================
   FOOTER
========================================= */

.admin-footer {
  flex: 0 0 auto;

  width: 100%;
  min-width: 0;

  margin-top: 24px;
}

/* =========================================
   TABLET
========================================= */

@media (max-width: 992px) {
  .admin-content {
    padding: 18px 16px;
  }
}

/* =========================================
   MOBILE
========================================= */

@media (max-width: 768px) {
  .admin-content {
    padding: 14px 10px;
  }

  .admin-footer {
    margin-top: 16px;
  }
}
</style>

<!-- GIỮ NGUYÊN CSS THƯ VIỆN CỦA DỰ ÁN -->
<style>
@import "../../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css";
@import "../../assets/plugins/simplebar/css/simplebar.css";
@import "../../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css";
@import "../../assets/plugins/metismenu/css/metisMenu.min.css";
@import "../../assets/css/pace.min.css";
@import "../../assets/css/bootstrap.min.css";
@import "../../assets/css/bootstrap-extended.css";
@import "../../assets/css/app.css";
@import "../../assets/css/icons.css";
@import "../../assets/css/dark-theme.css";
@import "../../assets/css/semi-dark.css";
@import "../../assets/css/header-colors.css";
@import "../../assets/css/cusstom.css";

@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");
</style>
