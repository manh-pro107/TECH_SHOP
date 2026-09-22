<template>
    <div class="row">
  
      <div class="col-lg-12">
  
        <div class="card radius-10 border-top border-0 border-3 border-primary">
  
          <!-- HEADER -->
          <div class="card-header d-flex justify-content-between align-items-center">
  
            <div>
              <h4 class="mb-0">
                <b>QUẢN LÝ CHATBOT AI</b>
              </h4>
  
              <small class="text-muted">
                Quản lý dữ liệu phản hồi tự động cho khách hàng
              </small>
            </div>
  
            <button
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#addModal">
  
              <i class="fa-solid fa-plus"></i>
              Huấn luyện ChatBot
  
            </button>
  
          </div>
  
          <!-- BODY -->
          <div class="card-body">
  
            <div class="table-responsive">
  
              <table class="table table-bordered table-hover align-middle text-nowrap">
  
                <thead>
                  <tr class="bg-primary text-light text-center">
  
                    <th>STT</th>
                    <th>Từ Khóa</th>
                    <th>Câu Trả Lời</th>
                    <th>Danh Mục</th>
                    <th>Độ Ưu Tiên</th>
                    <th>Lượt Chat</th>
                    <th>Trạng Thái</th>
                    <th>Action</th>
  
                  </tr>
                </thead>
  
                <tbody>
  
                  <tr
                    v-for="(bot, index) in danhSachChatbot"
                    :key="index">
  
                    <!-- STT -->
                    <td class="text-center">
                      {{ index + 1 }}
                    </td>
  
                    <!-- TỪ KHÓA -->
                    <td>
  
                      <span class="badge bg-dark fs-6">
  
                        {{ bot.tuKhoa }}
  
                      </span>
  
                    </td>
  
                    <!-- TRẢ LỜI -->
                    <td
  style="
    max-width: 300px;
    white-space: normal;
  "
>

  <div
    class="fw-bold"
    style="
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    "
  >

    {{ bot.traLoi }}

  </div>

