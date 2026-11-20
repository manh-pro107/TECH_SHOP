
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

const routes = [

    // =========================
    // CLIENT
    // =========================

    {
        path: "/",
        redirect: "/trang-chu"
    },

    {
        path: "/trang-chu",
        component: () => import("../components/Client/TrangChu/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/chi-tiet-sp",
        component: () => import("../components/Client/ChiTietSP/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/thanh-toantoan",
        component: () => import("../components/Client/ThanhToan/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/lich-su-mua",
        component: () => import("../components/Client/LichSuMuaHang/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/danh-gia",
        component: () => import("../components/Client/DanhGia/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/tim-kiem",
        component: () => import("../components/Client/timKiem/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/thong-tin-ca-nhan",
        component: () => import("../components/Client/ThongTinCaNhan/index.vue"),
        meta: { layout: "client" }
    },
    {
        path: "/ve-chung-toi",
        name: "VeChungToi",
        component: () => import("../components/Client/VeChungToi/index.vue"),
        meta: { layout: "client" }
    },

    // =========================
    // ADMIN LOGIN
    // =========================

    {
        path: "/admin/dang-nhap",
        name: "DangNhapAdmin",
        component: () => import("../components/DangNhapAdmin/index.vue"),
        meta: { layout: "blank" }
    },

    // =========================
    // ADMIN
    // =========================

    {
        path: "/admin/tongquan",
        component: () => import("../components/TongQuan/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/danhmuc",
        component: () => import("../components/DanhMuc/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/sanpham",
        component: () => import("../components/Admin/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/chamsockh",
        component: () => import("../components/CSKH/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/donhang",
        component: () => import("../components/QLDH/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/phanquyen",
        component: () => import("../components/phanQuyen/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/voucher",
        component: () => import("../components/voucher/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/binhluan",
        component: () => import("../components/QLBL/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/chatbot",
        component: () => import("../components/chatbot/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/baocao",
        component: () => import("../components/BaoCao/index.vue"),
        meta: { layout: "default" }
    },
    {
        path: "/admin/quanlykho",
        component: () => import("../components/QuanLyKho/index.vue"),
        meta: { layout: "default" }
    },

    // =========================
    // CLIENT AUTH
    // =========================

    {
        path: "/dang-nhap",
        component: () => import("../components/dangnhap/index.vue"),
        meta: { layout: "blank" }
    },
    {
        path: "/dang-ky",
        component: () => import("../components/dangky/index.vue"),
        meta: { layout: "blank" }
    },

    // =========================
    // 404
    // =========================

    {
        path: "/:pathMatch(.*)*",
        redirect: "/trang-chu"
    }

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// =========================
// KIỂM TRA ĐĂNG NHẬP ADMIN
// =========================

router.beforeEach(async (to) => {
    const loginPath = "/admin/dang-nhap";
    const token = localStorage.getItem("admin_token");

    const isAdminPage = to.path.startsWith("/admin/");
    const isLoginPage = to.path === loginPath;

    if (!isAdminPage) {
        return true;
    }

    if (!token) {
        return isLoginPage
            ? true
            : {
                path: loginPath,
                query: { redirect: to.fullPath }
            };
    }

    try {
        const res = await axios.get(
            "http://127.0.0.1:8000/api/admin/check-token",
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        );

        if (res.data.status === true) {
            if (isLoginPage) {
                return "/admin/tongquan";
            }

            return true;
        }

        // Backend phản hồi nhưng token không hợp lệ
        localStorage.removeItem("admin_token");
        localStorage.removeItem("admin_name");
        localStorage.removeItem("admin_logged_in");

        return isLoginPage
            ? true
            : {
                path: loginPath,
                query: { redirect: to.fullPath }
            };

    } catch (error) {
        console.warn(
            "Lỗi kiểm tra token Admin:",
            error.response?.status || error.message
        );

        // BE tắt hoặc lỗi máy chủ:
        // Không tự xóa token chỉ vì không kết nối được.
        if (!error.response || error.response.status >= 500) {
            return true;
        }

        // Token bị từ chối
        if (
            error.response.status === 401 ||
            error.response.status === 403
        ) {
            localStorage.removeItem("admin_token");
            localStorage.removeItem("admin_name");
            localStorage.removeItem("admin_logged_in");

            return isLoginPage
                ? true
                : {
                    path: loginPath,
                    query: { redirect: to.fullPath }
                };
        }

        return true;
    }
});

export default router;
