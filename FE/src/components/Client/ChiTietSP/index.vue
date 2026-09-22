    <template>

        <div class="detail-page">

            <!-- TOP -->
            <div class="container mt-4">

                <div class="bg-white p-4 rounded-4 shadow-sm">

                    <div class="row">

                        <!-- IMAGE -->
                        <div class="col-lg-6">

                            <div class="main-img-container mb-3 text-center">

                                <img
                                    :src="mainImg"
                                    class="img-fluid rounded"
                                >

                            </div>

                            <!-- THUMB -->
                            <div class="d-flex justify-content-center gap-2">

                                <img
                                    v-for="(img, index) in images"
                                    :key="index"
                                    :src="img"
                                    class="thumb-img"
                                    :class="{ active : mainImg == img }"
                                    @click="changeImg(img)"
                                >

                            </div>

                        </div>

                        <!-- INFO -->
                        <div class="col-lg-6 ps-lg-5">

                            <h2 class="product-title mt-3 mt-lg-0">

                                Màn hình ASUS TUF GAMING VG27AQ5A
                                27" Fast IPS 2K 210Hz chuyên game

                            </h2>

                            <div class="d-flex align-items-center gap-3 my-4">

                                <span class="price-current">

                                    5.999.999đ

                                </span>

                                <span class="price-old">

                                    7.500.000đ

                                </span>

                                <span class="badge bg-danger">

                                    -20%

                                </span>

                            </div>

                            <!-- BTN -->
                            <div class="row g-3">

                                <div class="col-6">

                                    <button
                                        class="btn btn-outline-danger btn-lg w-100 fw-bold py-3"
                                        @click="$router.push('/thanh-toantoan')"
                                    >

                                        MUA NGAY

                                    </button>

                                </div>

                                <div class="col-6">

                                    <button
                                        class="btn btn-danger btn-lg w-100 fw-bold py-3"
                                        @click="themGio"
                                    >

                                        THÊM VÀO GIỎ

                                    </button>

                                </div>

                            </div>

                            <!-- ƯU ĐÃI -->
                            <div class="mt-4 p-3 bg-light rounded-3 border">

                                <h6 class="fw-bold">

                                    <i class="fa-solid fa-gift text-danger me-2"></i>

                                    Ưu đãi đặc biệt:

                                </h6>

                                <ul class="small mb-0">

                                    <li>
                                        Tặng gói bảo hành 1 đổi 1 trong 30 ngày.
                                    </li>

                                    <li>
                                        Giảm thêm 200k khi thanh toán qua VNPay.
                                    </li>

                                    <li>
                                        Miễn phí lắp đặt tại nhà nội thành Đà Nẵng.
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- SP TƯƠNG TỰ -->
                <div class="mt-4">

                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">

                        <h5 class="fw-bold mb-4">

                            Sản phẩm tương tự

                        </h5>

                        <div class="row row-cols-2 row-cols-md-5 g-3">

                            <div
                                class="col"
                                v-for="(item,index) in related"
                                :key="index"
                            >

                                <div class="card h-100 card-similar shadow-sm p-2">

                                    <img
                                        :src="item.img"
                                        class="card-img-top rounded-3"
                                    >

                                    <div class="card-body p-2 text-center">

                                        <h6
                                            class="fw-bold small mb-2 text-truncate"
                                        >

                                            {{ item.n }}

                                        </h6>

                                        <div class="mb-2">

                                            <span class="badge-spec">

                                                {{ item.s1 }}

                                            </span>

                                            <span class="badge-spec">

                                                {{ item.s2 }}

                                            </span>

                                        </div>

                                        <div
                                            class="text-danger fw-bold small"
                                        >

                                            {{ item.p }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- INFO -->
                <div class="row mt-4 g-4">

                    <!-- LEFT -->
                    <div class="col-lg-7">

                        <div class="info-card shadow-sm">

                            <h5 class="section-title">

                                Thông tin sản phẩm

                            </h5>

                            <p>

                                Màn hình ASUS TUF GAMING VG27AQ5A
                                là một trong những màn hình gaming nổi bật
                                dành cho game thủ với thiết kế hiện đại
                                và tính năng vượt trội...

                            </p>

                            <img
                                :src="mainImg"
                                class="img-fluid rounded my-3"
                            >

                            <p>

                                Với độ phân giải 2K (QHD),
                                mọi chi tiết trong trò chơi sẽ được
                                tái hiện sắc nét nhất.

                            </p>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-lg-5">

                        <div class="info-card shadow-sm">

                            <h5 class="section-title">

                                Thông số kỹ thuật

                            </h5>

                            <table class="table table-striped small">

                                <tr>
                                    <td>Kích thước</td>
                                    <td>27 inch</td>
                                </tr>

                                <tr>
                                    <td>Độ phân giải</td>
                                    <td>2560 x 1440 (2K)</td>
                                </tr>

                                <tr>
                                    <td>Tấm nền</td>
                                    <td>Rapid IPS</td>
                                </tr>

                                <tr>
                                    <td>Tần số quét</td>
                                    <td>200Hz</td>
                                </tr>

                                <tr>
                                    <td>Phản hồi</td>
                                    <td>0.5ms</td>
                                </tr>

                            </table>

                        </div>

                    </div>

                    <div class="mt-4 mb-5">

<div class="bg-white p-4 rounded-4 shadow-sm">

    <h5 class="section-title">

        Đánh giá & Nhận xét

    </h5>

    <div class="row align-items-center text-center">

        <!-- LEFT -->
        <div class="col-md-4 border-end">

            <h1 class="display-4 fw-bold text-warning">

                4.9/5

            </h1>

            <div class="text-warning mb-2">

                <i class="fa-solid fa-star"></i>

                <i class="fa-solid fa-star"></i>

                <i class="fa-solid fa-star"></i>

                <i class="fa-solid fa-star"></i>

                <i class="fa-solid fa-star"></i>

            </div>

            <p class="text-muted">

                128 lượt đánh giá

            </p>

        </div>

        <!-- RIGHT -->
        <div class="col-md-8 px-lg-5 text-start small">

            <div class="d-flex align-items-center mb-3">

                <span class="me-2 review-text">

                    5 sao

                </span>

                <div
                    class="progress flex-grow-1"
                    style="height:8px;"
                >

                    <div
                        class="progress-bar bg-warning"
                        style="width:90%"
                    ></div>

                </div>

                <span class="ms-2 text-muted">

                    90%

                </span>

            </div>

            <div class="d-flex align-items-center mb-3">

                <span class="me-2 review-text">

                    4 sao

                </span>

                <div
                    class="progress flex-grow-1"
                    style="height:8px;"
                >

                    <div
                        class="progress-bar bg-warning"
                        style="width:8%"
                    ></div>

                </div>

                <span class="ms-2 text-muted">

                    8%

                </span>

            </div>

            <div class="d-flex align-items-center">

                <span class="me-2 review-text">

                    3 sao

                </span>

                <div
                    class="progress flex-grow-1"
                    style="height:8px;"
                >

                    <div
                        class="progress-bar bg-warning"
                        style="width:2%"
                    ></div>

                </div>

                <span class="ms-2 text-muted">

                    2%

                </span>

            </div>

        </div>

    </div>

    <!-- COMMENT -->
    <div class="mt-4">

        <div class="review-item">

            <div class="d-flex align-items-center mb-2">

                <img
                    src="https://i.pravatar.cc/50?img=12"
                    class="review-avatar"
                >

                <div>

                    <div class="fw-bold">

                        Nguyễn Văn A

                    </div>

                    <div class="text-warning small">

                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>

                    </div>

                </div>

            </div>

            <p class="mb-0 small text-secondary">

                Màn hình đẹp, màu sắc cực kỳ nét,
                chơi Valorant rất mượt 🔥

            </p>

        </div>

        <div class="review-item">

            <div class="d-flex align-items-center mb-2">

                <img
                    src="https://i.pravatar.cc/50?img=15"
                    class="review-avatar"
                >

                <div>

                    <div class="fw-bold">

                        Trần Minh Khang

                    </div>

                    <div class="text-warning small">

                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>

                    </div>

                </div>

            </div>

            <p class="mb-0 small text-secondary">

                Build chắc chắn, tần số quét cao,
                dùng chơi game FPS rất đã.

            </p>

        </div>

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

            mainImg: "/img_chitiet/man.jpg",

            images: [

                "/img_chitiet/1.jpg",
                "/img_chitiet/2.jpg",
                "/img_chitiet/3.jpg",
                "/img_chitiet/4.jpg"

            ],

            related: [

                {
                    n: "ASUS",
                    s1: "27 inch",
                    s2: "240Hz",
                    p: "2.990.000đ",
                    img: "/img_chitiet/asus.jpg"
                },

                {
                    n: "GIGABYTE",
                    s1: "27 inch",
                    s2: "240Hz",
                    p: "4.500.000đ",
                    img: "/img_chitiet/giga.jpg"
                },

                {
                    n: "SAMSUNG",
                    s1: "27 inch",
                    s2: "240Hz",
                    p: "2.490.000đ",
                    img: "/img_chitiet/ss.jpg"
                },

                {
                    n: "DELL",
                    s1: "27 inch",
                    s2: "240Hz",
                    p: "6.990.000đ",
                    img: "/img_chitiet/dell.png"
                },

                {
                    n: "ACER",
                    s1: "27 inch",
                    s2: "240Hz",
                    p: "4.990.000đ",
                    img: "/img_chitiet/acer.jpg"
                }

            ]

        }

    },

    methods: {

        changeImg(img) {

            this.mainImg = img

        },

        themGio() {

            alert("Đã thêm vào giỏ hàng 🛒")

        }

    }

}

