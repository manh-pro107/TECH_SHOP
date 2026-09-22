<template>

    <div class="login-container">
    
        <div class="login-box">
    
            <!-- LOGO -->
            <div class="logo-box">
    
                <div class="logo-icon">
    
                    <i class='bx bx-laptop'></i>
    
                </div>
    
                <h1>
    
                    <span class="text-dark">TECH</span>
    
                    <span class="text-light">SHOP</span>
    
                </h1>
    
            </div>
    
            <!-- SUB -->
            <p class="sub-text">
    
               Đăng ký vào hệ thống z
    
            </p>
    
            <!-- EMAIL -->
            <div class="form-group">
    
                <label>Email</label>
    
                <input
                    v-model="email"
                    type="email"
                    placeholder="Nhập email..."
                >
    
            </div>
    
            <!-- PASSWORD -->
            <div class="form-group">
    
                <label>Mật khẩu</label>
    
                <input
    v-model="password"
    type="password"
    placeholder="Nhập mật khẩu..."
>
    
            </div>
    
            <!-- RE PASSWORD -->
            <div class="form-group">
    
                <label>Nhập lại mật khẩu</label>
    
                <input
    v-model="rePassword"
    type="password"
    placeholder="Nhập lại mật khẩu..."
>
    
            </div>
    
            <!-- BOTTOM -->
            <div class="bottom-box">
    
                <div class="login-text">
    
                    Đã có tài khoản?
    
                    <b @click="$router.push('/dang-ky')">Đăng nhập</b>
    
                </div>
    
                <!-- SOCIAL -->
                <div class="social-box">
    
                    <div class="icon phone">
    
                        <i class='bx bx-phone'></i>
    
                    </div>
    
                    <div class="icon facebook">
    
                        <i class='bx bxl-facebook'></i>
    
                    </div>
    
                </div>
    
            </div>
    
            <!-- BUTTON -->
            <div class="btn-box">
    
                <button @click="dangKy">
    
                    Đăng Ký
    
                </button>
    
            </div>
    
        </div>
    
    </div>
    
    </template>
    
    <script>

import { useToast } from "vue-toastification";

export default {

    data() {

        return {

            email: "",

            password: "",

            rePassword: "",

        }

    },

    methods: {

        dangKy() {

            const toast = useToast()

            // CHECK RỖNG
            if (!this.email || !this.password || !this.rePassword) {

                toast.error("Vui lòng nhập đầy đủ thông tin!")

                return

            }

            // CHECK EMAIL
            if (!this.email.includes("@")) {

                toast.warning("Email không hợp lệ!")

                return

            }

            // CHECK MẬT KHẨU
            if (this.password.length < 6) {

                toast.warning("Mật khẩu tối thiểu 6 ký tự!")

                return

            }

            // CHECK RE PASSWORD
            if (this.password != this.rePassword) {

                toast.error("Mật khẩu nhập lại không khớp!")

                return

            }

            // TẠO USER
            const user = {

                email: this.email,

                password: this.password

            }

            // LƯU
            localStorage.setItem(

                "user",

                JSON.stringify(user)

            )

            // TOAST
            toast.success("Đăng ký thành công!")

            // CHUYỂN TRANG MƯỢT
            setTimeout(() => {

                this.$router.push('/dang-ky')

            }, 1200)

        }

    }

}

