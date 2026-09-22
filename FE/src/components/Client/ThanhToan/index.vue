<template>

    <div class="checkout-page">

        <!-- TOAST -->
        <div
            class="custom-toast"
            v-if="showToast"
        >
            <i class="fa-solid fa-circle-check me-2"></i>
            Thanh toán thành công 🎉
        </div>

        <div class="container checkout-container">

            <!-- TITLE -->
            <h1 class="checkout-title">

                Thanh toán

            </h1>

            <div class="row g-4">

                <!-- LEFT -->
                <div class="col-lg-8">

                    <!-- INFO -->
                    <div
                        class="checkout-box card radius-10 border-top border-0 border-3 border-primary"
                    >

                        <h3 class="section-title">

                            Thông tin khách hàng

                        </h3>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Họ và tên *

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="hoTen"
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Số điện thoại *

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="sdt"
                                >

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label">

                                    Email

                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="email"
                                >

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label">

                                    Địa chỉ giao hàng *

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="diaChi"
                                >

                            </div>

                        </div>

                    </div>

                    <!-- PAYMENT -->
                    <div
                        class="checkout-box mt-4 card radius-10 border-top border-0 border-3 border-primary"
                    >

                        <h3 class="section-title">

                            Phương thức thanh toán

                        </h3>

                        <!-- BANK -->
                        <div
                            class="payment-method d-flex align-items-center mb-3"
                            :class="{ active : payment == 'bank' }"
                            @click="payment = 'bank'"
                        >

                            <input
                                class="form-check-input me-3"
                                type="radio"
                                :checked="payment == 'bank'"
                            >

                            <div class="payment-icon me-3">

                                <i class="fa-solid fa-building-columns"></i>

                            </div>

                            <div>

                                <div class="fw-bold">

                                    Chuyển khoản ngân hàng

                                </div>

                                <small class="text-muted">

                                    VNPAY, Visa, Mastercard, QR Pay

                                </small>

                            </div>

                        </div>

                        <!-- COD -->
                        <div
                            class="payment-method d-flex align-items-center"
                            :class="{ active : payment == 'cod' }"
                            @click="payment = 'cod'"
                        >

                            <input
                                class="form-check-input me-3"
                                type="radio"
                                :checked="payment == 'cod'"
                            >

                            <div class="payment-icon me-3">

                                <i class="fa-solid fa-truck"></i>

                            </div>

                            <div>

                                <div class="fw-bold">

                                    Thanh toán khi nhận hàng (COD)

                                </div>

                                <small class="text-muted">

                                    Thanh toán bằng tiền mặt khi nhận hàng

                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-4">

                    <!-- VOUCHER -->
                    <div class="voucher-wrapper mb-3">

                        <div class="input-group">

                            <input
                                type="text"
                                class="form-control voucher-input"
                                placeholder="Voucher"
                            >

                            <button class="btn voucher-btn">

                                <i class="fa-solid fa-ticket me-1"></i>

                                Xác nhận

                            </button>

                        </div>

                    </div>

                    <!-- ORDER -->
                    <div
                        class="order-box card radius-10 border-top border-0 border-3 border-primary"
                    >

                        <h3 class="section-title">

                            Đơn hàng

                        </h3>

                        <!-- PRODUCT -->
                        <div
                            class="d-flex align-items-center mb-3"
                            v-for="(item,index) in cart"
                            :key="index"
                        >

                            <img
                                :src="item.img"
                                class="product-img me-3"
                            >

                            <div class="flex-grow-1">

                                <div class="fw-bold">

                                    {{ item.name }}

                                </div>

                                <small class="text-muted">

                                    SL: {{ item.qty }}

                                </small>

                            </div>

                            <div class="price">

                                {{ formatMoney(item.price) }}

                            </div>

                        </div>

                        <hr>

                        <div class="summary-row">

                            <span>Tạm tính</span>

                            <strong>

                                {{ formatMoney(total) }}

                            </strong>

                        </div>

                        <div class="summary-row">

                            <span>Phí vận chuyển</span>

                            <span class="text-success">

                                Miễn phí

                            </span>

                        </div>

                        <div class="summary-row">

                            <span>Voucher</span>

                            <span class="text-danger">

                                -3%

                            </span>

                        </div>

                        <hr>

                        <div class="summary-row align-items-center">

                            <strong>Tổng cộng</strong>

                            <div class="total">

                                {{ formatMoney(totalAfter) }}

                            </div>

                        </div>

                        <button
                            class="btn-pay"
                            @click="thanhToan"
                        >

                            Thanh toán ngay

                        </button>

                        <div class="note">

                            Bằng việc thanh toán,
                            bạn đồng ý điều khoản sử dụng
                            của chúng tôi.

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

