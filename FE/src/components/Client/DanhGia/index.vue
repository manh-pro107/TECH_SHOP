<template>
    <div class="review-page">

        <!-- TITLE -->
        <div class="container text-center mt-3">
            <h5 class="fw-bold text-danger mb-1">
                <i class="fa-solid fa-star me-1"></i> Đánh giá sản phẩm
            </h5>
            <small class="text-muted">Chia sẻ trải nghiệm của bạn</small>
        </div>

        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-9">

                    <div class="review-card">

                        <!-- PRODUCT -->
                        <div class="d-flex align-items-center gap-4 mb-4">
                            <img :src="product.hinh" class="product-image shadow-sm">
                            <div>
                                <h4 class="fw-bold mb-1">{{ product.ten }}</h4>
                                <p class="text-muted mb-0">{{ product.mota }}</p>
                            </div>
                        </div>

                        <!-- ⭐ RATING -->
                        <div class="d-flex align-items-center mb-4">
                            <span class="fs-5 fw-medium">Chất lượng sản phẩm</span>

                            <div class="star-rating ms-3">
                                <i
                                    v-for="n in 5"
                                    :key="n"
                                    class="fa-star"
                                    :class="n <= rating ? 'fa-solid text-warning' : 'fa-regular text-secondary'"
                                    @click="setRating(n)"
                                    style="cursor:pointer"
                                ></i>
                            </div>
                        </div>

                        <!-- COMMENT -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Nhận xét của bạn</label>
                            <textarea
                                class="form-control"
                                rows="4"
                                v-model="comment"
                                placeholder="Viết cảm nhận của bạn..."
                            ></textarea>
                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-submit" @click="submitReview">
                                Gửi đánh giá
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { useToast } from "vue-toastification"

export default {
    data() {
        return {
            product: {
                hinh: "https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400",
                ten: "Laptop Gaming ASUS ROG Strix G15",
                mota: "Ryzen 7 | 8GB | 512GB | GTX 1650 | 144Hz"
            },

            rating: 0,
            comment: ""
        }
    },

    methods: {

        setRating(n) {
            this.rating = n
        },

        submitReview() {

            const toast = useToast()

            if (this.rating === 0) {
                toast.warning("⭐ Vui lòng chọn số sao!")
                return
            }

            if (!this.comment.trim()) {
                toast.error("📝 Vui lòng nhập nhận xét!")
                return
            }

            const reviewData = {
                rating: this.rating,
                comment: this.comment,
                product: this.product.ten
            }

            console.log("REVIEW:", reviewData)

            // SUCCESS TOAST
            toast.success("🔥 Gửi đánh giá thành công!", {
                timeout: 2000,
                icon: "⭐"
            })

            // reset form
            this.rating = 0
            this.comment = ""

            // ⏩ CHUYỂN VỀ LỊCH SỬ MUA HÀNG
            setTimeout(() => {
                this.$router.push("/lich-su-mua")
            }, 800)
        }
    }
}
</script>

<style scoped>
.review-card {
    background: white;
    border-radius: 16px;
    padding: 40px;
    margin-top: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.product-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
}

.star-rating i {
    font-size: 28px;
    margin-right: 6px;
    transition: 0.2s;
}

.star-rating i:hover {
    transform: scale(1.2);
}

.btn-submit {
    background: linear-gradient(90deg, #ffda6a, #f7c943);
    font-weight: 700;
    border-radius: 30px;
    padding: 10px 35px;
    border: none;
    box-shadow: 0 4px 12px rgba(255, 218, 106, 0.4);
    transition: 0.2s;
}

.btn-submit:hover {
    transform: translateY(-2px);
}
</style>