</td>
  
                    <!-- DANH MỤC -->
                    <td class="text-center">
  
                      <span
                        class="badge"
                        :class="{
                          'bg-primary': bot.danhMuc == 'Laptop',
                          'bg-success': bot.danhMuc == 'PC',
                          'bg-warning': bot.danhMuc == 'Phụ kiện',
                          'bg-info': bot.danhMuc == 'Khuyến mãi'
                        }">
  
                        {{ bot.danhMuc }}
  
                      </span>
  
                    </td>
  
                    <!-- ƯU TIÊN -->
                    <td class="text-center">
  
                      <span
                        class="badge"
                        :class="{
                          'bg-danger': bot.uuTien == 'Cao',
                          'bg-warning': bot.uuTien == 'Trung bình',
                          'bg-secondary': bot.uuTien == 'Thấp'
                        }">
  
                        {{ bot.uuTien }}
  
                      </span>
  
                    </td>
  
                    <!-- LƯỢT CHAT -->
                    <td>
  
                      <div class="d-flex align-items-center">
  
                        <div class="progress w-100 me-2">
  
                          <div
                            class="progress-bar bg-success"
                            :style="{
                              width: bot.luotDung + '%'
                            }">
  
                          </div>
  
                        </div>
  
                        <small>
                          {{ bot.soLuong }}
                        </small>
  
                      </div>
  
                    </td>
  
                    <!-- STATUS -->
                    <td class="text-center">
  
                      <span
                        class="badge"
                        :class="bot.trangThai == 'Hoạt động'
                        ? 'bg-success'
                        : 'bg-danger'">
  
                        {{ bot.trangThai }}
  
                      </span>
  
                    </td>
  
                    <!-- ACTION -->
                    <td class="text-center text-nowrap">
  
                      <!-- TEST -->
                      <button
                        class="btn btn-primary me-1"
                        title="Test chatbot">
  
                        <i class="fa-solid fa-comments"></i>
  
                      </button>
  
                      <!-- EDIT -->
                      <!-- <button
                        class="btn btn-warning me-1"
                        data-bs-toggle="modal"
                        data-bs-target="#updateModal">
  
                        <i class="fa-solid fa-pen-to-square"></i>
  
                      </button> -->
  
                      <!-- ON/OFF -->
                      <button
                        class="btn btn-dark me-1"
                        title="Ẩn phản hồi">
  
                        <i class="fa-solid fa-power-off"></i>
  
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
  
    <!-- ================= ADD ================= -->
    <div class="modal fade" id="addModal">
  
      <div class="modal-dialog modal-lg">
  
        <div class="modal-content">
  
          <div class="modal-header bg-primary text-white">
  
            <h5 class="modal-title">
  
              Thêm Kịch Bản Chatbot
  
            </h5>
  
            <button
              class="btn-close"
              data-bs-dismiss="modal">
  
            </button>
  
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <!-- TỪ KHÓA -->
              <div class="col-md-6 mb-3">
  
                <label>Từ khóa</label>
  
                <input
                  type="text"
                  class="form-control"
                  placeholder="VD: laptop gaming">
  
              </div>
  
              <!-- DANH MỤC -->
              <div class="col-md-6 mb-3">
  
                <label>Danh mục</label>
  
                <select class="form-select">
  
                  <option>Laptop</option>
                  <option>PC</option>
                  <option>Phụ kiện</option>
                  <option>Khuyến mãi</option>
  
                </select>
  
              </div>
  
              <!-- CÂU TRẢ LỜI -->
              <div class="col-md-12 mb-3">
  
                <label>Câu trả lời</label>
  
                <textarea
                  rows="4"
                  class="form-control"
                  placeholder="Nhập nội dung chatbot phản hồi...">
  
                </textarea>
  
              </div>
  
              <!-- ĐỘ ƯU TIÊN -->
              <div class="col-md-6 mb-3">
  
                <label>Độ ưu tiên</label>
  
                <select class="form-select">
  
                  <option>Cao</option>
                  <option>Trung bình</option>
                  <option>Thấp</option>
  
                </select>
  
              </div>
  
              <!-- STATUS -->
              <div class="col-md-6 mb-3">
  
                <label>Trạng thái</label>
  
                <select class="form-select">
  
                  <option>Hoạt động</option>
                  <option>Ẩn</option>
  
                </select>
  
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
  
            <button
              class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Đóng
  
            </button>
  
            <button
              class="btn btn-primary"
              data-bs-dismiss="modal">
  
              Thêm Dữ Liệu
  
            </button>
  
          </div>
  
        </div>
  
      </div>
  
    </div>
  
    <!-- ================= UPDATE ================= -->
    <div class="modal fade" id="updateModal">
  
      <div class="modal-dialog modal-lg">
  
        <div class="modal-content">
  
          <div class="modal-header bg-warning">
  
            <h5 class="modal-title">
  
              Cập Nhật Chatbot
  
            </h5>
  
            <button
              class="btn-close"
              data-bs-dismiss="modal">
  
            </button>
  
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
  
                <label>Từ khóa</label>
  
                <input
                  type="text"
                  class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Danh mục</label>
  
                <select class="form-select">
  
                  <option>Laptop</option>
                  <option>PC</option>
  
                </select>
  
              </div>
  
              <div class="col-md-12 mb-3">
  
                <label>Câu trả lời</label>
  
                <textarea
                  rows="4"
                  class="form-control">
  
                </textarea>
  
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
  
            <button
              class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Hủy
  
            </button>
  
            <button
              class="btn btn-warning"
              data-bs-dismiss="modal">
  
              Lưu Thay Đổi
  
            </button>
  
          </div>
  
        </div>
  
      </div>
  
    </div>
  
    <!-- ================= DELETE ================= -->
    <div class="modal fade" id="deleteModal">
  
      <div class="modal-dialog">
  
        <div class="modal-content">
  
          <div class="modal-header bg-danger text-white">
  
            <h5 class="modal-title">
  
              Xóa Dữ Liệu Chatbot
  
            </h5>
  
            <button
              class="btn-close"
              data-bs-dismiss="modal">
  
            </button>
  
          </div>
  
          <div class="modal-body text-center">
  
            <img
              src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png"
              width="90"
              class="mb-3"
            >
  
            <h5>
  
              Bạn có chắc muốn xóa dữ liệu chatbot này?
  
            </h5>
  
          </div>
  
          <div class="modal-footer">
  
            <button
              class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Hủy
  
            </button>
  
            <button
              class="btn btn-danger"
              data-bs-dismiss="modal">
  
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
  
        danhSachChatbot: [
  
          {
            tuKhoa: "laptop gaming",
            traLoi: "Bạn có thể tham khảo ASUS ROG hoặc Acer Nitro để chơi game mượt.",
            danhMuc: "Laptop",
            uuTien: "Cao",
            luotDung: 85,
            soLuong: 245,
            trangThai: "Hoạt động"
          },
  
          {
            tuKhoa: "pc đồ họa",
            traLoi: "PC RTX 4060 phù hợp thiết kế đồ họa và render video.",
            danhMuc: "PC",
            uuTien: "Trung bình",
            luotDung: 60,
            soLuong: 132,
            trangThai: "Hoạt động"
          },
  
          {
            tuKhoa: "chuột gaming",
            traLoi: "Logitech G102 là chuột gaming giá rẻ bán chạy nhất hiện tại.",
            danhMuc: "Phụ kiện",
            uuTien: "Thấp",
            luotDung: 35,
            soLuong: 75,
            trangThai: "Ẩn"
          },
  
          {
            tuKhoa: "voucher",
            traLoi: "Hiện shop đang có voucher SALE50 giảm 50K cho đơn từ 500K.",
            danhMuc: "Khuyến mãi",
            uuTien: "Cao",
            luotDung: 90,
            soLuong: 410,
            trangThai: "Hoạt động"
          },

          {
    tuKhoa: "laptop sinh viên",
    traLoi: "Dell Inspiron và ASUS Vivobook phù hợp học tập và lập trình cho sinh viên.",
    danhMuc: "Laptop",
    uuTien: "Cao",
    luotDung: 78,
    soLuong: 186,
    trangThai: "Hoạt động"
},

{
    tuKhoa: "pc gaming mạnh",
    traLoi: "PC RTX 4070 và Ryzen 7 sẽ giúp chơi game AAA cực mượt.",
    danhMuc: "PC",
    uuTien: "Cao",
    luotDung: 82,
    soLuong: 221,
    trangThai: "Hoạt động"
},

{
    tuKhoa: "màn hình đồ họa",
    traLoi: "Màn hình LG UltraWide và ASUS ProArt phù hợp thiết kế đồ họa chuyên nghiệp.",
    danhMuc: "Phụ kiện",
    uuTien: "Trung bình",
    luotDung: 45,
    soLuong: 96,
    trangThai: "Hoạt động"
},

{
    tuKhoa: "tai nghe gaming",
    traLoi: "HyperX Cloud II và Logitech G733 là tai nghe gaming được nhiều game thủ lựa chọn.",
    danhMuc: "Phụ kiện",
    uuTien: "Thấp",
    luotDung: 30,
    soLuong: 65,
    trangThai: "Ẩn"
},

{
    tuKhoa: "khuyến mãi laptop",
    traLoi: "Hiện tại shop đang giảm đến 15% cho laptop gaming ASUS ROG.",
    danhMuc: "Khuyến mãi",
    uuTien: "Cao",
    luotDung: 95,
    soLuong: 520,
    trangThai: "Hoạt động"
}
  
        ]
  
      }
  
    }
  
  }
  </script>