export default {

    data() {

        return {

            showToast: false,

            hoTen: "Nguyễn Văn A",

            sdt: "0123456789",

            email: "admin@gmail.com",

            diaChi: "123 ABC",

            payment: "bank",

            cart: [

                {
                    name: "ROG Flow Z13-KJP",
                    qty: 1,
                    price: 109900000,
                    img: "/img_trangchu/asus.webp"
                },

                {
                    name: "Màn hình ASUS TUF",
                    qty: 1,
                    price: 5990000,
                    img: "/img_chitiet/man.jpg"
                }

            ]

        }

    },

    computed: {

        total() {

            return this.cart.reduce(

                (sum, item) => {

                    return sum + (item.price * item.qty)

                },

                0

            )

        },

        totalAfter() {

            return this.total - (this.total * 0.03)

        }

    },

    methods: {

        formatMoney(n) {

            return Number(n).toLocaleString() + " đ"

        },

        thanhToan() {

            this.showToast = true

            setTimeout(() => {

                this.showToast = false

            }, 3000)

        }

    }

}

</script>

<style scoped>

.checkout-page{
    background:#f5f5f5;
    min-height:100vh;
    padding:40px 0;
}

.checkout-container{
    max-width:1200px;
}

.checkout-title{
    font-size:38px;
    font-weight:bold;
    margin-bottom:30px;
}

.checkout-box{
    background:white;
    border-radius:14px;
    padding:25px;

    box-shadow:
    0 2px 10px rgba(0,0,0,0.08);
}

.section-title{
    font-size:24px;
    font-weight:bold;
    margin-bottom:20px;
}

.form-label{
    font-weight:600;
}

.form-control{
    height:52px;
    border-radius:10px;
}

/* PAYMENT */

.payment-method{
    border:2px solid #e5e5e5;
    border-radius:12px;
    padding:18px;

    cursor:pointer;

    transition:0.3s;
}

.payment-method:hover{
    border-color:#0d6efd;
    background:#f8fbff;
}

.payment-method.active{
    border-color:#0d6efd;
    background:#eef5ff;
}

.form-check-input{
    width:20px;
    height:20px;
}

.payment-icon{
    width:45px;
    height:45px;

    background:#0d6efd;
    color:white;

    border-radius:10px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;
}

/* VOUCHER */

.voucher-wrapper{
    width:100%;
}

.voucher-input{
    height:50px;

    border-radius:12px 0 0 12px;

    border:1px solid #ccc;

    box-shadow:none;
}

.voucher-btn{
    background:#084fc7;
    color:white;

    border:none;

    border-radius:0 12px 12px 0;

    padding:0 20px;

    font-weight:bold;
}

.voucher-btn:hover{
    background:#1d3f91;
    color:white;
}

/* ORDER */

.order-box{
    background:white;
    border-radius:14px;
    padding:25px;

    box-shadow:
    0 2px 10px rgba(0,0,0,0.08);
}

.product-img{
    width:70px;
    height:70px;

    object-fit:cover;

    border-radius:10px;
}

.price{
    font-weight:bold;
    color:#dc3545;
}

.summary-row{
    display:flex;
    justify-content:space-between;

    margin-top:15px;
}

.total{
    font-size:28px;
    font-weight:bold;
    color:#0d6efd;
}

.btn-pay{
    width:100%;
    height:55px;

    border:none;
    border-radius:12px;

    background:#0d6efd;
    color:white;

    font-size:18px;
    font-weight:bold;

    margin-top:20px;

    transition:0.3s;
}

.btn-pay:hover{
    background:#084fc7;
    transform:translateY(-2px);
}

.note{
    text-align:center;

    font-size:13px;

    color:#777;

    margin-top:15px;
}

/* TOAST */

.custom-toast{
    position:fixed;
    top:25px;
    right:25px;

    background:#198754;
    color:white;

    padding:14px 22px;

    border-radius:12px;

    font-weight:bold;

    z-index:9999;

    box-shadow:
    0 5px 20px rgba(0,0,0,0.15);

    animation:showToast .3s ease;
}

@keyframes showToast{

    from{
        opacity:0;
        transform:translateY(-20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

/* MOBILE */

@media(max-width:768px){

    .checkout-title{
        font-size:30px;
    }

    .total{
        font-size:22px;
    }

}

</style>