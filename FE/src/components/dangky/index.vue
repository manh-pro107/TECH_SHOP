<template>

    <div class="login-container">
    
        <div class="login-box">
    
            <!-- TITLE -->
            <h1 class="title">
    
                Đăng Nhập
    
            </h1>
    
            <!-- EMAIL -->
            <div class="form-group">
    
                <div class="input-box">
    
                    <i class='bx bx-envelope'></i>
    
                    <input
                    v-model="email"
                    type="email"
                    placeholder="Email"
                >
    
                </div>
    
            </div>
    
            <!-- PASSWORD -->
            <div class="form-group">
    
                <div class="input-box">
    
                    <i class='bx bx-lock-alt'></i>
    
                    <input
    v-model="password"
    type="password"
    placeholder="Mật khẩu"
>
    
                </div>
    
            </div>
    
            <!-- OPTION -->
            <div class="option-box">
    
                <div class="register">
    
                    Đã chưa có tài khoản?
    
                    <b @click="$router.push('/dang-nhap')">Đăng ký</b>
    
                </div>
                
                <div class="forgot">
    
                    Quên mật khẩu?
    
                </div>
    
            </div>
    
            <!-- SOCIAL -->
            <div class="social-box">
    
                <div class="social facebook">
    
                    <i class='bx bxl-facebook'></i>
    
                </div>
    
                <div class="social phone">
    
                    <i class='bx bx-phone'></i>
    
                </div>
    
            </div>
    
            <!-- BUTTON -->
            <div class="btn-box">
    
                <button @click="dangNhap">
    
                    Đăng nhập
    
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
    
                password: ""
    
            }
    
        },
    
        methods: {
    
            dangNhap() {
    
                const toast = useToast()
    
                // CHECK RỖNG
                if (!this.email || !this.password) {
    
                    toast.error("Vui lòng nhập đầy đủ thông tin!")
    
                    return
    
                }
    
                // LẤY USER
                const user = JSON.parse(localStorage.getItem("user"))
    
                // CHƯA CÓ TÀI KHOẢN
                if (!user) {
    
                    toast.warning("Chưa có tài khoản!")
    
                    return
    
                }
    
                // CHECK ĐÚNG
                if (
    
                    this.email == user.email &&
    
                    this.password == user.password
    
                ) {
    
                    // LƯU LOGIN
                    localStorage.setItem("isLogin", "true")
    
                    // TOAST
                    toast.success("Đăng nhập thành công!")
    
                    // CHUYỂN TRANG MƯỢT
                    setTimeout(() => {
    
                        this.$router.push('/trang-chu')
    
                    }, 1200)
    
                }
    
                else {
    
                    toast.error("Sai tài khoản hoặc mật khẩu!")
    
                }
    
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
    }
    
    /* LOGIN BOX */
    
    .login-box{
    width: 650px;

    padding: 60px;

    border-radius: 35px;

    background:
    rgba(255,255,255,0.12);

    backdrop-filter: blur(15px);

    border:
    1px solid rgba(255,255,255,0.2);

    box-shadow:
    0 20px 40px rgba(0,0,0,0.35);
}
    /* TITLE */
    
    .title{
        text-align: center;
    
        font-size: 55px;
    
        color: white;
    
        margin-bottom: 45px;
    }
    
    /* FORM */
    
    .form-group{
        margin-bottom: 28px;
    }
    
    /* INPUT */
    
    .input-box{
        width: 100%;
        height: 65px;
    
        border-radius: 18px;
    
        background:
        rgba(255,255,255,0.12);
    
        border:
        2px solid rgba(255,255,255,0.15);
    
        display: flex;
        align-items: center;
    
        padding: 0 20px;
    
        transition: 0.3s;
    }
    
    .input-box:focus-within{
        border-color: #fdba74;
    
        box-shadow:
        0 0 18px rgba(253,186,116,0.5);
    }
    
    .input-box i{
        color: #fed7aa;
    
        font-size: 28px;
    
        margin-right: 15px;
    }
    
    .input-box input{
        width: 100%;
    
        border: none;
    
        background: transparent;
    
        outline: none;
    
        color: white;
    
        font-size: 20px;
    }
    
    .input-box input::placeholder{
        color: #ffedd5;
    }
    
    /* OPTION */
    
    .option-box{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-top: 5px;
    }
    
    .register{
        color: #fff7ed;
    
        font-size: 18px;
    }
    
    .register b{
        color: #fdba74;
    
        cursor: pointer;
    }
    
    .forgot{
        color: #fdba74;
    
        font-size: 18px;
    
        cursor: pointer;
    }
    
    /* SOCIAL */
    
    .social-box{
        display: flex;
    
        gap: 20px;
    
        margin-top: 35px;
    }
    
    .social{
        width: 60px;
        height: 60px;
    
        border-radius: 50%;
    
        display: flex;
        justify-content: center;
        align-items: center;
    
        color: white;
    
        font-size: 30px;
    
        cursor: pointer;
    
        transition: 0.3s;
    }
    
    .social:hover{
        transform: scale(1.1);
    }
    
    /* FACEBOOK */
    
    .facebook{
        background:
        linear-gradient(135deg,#60a5fa,#2563eb);
    
        box-shadow:
        0 0 20px rgba(96,165,250,0.5);
    }
    
    /* PHONE */
    
    .phone{
        background:
        linear-gradient(135deg,#fb923c,#ea580c);
    
        box-shadow:
        0 0 20px rgba(251,146,60,0.5);
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
    
        font-size: 26px;
    
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