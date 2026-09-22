<template>

    <div class="search-page">

        <!-- CÓ SẢN PHẨM -->
        <div
            v-if="sanPhamFake.length > 0"
            class="container"
        >

            <h1 class="search-title mb-5">
                KẾT QUẢ TÌM KIẾM
            </h1>

            <div class="row g-4">

                <div
                    class="col-lg-3"
                    v-for="(item, index) in sanPhamFake"
                    :key="index"
                >

                    <div class="product-card">

                        <img :src="item.hinh">

                        <h5>
                            {{ item.ten }}
                        </h5>

                        <h4>
                            {{ item.gia }}đ
                        </h4>

                        <button>
                            Xem sản phẩm
                        </button>

                    </div>

                </div>

            </div>

        </div>

        <!-- KHÔNG CÓ -->
        <div
            v-else
            class="search-empty-container"
        >

            <h1 class="search-title">
                KẾT QUẢ TÌM KIẾM
            </h1>

            <img
                src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png"
                class="error-icon"
            >

            <div class="message-box">

                <h4>
                    Không tìm thấy sản phẩm
                </h4>

                <p>
                    Không có kết quả phù hợp với từ khóa của bạn
                </p>

                <button
                    class="btn-home"
                    @click="$router.push('/')"
                >
                    Quay về trang chủ
                </button>

            </div>

        </div>

    </div>

</template>

<script>

export default {

    data() {

        return {

            keyword: "",
            sanPhamFake: []

        }

    },

    mounted() {

        this.keyword = this.$route.query.q || ""

        this.fakeData()

    },

    watch: {

        '$route.query.q'(newValue){

            this.keyword = newValue || ""

            this.fakeData()

        }

    },

    methods: {

        fakeData() {

            const key = this.keyword.toLowerCase()

            if(key.includes("laptop")){

                this.sanPhamFake = [

                    {
                        ten: "Laptop Gaming ASUS RTX 4060",
                        gia: "29.990.000",
                        hinh: "https://images.unsplash.com/photo-1593642702821-c8da6771f0c6"
                    },

                    {
                        ten: "Laptop MSI Gaming",
                        gia: "25.990.000",
                        hinh: "https://images.unsplash.com/photo-1517336714739-489689fd1ca8"
                    }

                ]

            }

            else if(key.includes("pc")){

                this.sanPhamFake = [

                    {
                        ten: "PC Gaming RTX 4070",
                        gia: "35.000.000",
                        hinh: "https://images.unsplash.com/photo-1587202372775-e229f172b9d7"
                    }

                ]

            }

            else{

                this.sanPhamFake = []

            }

        }

    }

}

</script>
<style scoped>

.search-page{
    min-height: 80vh;
    background: #f5f5f5;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:40px 20px;
}

.search-empty-container{
    width:100%;
    max-width:700px;

    background:white;

    border-radius:24px;

    padding:50px 30px;

    text-align:center;

    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.search-title{
    font-size:40px;
    font-weight:800;

    margin-bottom:30px;

    color:#111;
}

.error-icon{
    width:180px;

    margin-bottom:30px;

    opacity:.95;
}

.message-box h4{
    font-size:28px;
    font-weight:700;

    margin-bottom:12px;

    color:#ef4444;
}

.message-box p{
    color:#777;

    font-size:17px;

    margin-bottom:30px;
}

.btn-home{
    border:none;

    background:linear-gradient(
        135deg,
        #ff416c,
        #ff4b2b
    );

    color:white;

    padding:14px 35px;

    border-radius:999px;

    font-size:16px;
    font-weight:700;

    transition:.3s;
}

.btn-home:hover{
    transform:translateY(-3px);

    box-shadow:0 10px 20px rgba(255,65,108,.25);
}

/* cc */
.product-card{
    background:white;

    border-radius:20px;

    padding:20px;

    text-align:center;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

    transition:.3s;

    height:100%;
}

.product-card:hover{
    transform:translateY(-5px);
}

.product-card img{
    width:100%;
    height:220px;

    object-fit:contain;
}

.product-card h5{
    margin-top:15px;

    font-size:18px;
    font-weight:700;

    min-height:50px;
}

.product-card h4{
    color:#ef4444;

    font-size:26px;
    font-weight:800;

    margin:15px 0;
}

.product-card button{
    border:none;

    width:100%;

    height:45px;

    border-radius:12px;

    background:linear-gradient(
        135deg,
        #ff416c,
        #ff4b2b
    );

    color:white;

    font-weight:700;
}
</style>