</script>

    <style scoped>

    .detail-page{
        background: #f2f2f2;
        min-height: 100vh;
        padding-bottom: 50px;
    }

    /* IMAGE */

    .main-img-container{
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 2px solid #dee2e6;
    }

    .thumb-img{
        width: 80px;
        height: 80px;
        object-fit: cover;

        border-radius: 8px;
        cursor: pointer;

        border: 1px solid #dee2e6;

        transition: 0.3s;
    }

    .thumb-img:hover,
    .thumb-img.active{

        border-color: #d9534f;

        box-shadow: 0 0 5px rgba(217,83,79,.5);
    }

    /* INFO */

    .product-title{
        font-weight: 700;
        color: #2d3436;
    }

    .price-current{
        color: #d9534f;
        font-size: 2rem;
        font-weight: bold;
    }

    .price-old{
        text-decoration: line-through;
        color: #b2bec3;
        font-size: 1.2rem;
    }

    /* CARD */

    .info-card{
        background: white;
        border-radius: 12px;
        padding: 25px;
        min-height: 400px;
    }

    .section-title{
        font-weight: bold;
        margin-bottom: 20px;
        border-bottom: 2px solid #f2f2f2;
        padding-bottom: 10px;
    }

    /* RELATED */

    .card-similar{
        border: none;
        border-radius: 10px;
        transition: 0.3s;
        text-align: center;
    }

    .card-similar:hover{
        transform: translateY(-5px);

        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .badge-spec{
        background: #f8f9fa;
        font-size: 10px;

        padding: 2px 5px;

        border-radius: 4px;
        margin: 1px;

        display: inline-block;
    }
    .review-text{
    width: 55px;
    font-weight: 600;
}

.review-item{
    border-top: 1px solid #f1f1f1;
    padding-top: 18px;
    margin-top: 18px;
}

.review-avatar{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
}

    </style>