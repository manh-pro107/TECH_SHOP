<template>

    <div class="top-client">

        <div class="container-fluid">

            <div class="row align-items-center">

                <!-- LOGO -->
                <div class="col-lg-2">

                <div class="logo" @click="$router.push('/')"
                    style="cursor:pointer">

                    <i class="fa-solid fa-laptop text-danger"></i>

                    TechShop

                </div>

                </div>

                <!-- SEARCH -->
<div class="col-lg-8">

<div class="search-box">

    <input
        type="text"
        class="form-control"
        placeholder="Bạn cần tìm gì?"
        v-model="keyword"
        @keyup.enter="timKiem"
    >

    <button
        class="btn-search"
        @click="timKiem"
    >

        <i class="fa-solid fa-magnifying-glass"></i>

    </button>

</div>

</div>

                <!-- ICON -->
                <div class="col-lg-2 text-end d-flex justify-content-end align-items-center">

                    <!-- BELL -->
                    <div class="icon-top-wrapper" @click="$router.push('/lich-su-mua')">
                        <i class="fa-regular fa-bell icon-top"></i>
                    </div>

                    <!-- CART -->
                    <div class="dropdown d-inline-block">

                        <i
                            class="fa-solid fa-cart-shopping icon-top position-relative"
                            data-bs-toggle="dropdown"
                        >

                            <span class="badge-cart">

                                {{ cart.length }}

                            </span>

                        </i>

                        <!-- DROPDOWN CART -->
                        <div class="dropdown-menu dropdown-menu-end cart-dropdown">

                            <!-- HEADER -->
                            <div class="cart-header">

                                🛒 Giỏ hàng

                            </div>

                            <!-- EMPTY -->
                            <div
                                v-if="cart.length == 0"
                                class="empty-cart"
                            >

                                <i class="fa-solid fa-cart-shopping"></i>

                                <p>Chưa có sản phẩm</p>

                            </div>

                            <!-- ITEM -->
                            <div
                                v-for="(item, index) in cart"
                                :key="index"
                                class="cart-item"
                            >

                                <img :src="item.hinh">

                                <div class="cart-info">

                                    <h6>

                                        {{ item.ten }}

                                    </h6>

                                    <span>

                                        {{ Number(item.gia).toLocaleString() }}đ

                                    </span>

                                    <!-- SL -->
                                    <div class="qty-box">

                                        <button @click="giamSL(index)">
                                            -
                                        </button>

                                        <b>
                                            {{ item.soluong }}
                                        </b>

                                        <button @click="tangSL(index)">
                                            +
                                        </button>

                                    </div>

                                </div>

                                <!-- REMOVE -->
                                <i
                                    class="fa-solid fa-trash remove-icon"
                                    @click="xoaSP(index)"
                                ></i>

                            </div>

                            <!-- FOOTER -->
                            <div
                                class="cart-footer"
                                v-if="cart.length > 0"
                            >

                                <div class="total-box">

                                    <span>Tổng tiền:</span>

                                    <b>

                                        {{ cart.length > 0
                                            ? '18.000.000đ'
                                            : '0đ'
                                        }}


                                    </b>

                                </div>

                                <button @click="muaHang">

                                    Mua hàng

                                </button>

                            </div>

                        </div>

                    </div>

                    <!-- USER -->
                    <div class="dropdown d-inline-block">

                        <i
                            class="fa-regular fa-user icon-top"
                            data-bs-toggle="dropdown"
                        ></i>

                        <ul class="dropdown-menu dropdown-menu-end user-dropdown">

                            <li>

                                <button
                                    class="dropdown-item text-danger"
                                    @click="dangXuat"
                                >

                                    <i class="fa-solid fa-right-from-bracket me-2"></i>

                                    Đăng xuất

                                </button>

                            </li>

                        </ul>

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

            cart: [],
            keyword: ""

        }

    },

    computed: {

        tongTien() {

            return this.cart.reduce((sum, item) => {

                return sum + item.gia * item.soluong

            }, 0)

        }

    },

    mounted() {

        this.loadCart()

        window.addEventListener(
            "storage",
            this.loadCart
        )

    },

    beforeUnmount() {

        window.removeEventListener(
            "storage",
            this.loadCart
        )

    },

    methods: {

        muaHang() {

            this.$router.push('/thanh-toantoan')

        },
        loadCart() {

            this.cart = JSON.parse(

                localStorage.getItem("cart")

            ) || []

        },

        saveCart() {

            localStorage.setItem(

                "cart",

                JSON.stringify(this.cart)

            )

            window.dispatchEvent(
                new Event("storage")
            )

        },

        tangSL(index) {

            this.cart[index].soluong++

            this.saveCart()

            this.$toast.success("Đã tăng số lượng")

        },

        giamSL(index) {

            if (this.cart[index].soluong > 1) {

                this.cart[index].soluong--

                this.saveCart()

            }

        },

        xoaSP(index) {

            this.cart.splice(index, 1)

            this.saveCart()

            this.$toast.error("Đã xóa sản phẩm")

        },

        dangXuat() {

            localStorage.removeItem("isLogin")

            this.$toast.success("Đăng xuất thành công!")

            setTimeout(() => {

                this.$router.push('/dang-nhap')

            }, 1000)

        },
        timKiem() {

        this.$router.push({
            path: '/tim-kiem',
            query: {
                q: this.keyword
            }
        })

        },

    }

}