</script>
    
    <style scoped>
    
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial;
    }
    
    /* BACKGROUND */
    
    .login-container{
        width: 100%;
        height: 100vh;
    
        display: flex;
        justify-content: center;
        align-items: center;
    
        background:
        linear-gradient(
            135deg,
            #3b1d0f,
            #7c2d12,
            #b45309,
            #f59e0b
        );
    
        overflow: hidden;
    }
    
    /* BOX */
    
    .login-box{
        width: 650px;
    
        padding: 50px;
    
        border-radius: 35px;
    
        background:
        rgba(255,255,255,0.12);
    
        backdrop-filter: blur(15px);
    
        border:
        1px solid rgba(255,255,255,0.2);
    
        box-shadow:
        0 20px 40px rgba(0,0,0,0.35);
    }
    
    /* LOGO */
    
    .logo-box{
        text-align: center;
    
        margin-bottom: 10px;
    }
    
    .logo-icon{
        width: 90px;
        height: 90px;
    
        margin: auto;
    
        border-radius: 50%;
    
        background:
        linear-gradient(135deg,#fb923c,#ea580c);
    
        display: flex;
        justify-content: center;
        align-items: center;
    
        color: white;
    
        font-size: 38px;
    
        margin-bottom: 20px;
    
        box-shadow:
        0 0 25px rgba(251,146,60,0.6);
    }
    
    /* TITLE */
    
    .logo-box h1{
        font-size: 55px;
    
        font-weight: bold;
    
        letter-spacing: 2px;
    }
    
    .text-dark{
        color: #fff7ed;
    }
    
    .text-light{
        color: #fdba74;
    
        text-shadow:
        0 0 15px rgba(253,186,116,0.8);
    }
    
    /* SUB */
    
    .sub-text{
        text-align: center;
    
        color: #ffedd5;
    
        font-size: 18px;
    
        margin-bottom: 40px;
    }
    
    /* FORM */
    
    .form-group{
        margin-bottom: 28px;
    }
    
    label{
        display: block;
    
        margin-bottom: 10px;
    
        color: #fff7ed;
    
        font-size: 21px;
    
        font-weight: bold;
    }
    
    input{
        width: 100%;
        height: 65px;
    
        border-radius: 18px;
    
        border:
        2px solid rgba(255,255,255,0.15);
    
        background:
        rgba(255,255,255,0.10);
    
        padding-left: 20px;
    
        font-size: 18px;
    
        color: white;
    
        outline: none;
    
        transition: 0.3s;
    }
    
    input:focus{
        border-color: #fdba74;
    
        box-shadow:
        0 0 18px rgba(253,186,116,0.5);
    }
    
    input::placeholder{
        color: #fed7aa;
    }
    
    /* BOTTOM */
    
    .bottom-box{
        display: flex;
        justify-content: space-between;
        align-items: center;
    
        margin-top: 10px;
    }
    
    /* LOGIN */
    
    .login-text{
        color: #fff7ed;
    
        font-size: 20px;
    }
    
    .login-text b{
        color: #fdba74;
    
        cursor: pointer;
    }
    
    /* SOCIAL */
    
    .social-box{
        display: flex;
        gap: 18px;
    }
    
    .icon{
        width: 60px;
        height: 60px;
    
        border-radius: 50%;
    
        display: flex;
        justify-content: center;
        align-items: center;
    
        color: white;
    
        font-size: 24px;
    
        cursor: pointer;
    
        transition: 0.3s;
    }
    
    .icon:hover{
        transform: scale(1.1);
    }
    
    /* PHONE */
    
    .phone{
        background:
        linear-gradient(135deg,#f59e0b,#ea580c);
    
        box-shadow:
        0 0 20px rgba(245,158,11,0.5);
    }
    
    /* FACEBOOK */
    
    .facebook{
        background:
        linear-gradient(135deg,#60a5fa,#2563eb);
    
        box-shadow:
        0 0 20px rgba(96,165,250,0.5);
    }
    
    /* BUTTON */
    
    .btn-box{
        text-align: center;
    
        margin-top: 45px;
    }
    
    button{
        width: 240px;
        height: 65px;
    
        border: none;
    
        border-radius: 20px;
    
        background:
        linear-gradient(135deg,#fb923c,#ea580c);
    
        color: white;
    
        font-size: 24px;
    
        font-weight: bold;
    
        cursor: pointer;
    
        transition: 0.3s;
    
        box-shadow:
        0 12px 25px rgba(251,146,60,0.4);
    }
    
    button:hover{
        transform: translateY(-5px);
    
        box-shadow:
        0 15px 30px rgba(251,146,60,0.7);
    }
    
    </style>