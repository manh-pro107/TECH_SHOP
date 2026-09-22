<template>

    <div class="footer-client">

        <div class="container">

            <div class="row align-items-center gy-4">

                <!-- CỘT 1 -->
                <div class="col-lg-4 text-center">

                    <h4 class="footer-title">
                        VỀ TECHSHOP
                    </h4>

                    <p>
                        <i class="fa-solid fa-location-dot text-danger"></i>
                        123 An Mạnh Hùng Trung 2, Đà Nẵng
                    </p>

                    <p>
                        <i class="fa-solid fa-phone text-danger"></i>
                        0123.456.789
                    </p>

                    <p>
                        Chuyên laptop, PC Gaming và phụ kiện chính hãng
                    </p>

                </div>

                <!-- CỘT 2 -->
                <div class="col-lg-4 text-center">

                    <h2 class="logo-text">

                        <i class="fa-solid fa-laptop logo-icon"></i>

                        TechShop

                    </h2>

                    <p class="mb-1">
                        Copyright © 2026
                    </p>

                    <p class="slogan">
                        Bán linh kiện nhà vua
                    </p>

                    <div class="social">

                        <i class="fa-brands fa-facebook"></i>

                        <i class="fa-brands fa-youtube"></i>

                        <i class="fa-brands fa-tiktok"></i>

                    </div>

                </div>

                <!-- CỘT 3 -->
                <div class="col-lg-4 text-center">

                    <h4 class="footer-title">
                        ĐƠN VỊ VẬN CHUYỂN
                    </h4>

                    <div class="ship-box">

                        <i class="fa-solid fa-truck-fast"></i>

                        <i class="fa-solid fa-plane"></i>

                        <i class="fa-solid fa-box"></i>

                    </div>

                    <h4 class="footer-title mt-4">
                        CÁCH THỨC THANH TOÁN
                    </h4>

                    <div class="ship-box">

                        <i class="fa-brands fa-cc-visa"></i>

                        <i class="fa-brands fa-cc-mastercard"></i>

                        <i class="fa-solid fa-qrcode"></i>

                    </div>

                </div>

            </div>

            <!-- LINE -->
            <hr class="footer-line">

            <!-- COPYRIGHT -->
            <div class="text-center footer-bottom">

                © 2026 TechShop - All Rights Reserved

            </div>

        </div>

    </div>

</template>

<script>
export default {

}
</script>

<style scoped>

.footer-client{
    background: #f5f5f5;
    padding: 45px 0 25px;
    margin-top: 60px;
    border-top: 1px solid #e5e5e5;
}

/* TITLE */
.footer-title{
    font-size: 26px;
    font-weight: 700;
    color: #222;
    margin-bottom: 20px;
}

/* TEXT */
.footer-client p{
    color: #666;
    font-size: 16px;
    margin-bottom: 10px;
}

/* LOGO */
.logo-text{
    color: #ef4444;
    font-size: 50px;
    font-weight: 700;
    margin-bottom: 10px;
}

.logo-icon{
    font-size: 45px;
}

/* SLOGAN */
.slogan{
    font-size: 15px;
    color: #888;
}

/* SOCIAL */
.social{
    margin-top: 15px;
}

.social i{
    font-size: 28px;
    margin: 0 8px;
    cursor: pointer;
    transition: 0.3s;
}

.social i:hover{
    transform: translateY(-4px);
    color: #ef4444;
}

/* BOX ICON */
.ship-box{
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.ship-box i{
    width: 58px;
    height: 58px;
    background: white;
    border: 1px solid #e5e5e5;
    border-radius: 14px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 28px;
    color: #555;

    transition: 0.3s;
}

.ship-box i:hover{
    transform: translateY(-5px);
    color: #ef4444;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* LINE */
.footer-line{
    margin-top: 40px;
    border-color: #ddd;
}

/* BOTTOM */
.footer-bottom{
    color: #777;
    font-size: 15px;
}

/* RESPONSIVE */
@media(max-width: 768px){

    .footer-client{
        text-align: center;
    }

    .logo-text{
        font-size: 40px;
    }

    .footer-title{
        margin-top: 20px;
    }

}

</style>