import { createRouter, createWebHistory } from "vue-router";

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
    




    // =========================
    // ADMIN
    // =========================

    {
        path: "/admin/sanpham",
        component: () => import("../components/Admin/index.vue"),
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



    // =========================
    // AUTH
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

export default router;