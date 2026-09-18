<template>
    <div class="history-page">

        <!-- TITLE -->
        <div class="container text-center mt-3">
            <h5 class="fw-bold text-primary mb-1">
                <i class="fa-solid fa-clock-rotate-left me-1"></i>
                Lịch sử mua hàng
            </h5>
            <small class="text-muted">Danh sách các đơn hàng bạn đã đặt</small>
        </div>

        <!-- LIST -->
        <main class="container my-3">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div
                        class="order-card"
                        v-for="(order, index) in orders"
                        :key="index"
                    >

                        <!-- STATUS -->
                        <div class="status-tag">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ order.status }}
                        </div>

                        <!-- PRODUCT -->
                        <div class="product-box">

                            <img :src="order.image" class="product-img shadow-sm">

                            <div>
                                <h5 class="fw-bold mb-1">
                                    {{ order.name }}
                                </h5>

                                <p class="text-secondary small mb-0">
                                    {{ order.variant }}
                                </p>

                                <span class="text-muted small">
                                    Số lượng: {{ order.quantity }}
                                </span>
                            </div>

                            <div class="text-end">
                                <span class="text-muted small d-block">
                                    Tổng số tiền
                                </span>

                                <span class="total-price text-danger">
                                    {{ formatPrice(order.total) }}
                                </span>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-action">
                                {{ order.btn1 }}
                            </button>

                            <button
                            class="btn btn-action"
                            @click="goReview(order)"
                        >
                            Đánh giá
                        </button>
                        </div>

                    </div>

                </div>
            </div>
        </main>

    </div>
</template>

<script>
export default {
    data() {
        return {
            orders: [
                {
                    status: "Giao hàng thành công",
                    name: "Laptop Gaming ASUS ROG Strix G15",
                    variant: "Ryzen 7 | 8GB | 512GB",
                    quantity: 1,
                    total: 24500000,
                    image: "https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200",
                    btn1: "Mua lại"
                },
                {
                    status: "Đang giao hàng",
                    name: "Màn hình LG UltraGear 27 inch",
                    variant: "IPS | 144Hz | 1ms",
                    quantity: 1,
                    total: 8900000,
                    image: "https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=200",
                    btn1: "Đã nhận hàng"
                }
            ]
        }
    },

    methods: {
        formatPrice(value) {
        return Number(value).toLocaleString() + "đ"
    },

    goReview(order) {
        // lưu tạm sản phẩm để qua trang đánh giá dùng
        localStorage.setItem("reviewProduct", JSON.stringify(order))

        this.$router.push("/danh-gia")
    }
    }
}
</script>

<style scoped>
body {
    background-color: #f8f9fa;
}

/* ORDER CARD */
.order-card {
    background-color: #e3f7fb;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    transition: 0.2s;
}

.order-card:hover {
    transform: translateY(-3px);
}

/* PRODUCT LAYOUT */
.product-box {
    display: grid;
    grid-template-columns: 100px 1fr auto;
    gap: 20px;
    align-items: center;
}

.product-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 12px;
    background: white;
}

/* STATUS */
.status-tag {
    color: #28a745;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
}

/* BUTTON */
.btn-action {
    background-color: #ffda6a;
    color: #000;
    font-weight: 600;
    padding: 8px 24px;
    border-radius: 50px;
    border: none;
    margin-left: 10px;
}

.btn-action:hover {
    background-color: #f7c943;
}

/* PRICE */
.total-price {
    font-size: 1.2rem;
    font-weight: 700;
}
</style>