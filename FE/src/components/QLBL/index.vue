<template>

    <div class="row">

        <div class="col-lg-12">

            <div class="card border-0 shadow-lg radius-15">

                <!-- HEADER -->
                <div
                    class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                >

                    <div>

                        <h4 class="mb-0">

                            <i class="fa-solid fa-comments me-2"></i>

                            QUẢN LÝ BÌNH LUẬN

                        </h4>

                        <small>

                            Quản lý đánh giá và phản hồi khách hàng

                        </small>

                    </div>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="table table-hover align-middle text-nowrap"
                        >

                            <thead>

                                <tr
                                    class="table-success text-center align-middle"
                                >

                                    <th>STT</th>
                                    <th>Khách Hàng</th>
                                    <th>Sản Phẩm</th>
                                    <th>Nội Dung</th>
                                    <th>Đánh Giá</th>
                                    <th>Ngày</th>
                                    <th>Trạng Thái</th>
                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr
                                    v-for="(bl, index) in danhSachBinhLuan"
                                    :key="index"
                                >

                                    <!-- STT -->
                                    <td class="text-center">

                                        {{ index + 1 }}

                                    </td>

                                    <!-- USER -->
                                    <td>

                                        <div
                                            class="d-flex align-items-center"
                                        >

                                            <img
                                                :src="bl.avatar"
                                                width="50"
                                                height="50"
                                                class="rounded-circle me-2 border"
                                            >

                                            <div>

                                                <div class="fw-bold">

                                                    {{ bl.ten }}

                                                </div>

                                                <small class="text-muted">

                                                    {{ bl.email }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <!-- PRODUCT -->
                                    <td class="text-center">

                                        <span
                                            class="badge bg-success fs-6"
                                        >

                                            {{ bl.sanPham }}

                                        </span>

                                    </td>

                                    <!-- CONTENT -->
                                    <td
                                        style="
                                            max-width: 320px;
                                            white-space: normal;
                                        "
                                    >

                                        <div
                                            style="
                                                display: -webkit-box;
                                                -webkit-line-clamp: 2;
                                                -webkit-box-orient: vertical;
                                                overflow: hidden;
                                            "
                                        >

                                            {{ bl.noiDung }}

                                        </div>

                                    </td>

                                    <!-- STAR -->
                                    <td class="text-center">

                                        <span class="text-warning fw-bold">

                                            ⭐ {{ bl.sao }}/5

                                        </span>

                                    </td>

                                    <!-- DATE -->
                                    <td class="text-center">

                                        {{ bl.ngay }}

                                    </td>

                                    <!-- STATUS -->
                                    <td class="text-center">

                                        <span
                                            class="badge"
                                            :class="{
                                                'bg-success':
                                                    bl.trangThai ==
                                                    'Hiển thị',

                                                'bg-danger':
                                                    bl.trangThai ==
                                                    'Ẩn',

                                                'bg-warning text-dark':
                                                    bl.trangThai ==
                                                    'Chưa duyệt'
                                            }"
                                        >

                                            {{ bl.trangThai }}

                                        </span>

                                    </td>

                                    <!-- ACTION -->
                                    <td class="text-center">

                                        <!-- VIEW -->
                                        <button
                                            class="btn btn-primary btn-sm me-1"
                                            title="Xem"
                                        >

                                            <i
                                                class="fa-solid"
                                                :class="
                                                    bl.trangThai ==
                                                    'Hiển thị'
                                                        ? 'fa-eye'
                                                        : 'fa-eye-slash'
                                                "
                                            ></i>

                                        </button>

                                        <!-- DELETE -->
                                        <button
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                        >

                                            <i
                                                class="fa-solid fa-trash"
                                            ></i>

                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- DELETE MODAL -->

    <div class="modal fade" id="deleteModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-danger text-white">

                    <h5 class="modal-title">

                        Xóa Bình Luận

                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/179/179386.png"
                        width="80"
                        class="mb-3"
                    >

                    <h5>

                        Bạn có chắc muốn xóa bình luận này?

                    </h5>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >

                        Hủy

                    </button>

                    <button
                        class="btn btn-danger"
                        data-bs-dismiss="modal"
                    >

                        Xóa

                    </button>

                </div>

            </div>

        </div>

    </div>

</template>

<script>
export default {

    data() {

        return {

            danhSachBinhLuan: [

                {
                    ten: "Nguyễn Văn A",

                    email: "vana@gmail.com",

                    sanPham: "Laptop Dell",

                    noiDung:
                        "Laptop dùng rất mượt, pin ổn và phù hợp học tập.",

                    sao: 5,

                    ngay: "12/05/2026",

                    trangThai: "Hiển thị",

                    avatar:
                        "https://i.pravatar.cc/100?img=1"
                },

                {
                    ten: "Trần Minh K",

                    email: "minhk@gmail.com",

                    sanPham: "Chuột Logitech",

                    noiDung:
                        "Chuột cầm rất chắc tay, chơi game khá ngon.",

                    sao: 4,

                    ngay: "15/05/2026",

                    trangThai: "Hiển thị",

                    avatar:
                        "https://i.pravatar.cc/100?img=2"
                },

                {
                    ten: "Lê Quốc Bảo",

                    email: "bao@gmail.com",

                    sanPham: "PC Gaming",

                    noiDung:
                        "Máy chạy mạnh nhưng quạt hơi ồn khi render.",

                    sao: 4,

                    ngay: "20/05/2026",

                    trangThai: "Ẩn",

                    avatar:
                        "https://i.pravatar.cc/100?img=3"
                },

                {
                    ten: "Hoàng Nhật T",

                    email: "nhatt@gmail.com",

                    sanPham: "Tai nghe HyperX",

                    noiDung:
                        "Tai Nghe lỏ, mới mua đã hỏng",

                    sao: 1,

                    ngay: "22/05/2026",

                    trangThai: "Chưa duyệt",

                    avatar:
                        "https://i.pravatar.cc/100?img=4"
                },

                {
                    ten: "Phạm Quốc Huy",

                    email: "huy@gmail.com",

                    sanPham: "Bàn phím AKKO",

                    noiDung:
                        "LED đẹp, gõ rất êm và build cực chắc chắn.",

                    sao: 5,

                    ngay: "25/05/2026",

                    trangThai: "Hiển thị",

                    avatar:
                        "https://i.pravatar.cc/100?img=5"
                }

            ]

        }

    }

}
</script>