</script>

<style scoped>

.top-client{
    background: white;
    padding: 12px 20px;
    border-bottom: 1px solid #ddd;

    position: sticky;
    top: 0;
    z-index: 999;
}

/* LOGO */

.logo{
    font-size: 32px;
    font-weight: bold;

    cursor: pointer;
}

/* SEARCH */

.search-box{
    position: relative;
}

.search-box input{
    height: 45px;
    border-radius: 12px;
    padding-left: 18px;

    border: 1px solid #ddd;
}

.search-box input:focus{
    box-shadow: none;
    border-color: #ef4444;
}

.btn-search{
    position: absolute;
    top: 0;
    right: 0;

    width: 55px;
    height: 45px;

    border: none;

    background: transparent;

    border-left: 1px solid #ddd;

    border-radius: 0 12px 12px 0;
}

/* ICON */

.icon-top{
    font-size: 24px;
    margin-left: 20px;

    cursor: pointer;

    transition: 0.3s;
}

.icon-top:hover{
    color: #ef4444;
    transform: translateY(-2px);
}

/* BADGE */

.badge-cart{
    position: absolute;
    top: -8px;
    right: -10px;

    background: #ef4444;
    color: white;

    border-radius: 50%;

    font-size: 10px;

    padding: 3px 6px;
}

.icon-top-wrapper{
    cursor: pointer;
    display: inline-block;
}
/* USER */

.user-dropdown{
    border: none;
    border-radius: 14px;

    overflow: hidden;

    padding: 10px;

    min-width: 220px;

    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.user-dropdown .dropdown-item{
    padding: 12px 16px;

    border-radius: 10px;

    transition: 0.3s;

    font-weight: 500;
}

.user-dropdown .dropdown-item:hover{
    background: #f5f5f5;
}

/* CART */

.cart-dropdown{
    width: 400px;
    padding: 0;

    border: none;
    border-radius: 16px;

    overflow: hidden;

    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.cart-header{
    background: #ef4444;
    color: white;

    padding: 18px;

    font-size: 20px;
    font-weight: bold;
}

/* EMPTY */

.empty-cart{
    padding: 40px;
    text-align: center;
    color: #999;
}

.empty-cart i{
    font-size: 55px;
    margin-bottom: 15px;
}

/* ITEM */

.cart-item{
    display: flex;
    gap: 14px;

    padding: 16px;

    border-bottom: 1px solid #eee;

    position: relative;
}

.cart-item img{
    width: 80px;
    height: 80px;

    object-fit: contain;

    border-radius: 12px;

    background: #f5f5f5;
}

.cart-info{
    flex: 1;
}

.cart-info h6{
    font-size: 16px;
    margin-bottom: 8px;
}

.cart-info span{
    color: #ef4444;
    font-weight: bold;
}

/* QTY */

.qty-box{
    display: flex;
    align-items: center;

    gap: 10px;

    margin-top: 10px;
}

.qty-box button{
    width: 28px;
    height: 28px;

    border: none;

    border-radius: 6px;

    background: #f3f4f6;

    font-weight: bold;
}

/* REMOVE */

.remove-icon{
    color: #ef4444;

    cursor: pointer;

    transition: 0.3s;
}

.remove-icon:hover{
    transform: scale(1.2);
}

/* FOOTER */

.cart-footer{
    padding: 16px;
}

.total-box{
    display: flex;
    justify-content: space-between;

    margin-bottom: 15px;

    font-size: 18px;
}

.total-box b{
    color: #22c55e;
}

.cart-footer button{
    width: 100%;
    border: none;

    background: linear-gradient(
        90deg,
        #22c55e,
        #34d399
    );

    color: white;

    height: 50px;

    border-radius: 12px;

    font-size: 18px;
    font-weight: bold;
}

/* MOBILE */

@media(max-width: 991px){

    .logo{
        text-align: center;
        margin-bottom: 15px;
    }

    .search-box{
        margin-bottom: 15px;
    }

    .text-end{
        text-align: center !important;
    }

    .cart-dropdown{
        width: 340px;
    }

}

</style>