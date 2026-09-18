<template>
    <div class="home-page">

        <!-- BANNER TOP -->
        <div class="container mt-3">
            <div class="row g-3">
                <!-- LEFT -->
                <div class="col-lg-12">
                    <img
                        class="main-banner"
                        src="/public/img_trangchu/banner.jpg"
                        alt=""
                    >
                </div>
                <!-- RIGHT -->
                <div class="col-lg-3">
                    <div class="right-banner-box">
                        <img
                            src="/public/img_trangchu/trangchu_dai2.png"
                            alt=""
                        >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="right-banner-box">
                        <img
                            src="/public/img_trangchu/trangchu_dai1.png"
                            alt=""
                        >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="right-banner-box">
                        <img
                            src="/public/img_trangchu/trangchu_dai2.png"
                            alt=""
                        >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="right-banner-box">
                        <img
                            src="/public/img_trangchu/trangchu_dai1.png"
                            alt=""
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- CATEGORY + ADS -->
        <div class="container mt-4">
            <div class="row g-3">
                <!-- CATEGORY -->
                <div class="col-lg-3">
                    <div class="category-box">
                        <div class="category-title">
                            <i class="fa-solid fa-bars"></i>
                            DANH MỤC
                        </div>
                        <ul>
                            <li>Laptop</li>
                            <li>Laptop Gaming</li>
                            <li>PC Gaming</li>
                            <li>Màn Hình</li>
                            <li>Bàn Phím</li>
                            <li>Chuột Gaming</li>
                            <li>Tai Nghe</li>
                        </ul>
                    </div>
                    <!-- banner thêm -->
                    
                </div>

                <!-- ADS -->
                <div class="col-lg-9">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <img
                                class="small-banner" style="width: 850px;"
                                src="/public/img_trangchu/vuong.jpg"
                                alt=""
                            >
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-4">
                            <div class="right-banner-box">
                                <img
                                    src="/public/img_trangchu/tren2.png"
                                    alt=""
                                >
                            
                            </div>
                </div>

                <div class="col-lg-4">
                            <div class="right-banner-box">
                                <img
                                    src="/public/img_trangchu/tren1.png"
                                    alt=""
                                >
                    
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="right-banner-box">
                                <img
                                    src="/public/img_trangchu/tren2.png"
                                    alt=""
                                >
                            </div>
                        </div>
            </div>
        </div>

        <!-- 2 BANNER -->
        <!-- <div class="container mt-4">
            <div class="row g-3">
                <div class="col-lg-6">
                    <img
                        class="small-banner"
                        src="/public/img_trangchu/tren2.png"
                        alt=""
                    >
                </div>
                <div class="col-lg-6">
                    <img
                        class="small-banner"
                        src="/public/img_trangchu/tren2.png"
                        alt=""
                    >
                </div>
            </div>
        </div> -->

        <!-- PRODUCT -->
        <div class="container mt-4">
            <div class="product-section">
                <!-- TITLE -->
                <div class="section-title">
                    <h3>SẢN PHẨM NỔI BẬT</h3>
                    <span>Xem tất cả</span>
                </div>

                <!-- PRODUCT LIST -->
                <div class="row g-4 p-3">
                    <div
                        class="col-lg-2-4"
                        v-for="(item, index) in products"
                        :key="index"
                    >
                        <div class="product-card" @click="clickProduct">
                            <img :src="item.hinh" alt="">
                            <h5>{{ item.ten }}</h5>
                            <div class="spec-box">
                                <span>Tồn: {{ item.ton }}</span>
                                <span>⭐ {{ item.danhgia }}</span>
                            </div>
                            <div class="old-price">Giá sản phẩm</div>
                            <div class="new-price">
                                {{ Number(item.gia).toLocaleString() }}đ
                            </div>
                            <button @click.stop="themGioHang(item)">
                                THÊM VÀO GIỎ
                            </button>
                            <div class="rating">
                                <span>{{ item.chitiet }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- bannerbanner -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4">
                            <div class="right-banner-box">
                                <img
                                    src="/public/img_trangchu/tren2.png"
                                    alt=""
                                >
                                
                            </div>
                        </div>

                
                        <div class="col-lg-4">
                            <div class="right-banner-box">
                                <img
                                    src="/public/img_trangchu/tren2.png"
                                    alt=""
                                >
                                
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="right-banner-box">
                                <img
                                    src="/public/img_trangchu/tren2.png"
                                    alt=""
                                >
                            </div>
                        </div>
            </div>
        </div>


        <div class="container mt-4">

<div class="product-section">

    <!-- TITLE -->
    <div class="section-title">

        <h3>PC GAMING</h3>

        <span>Xem tất cả</span>

    </div>

    <!-- PRODUCT 22-->
    <div class="row g-4 p-3">

        <div
            class="col-lg-3"
            v-for="(item, index) in pcProducts"
            :key="index"
        >

            <div class="product-card">

                <img :src="item.hinh">

                <h5>
                    {{ item.ten }}
                </h5>

                <div class="spec-box">

                    <span>
                        Tồn: {{ item.ton }}
                    </span>

                    <span>
                        ⭐ {{ item.danhgia }}
                    </span>

                </div>

                <div class="old-price">
                    Giá sản phẩm
                </div>

                <div class="new-price">
                    {{ Number(item.gia).toLocaleString() }}đ
                </div>

                <button @click="themGioHang(item)">
                    THÊM VÀO GIỎ
                </button>

                <div class="rating">

                    <span>
                        {{ item.chitiet }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

</div>
        <!-- MODAL YÊU CẦU ĐĂNG NHẬP -->
        <div class="modal fade" id="loginModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Thông báo</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <i class="fa-solid fa-user-lock text-danger" style="font-size:70px;"></i>
                        <h4 class="mt-3">Bạn cần đăng nhập!</h4>
                        <p class="text-secondary">Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-danger" @click="goLogin">Đi đến đăng nhập</button>
                    </div>
                </div>
            </div>
        </div>

         <!-- CHAT BUTTON -->
        <!-- CHAT -->
        
<!-- FLOAT BUTTON -->
<div class="chat-float" @click="toggleChat">
    <i class="fa-solid fa-headset"></i>
</div>

<!-- CHATBOX -->
<div class="chat-wrapper" v-if="showChat">

    <!-- TOP -->
    <div class="chat-top">

        <div class="chat-profile">
            <div class="avatar">
                <i class="fa-solid fa-robot"></i>
            </div>

            <div>
                <h4>TechShop AI</h4>
                <p>Hỗ trợ khách hàng 24/7</p>
            </div>
        </div>

        <button class="close-btn" @click="toggleChat">
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>

    <!-- BODY -->
    <div class="chat-content">

        <div
            v-for="(msg,index) in messages"
            :key="index"
            :class="msg.type == 'user' ? 'user-chat' : 'bot-chat'"
        >

            <!-- avatar bot -->
            <div
                v-if="msg.type == 'bot'"
                class="chat-avatar-small"
            >
                <i class="fa-solid fa-robot"></i>
            </div>

            <!-- bubble -->
            <div
                class="chat-bubble"
                :class="msg.type"
                    v-html="msg.text"
            >

            </div>

        </div>

    </div>

    <!-- INPUT -->
    <div class="chat-bottom">

        <button class="icon-btn">
            <i class="fa-regular fa-face-smile"></i>
        </button>

        <input
            type="text"
            v-model="inputMessage"
            @keyup.enter="sendMessage"
            placeholder="Nhập tin nhắn..."
        >

        <button class="send-btn" @click="sendMessage">
            <i class="fa-solid fa-paper-plane"></i>
        </button>

    </div>

</div>



        </div>
    </template>

    <script>
    import * as bootstrap from 'bootstrap'
    import AdminSP from "../../Admin/index.vue"
    import { useToast } from "vue-toastification";

    export default {
        data() {
            return {
                pcProducts: [

            {
                ten: "PC Gaming RTX 4060",
                gia: 24990000,
                ton: 12,
                danhgia: 4.9,
                chitiet: "Intel i5 13400F | RTX 4060",
                hinh: "https://th.bing.com/th/id/OIP.a9gYj8FJb-Cemchkya1UkQHaFj?w=246&h=185&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3",
                soluong: 1
            },

            {
                ten: "PC Gaming RTX 4070",
                gia: 32990000,
                ton: 5,
                danhgia: 5.0,
                chitiet: "Ryzen 7 | RTX 4070",
                hinh: "https://phuongthanhcomputer.com/wp-content/uploads/2025/02/pc-rtx-4070-i7-12700k-1-1.jpg",
                soluong: 1
            },

            {
                ten: "PC Streaming",
                gia: 28990000,
                ton: 8,
                danhgia: 4.8,
                chitiet: "RTX 4060Ti | 32GB RAM",
                hinh: "https://storage-asset.msi.com/global/picture/article/seo_168231693464461e86d74365.66209087.jpeg",
                soluong: 1
            },

            {
                ten: "PC Gaming White",
                gia: 35990000,
                ton: 3,
                danhgia: 5.0,
                chitiet: "Full White RTX 4070",
                hinh: "https://vitinhlongphat.com.vn/thumbs/800x734x2/upload/product/z571681954956517ed310d67ca7ac970037855f1664d20-4285.jpg",
                soluong: 1
            }

        ],

                products: [],
                showChat: false,
                inputMessage: "", // Đã sửa từ inputChat thành inputMessage để đồng bộ với v-model ngoài Template
                messages: [
                    {
                        type: "bot",
                        text: "Xin chào 👋 Tôi là TechShop AI."
                    },
                    {
                        type: "bot",
                        text: "Bạn cần hỗ trợ laptop hay PC Gaming?"
                    }
                ]
            }
        },
        mounted() {
            if (AdminSP && AdminSP.data) {
                this.products = AdminSP.data().danhSach || [];
            }
        },
        methods: {
            clickProduct() {
                const checkLogin = localStorage.getItem("isLogin")
                if (checkLogin == "true") {
                    this.$router.push('/chi-tiet-sp')
                } else {
                    const modal = new bootstrap.Modal(document.getElementById('loginModal'))
                    modal.show()
                }
            },
            themGioHang(item) {
                const toast = useToast()
                const checkLogin = localStorage.getItem("isLogin")

                if (checkLogin == "true") {
                    let cart = JSON.parse(localStorage.getItem("cart")) || []
                    cart.push(item)
                    localStorage.setItem("cart", JSON.stringify(cart))
                    window.dispatchEvent(new Event("storage"))
                    toast.success("Đã thêm vào giỏ hàng 🛒")
                } else {
                    const modal = new bootstrap.Modal(document.getElementById('loginModal'))
                    modal.show()
                }
            },
            goLogin() {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove())
                document.body.classList.remove('modal-open')
                document.body.style = ""
                this.$router.push('/dang-nhap')
            },
            toggleChat() {
                this.showChat = !this.showChat
            },
          
sendMessage() {

    if (!this.inputMessage.trim()) return

    // thêm tin nhắn user
    this.messages.push({
        type: "user",
        text: this.inputMessage
    })

    const userText = this.inputMessage.toLowerCase()

    this.inputMessage = ""

    // fake loading
    setTimeout(() => {

        let reply = ""

        // laptop
        if (
    userText.includes("laptop") ||
    userText.includes("gaming")
) {

    reply = `
    🔥 TechShop AI gợi ý cho bạn:
        <br><br>

        <b>Lenovo Legion 5 Pro 2026</b>
        <br><br>

✅ Intel i9-14900HX<br>
✅ RTX 5070 12GB<br>
✅ RAM 32GB DDR5<br>
✅ SSD 1TB NVMe Gen 4<br>
✅ Màn hình 240Hz Gaming<br>
✅ Tản nhiệt RGB<br><br>

🎮 Chiến mọi game max setting
`

}

        // pc
        else if (
            userText.includes("pc") ||
            userText.includes("máy tính")
        ) {

            reply = `
              🔥 TechShop AI gợi ý cho bạn:
        <br><br>
💻 PC GAMING BEST SELLER<br><br>

✅ Intel Core i9-14900K<br>
✅ RTX 5090 24GB GDDR7<br>
✅ RAM 64GB DDR5 RGB<br>
✅ SSD 2TB NVMe Gen 4<br>
✅ Tản nhiệt nước 360 RGB<br>
✅ Nguồn 1000W Platinum<br>
✅ Case Full kính cường lực<br><br>

🔥 Stream - Render - Gaming max setting cực mượt
`

        }

        // giá
        else if (
            userText.includes("giá") ||
            userText.includes("bao nhiêu")
        ) {

            reply = "💰 Bạn muốn xem phân khúc dưới 20 triệu hay cao cấp hơn?"

        }

        // hello
        else if (
            userText.includes("hi") ||
            userText.includes("hello") ||
            userText.includes("xin chào")
        ) {

            reply = "👋 Xin chào bạn, mình có thể hỗ trợ Laptop, PC Gaming và phụ kiện."

        }

        // cảm ơn
        else if (
            userText.includes("cảm ơn") ||
            userText.includes("thank")
        ) {

            reply = "❤️ Không có gì nha, rất vui được hỗ trợ bạn."

        }

        // ship
        else if (
            userText.includes("ship") ||
            userText.includes("giao hàng")
        ) {

            reply = "🚚 Shop hỗ trợ giao hàng toàn quốc luôn nha."

        }

        // bảo hành
        else if (
            userText.includes("bảo hành")
        ) {

            reply = "🛡️ Sản phẩm bên shop bảo hành chính hãng đầy đủ nhé."

        }

        // bàn phím
        else if (
            userText.includes("bàn phím")
        ) {

            reply = "⌨️ Shop có nhiều bàn phím cơ gaming RGB cực đẹp luôn."

        }

        // chuột
        else if (
            userText.includes("chuột")
        ) {

            reply = "🖱️ Chuột gaming đang sale khá nhiều đó nha."

        }

        // màn hình
        else if (
            userText.includes("màn hình")
        ) {

            reply = "🖥️ Màn hình 144Hz và 240Hz đang bán rất chạy."

        }

        // mặc định
        else {

            const randomReplies = [

                "🤖 TechShop AI đã nhận tin nhắn của bạn.",

                "🔥 Bạn có muốn mình gợi ý sản phẩm hot không?",

                "💬 Bạn cần hỗ trợ thêm gì nữa không?",

                "🛒 Shop hiện đang có nhiều deal gaming rất ngon.",

                "⚡ Hôm nay nhiều sản phẩm đang giảm giá đó nha."

            ]

            reply = randomReplies[
                Math.floor(Math.random() * randomReplies.length)
            ]

        }

        // bot trả lời
        this.messages.push({
            type: "bot",
            text: reply
        })

    }, 700)

}





            
            
        }
    }
    </script>

<style>
/* ================= CHATBOX FIX FULL ================= */
/* ================= CHAT FIX FINAL ================= */
/* ================= CHAT FINAL ================= */

.chat-float{
    position: fixed;
    right: 25px;
    bottom: 25px;

    width: 65px;
    height: 65px;

    border-radius: 50%;
    background: linear-gradient(135deg,#ff416c,#ff4b2b);

    display:flex;
    align-items:center;
    justify-content:center;

    color:white;
    font-size:24px;

    cursor:pointer;

    z-index:99999;

    box-shadow:0 10px 30px rgba(255,65,108,.35);

    transition:.3s;
}

.chat-float:hover{
    transform:scale(1.08);
}

.chat-wrapper{
    position: fixed;

    right: 25px;
    bottom: 105px;

    width: 380px;
    height: 650px;

    background: white;

    border-radius: 28px;

    overflow: hidden;

    display:flex;
    flex-direction:column;

    z-index:99999;

    box-shadow:0 20px 60px rgba(0,0,0,.18);

    animation:showChat .3s ease;
}

@keyframes showChat{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.chat-top{
    background:linear-gradient(135deg,#ff416c,#ff4b2b);

    padding:18px;

    color:white;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.chat-profile{
    display:flex;
    align-items:center;
}

.avatar{
    width:50px;
    height:50px;

    border-radius:50%;

    background:rgba(255,255,255,.2);

    display:flex;
    align-items:center;
    justify-content:center;

    margin-right:12px;

    font-size:22px;
}

.chat-profile h4{
    margin:0;
    font-size:20px;
    font-weight:700;
}

.chat-profile p{
    margin:0;
    font-size:13px;
    opacity:.9;
}

.close-btn{
    width:42px;
    height:42px;

    border:none;
    border-radius:50%;

    background:rgba(255,255,255,.2);

    color:white;

    cursor:pointer;
}

.chat-content{
    flex:1;

    padding:18px;

    overflow-y:auto;

    background:#f4f6fb;
}

.bot-chat,
.user-chat{
    display:flex;
    margin-bottom:14px;
}

.user-chat{
    justify-content:flex-end;
}

.chat-avatar-small{
    width:35px;
    height:35px;

    border-radius:50%;

    background:#ff4b2b;

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    margin-right:10px;

    flex-shrink:0;
}

.chat-bubble{
    max-width:75%;

    padding:12px 15px;

    border-radius:18px;

    font-size:14px;

    line-height:1.5;
}

.chat-bubble.bot{
    background:white;

    border-bottom-left-radius:5px;

    box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.chat-bubble.user{
    background:linear-gradient(135deg,#ff416c,#ff4b2b);

    color:white;

    border-bottom-right-radius:5px;
}

.chat-bottom{
    padding:14px;

    border-top:1px solid #eee;

    display:flex;
    align-items:center;

    gap:10px;

    background:white;
}

.chat-bottom input{
    flex:1;

    height:50px;

    border:none;

    background:#f3f5f9;

    border-radius:999px;

    padding:0 18px;

    outline:none;
}

.icon-btn,
.send-btn{
    width:50px;
    height:50px;

    border:none;
    border-radius:50%;

    background:linear-gradient(135deg,#ff416c,#ff4b2b);

    color:white;

    flex-shrink:0;
}

@media(max-width:768px){

    .chat-wrapper{
        width:calc(100vw - 20px);
        height:85vh;

        right:10px;
        bottom:90px;
    }

}

.chat-content{
    align-items: stretch;
}

.bot-chat,
.user-chat{
    width: 100%;
}
/* CÁC CSS CŨ CỦA BẠN */
.product-card button:active{
    transform: scale(0.95);
}
.home-page{
    background: #f5f5f5;
    padding-bottom: 50px;
}
.main-banner{
    width: 100%;
    height: 620px;
    object-fit: cover;
    border-radius: 14px;
}
.small-banner{
    width: 100%;
    margin-left: 50px;
    border-radius: 14px;
    object-fit: cover;
    transition: 0.3s;
}
.small-banner:hover{
    transform: scale(1.02);
}
.right-banner-box{
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.right-banner-box img{
    width: 100%;
    border-radius: 14px;
    transition: 0.3s;
}
.right-banner-box img:hover{
    transform: scale(1.02);
}
.category-box{
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.category-title{
    background: #e63946;
    color: white;
    padding: 14px 18px;
    font-weight: bold;
    font-size: 18px;
}
.category-box ul{
    list-style: none;
    margin: 0;
    padding: 0;
}
.category-box li{
    padding: 15px 18px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 500;
}
.category-box li:hover{
    background: #f8f8f8;
    color: #e63946;
    padding-left: 25px;
}
.product-section{
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.section-title{
    background: linear-gradient(90deg,#e63946,#ff4d6d);
    color: white;
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.section-title h3{
    margin: 0;
    font-size: 30px;
    font-weight: bold;
}
.section-title span{
    cursor: pointer;
    font-weight: 500;
}
.col-lg-2-4{
    width: 20%;
}
.product-card{
    background: white;
    border-radius: 14px;
    padding: 18px;
    text-align: center;
    border: 1px solid #eee;
    transition: 0.3s;
    height: 100%;
}
.product-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.product-card img{
    width: 100%;
    height: 180px;
    object-fit: contain;
}
.product-card h5{
    margin-top: 15px;
    min-height: 50px;
    font-size: 18px;
    font-weight: 700;
}
.spec-box{
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 15px 0;
    justify-content: center;
}
.spec-box span{
    background: #f5f5f5;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 13px;
}
.old-price{
    color: #999;
    margin-bottom: 5px;
}
.new-price{
    color: #e63946;
    font-size: 28px;
    font-weight: 700;
}
.product-card button{
    width: 100%;
    border: none;
    background: #e63946;
    color: white;
    padding: 12px;
    border-radius: 999px;
    margin-top: 15px;
    font-weight: bold;
    transition: 0.3s;
}
.product-card button:hover{
    background: #c1121f;
}
.rating{
    margin-top: 15px;
    font-size: 14px;
    color: #777;
}
@media(max-width: 991px){
    .col-lg-2-4{
        width: 50%;
    }
    .main-banner{
        height: auto;
    }
}
@media(max-width: 576px){
    .col-lg-2-4{
        width: 100%;
    }
}
</style>