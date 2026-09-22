<template>
    <div class="row">
  
      <div class="col-lg-12">
  
        <div class="card radius-10 border-top border-0 border-3 border-primary">
  
          <!-- HEADER -->
          <div class="card-header d-flex justify-content-between align-items-center">
  
            <h4><b>QUẢN LÝ PHÂN QUYỀN</b></h4>
  
          
  
          </div>
  
          <!-- TABLE -->
          <div class="card-body">
  
            <table class="table table-bordered table-hover align-middle">
  
              <thead>
                <tr class="bg-primary text-light text-center text-nowrap">
  
                  <th>STT</th>
                  <th>Avatar</th>
                  <th>Họ Tên</th>
                  <th>Tài Khoản</th>
                  <th>Email</th>
                  <th>Quyền</th>
                  <th>Trạng Thái</th>
                  <th>Ngày Tạo</th>
                  <th>Action</th>
  
                </tr>
              </thead>
  
              <tbody>
  
                <tr v-for="(tk, index) in danhSachTaiKhoan" :key="index">
  
                  <td class="text-center">
                    {{ index + 1 }}
                  </td>
  
                  <!-- AVATAR -->
                  <td class="text-center">
  
                    <img
                      :src="tk.avatar"
                      width="50"
                      height="50"
                      class="rounded-circle border shadow-sm"
                    >
  
                  </td>
  
                  <!-- HỌ TÊN -->
                  <td class="text-nowrap">
                    <b>{{ tk.hoTen }}</b>
                  </td>
  
                  <!-- USERNAME -->
                  <td>
                    {{ tk.tenDangNhap }}
                  </td>
  
                  <!-- EMAIL -->
                  <td>
                    {{ tk.email }}
                  </td>
  
                  <!-- ROLE -->
                  <td class="text-center">
  
                    <span
                      class="badge"
                      :class="'bg-' + tk.mauRole">
  
                      {{ tk.quyen }}
  
                    </span>
  
                  </td>
  
                  <!-- STATUS -->
                  <td class="text-center">
  
                    <span
                      class="badge"
                      :class="tk.trangThai == 'Online'
                      ? 'bg-success'
                      : 'bg-secondary'">
  
                      {{ tk.trangThai }}
  
                    </span>
  
                  </td>
  
                  <!-- DATE -->
                  <td class="text-center">
                    {{ tk.ngayTao }}
                  </td>
  
                  <!-- ACTION -->
                  <td class="text-center text-nowrap">
  
                    <!-- PHÂN QUYỀN -->
                    <button
                      class="btn btn-info me-1"
                      title="Phân quyền">
  
                      <i class="fa-solid fa-user-shield"></i>
  
                    </button>
  
                    <!-- SỬA -->
                   
  
                    <!-- KHÓA -->
                    <button
                      class="btn btn-dark me-1"
                      title="Khóa tài khoản">
  
                      <i class="fa-solid fa-lock"></i>
  
                    </button>
  
                    <!-- XÓA -->
                    <button
                      class="btn btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteModal"
                      title="Xóa">
  
                      <i class="fa-solid fa-trash"></i>
  
                    </button>
  
                  </td>
  
                </tr>
  
              </tbody>
  
            </table>
  
          </div>
  
        </div>
  
      </div>
  
    </div>
  
    <!-- ================= THÊM ================= -->
    <div class="modal fade" id="addModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
  
          <div class="modal-header bg-primary text-white">
  
            <h5 class="modal-title">
              Thêm tài khoản
            </h5>
  
            <button class="btn-close" data-bs-dismiss="modal"></button>
  
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
  
                <label>Họ tên</label>
  
                <input type="text"
                  class="form-control"
                  placeholder="Nhập họ tên">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Tài khoản</label>
  
                <input type="text"
                  class="form-control"
                  placeholder="Nhập username">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Email</label>
  
                <input type="email"
                  class="form-control"
                  placeholder="Nhập email">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Mật khẩu</label>
  
                <input type="password"
                  class="form-control"
                  placeholder="Nhập mật khẩu">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Quyền</label>
  
                <select class="form-select">
  
                  <option>Super Admin</option>
                  <option>Quản Lý Kho</option>
                  <option>Nhân Viên Sale</option>
                  <option>CSKH</option>
                  <option>Content</option>
  
                </select>
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Trạng thái</label>
  
                <select class="form-select">
  
                  <option>Online</option>
                  <option>Offline</option>
  
                </select>
  
              </div>
  
              <div class="col-md-12 mb-3">
  
                <label>Avatar</label>
  
                <input type="text"
                  class="form-control"
                  placeholder="Link avatar">
  
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
  
            <button class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Đóng
  
            </button>
  
            <button class="btn btn-primary"
              data-bs-dismiss="modal">
  
              Thêm tài khoản
  
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
              Cập nhật tài khoản
            </h5>
  
            <button class="btn-close" data-bs-dismiss="modal"></button>
  
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
  
                <label>Họ tên</label>
  
                <input type="text" class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Tài khoản</label>
  
                <input type="text" class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Email</label>
  
                <input type="email" class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Quyền</label>
  
                <select class="form-select">
  
                  <option>Super Admin</option>
                  <option>Quản Lý Kho</option>
                  <option>Nhân Viên Sale</option>
                  <option>CSKH</option>
  
                </select>
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Trạng thái</label>
  
                <select class="form-select">
  
                  <option>Online</option>
                  <option>Offline</option>
  
                </select>
  
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
  
            <button class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Hủy
  
            </button>
  
            <button class="btn btn-warning"
              data-bs-dismiss="modal">
  
              Lưu thay đổi
  
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
              Xóa tài khoản
            </h5>
  
            <button class="btn-close" data-bs-dismiss="modal"></button>
  
          </div>
  
          <div class="modal-body text-center">
  
            <img
              src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png"
              width="90"
              class="mb-3"
            >
  
            <h5>
              Bạn có chắc muốn xóa tài khoản này?
            </h5>
  
          </div>
  
          <div class="modal-footer">
  
            <button class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Hủy
  
            </button>
  
            <button class="btn btn-danger"
              data-bs-dismiss="modal">
  
              Xóa tài khoản
  
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
  
        danhSachTaiKhoan: [
  
          {
            hoTen: "Đặng Xuân Mạnh",
            tenDangNhap: "manhadmin",
            email: "cr7@gmail.com",
            avatar: "https://i.pravatar.cc/100?img=1",
            quyen: "Super Admin",
            mauRole: "danger",
            trangThai: "Online",
            ngayTao: "05/05/2026"
          },
  
          {
            hoTen: "Nguyễn Văn An",
            tenDangNhap: "sale01",
            email: "sale01@gmail.com",
            avatar: "https://i.pravatar.cc/100?img=2",
            quyen: "Nhân Viên Sale",
            mauRole: "primary",
            trangThai: "Offline",
            ngayTao: "04/05/2026"
          },
  
          {
            hoTen: "Trần thị Hưng",
            tenDangNhap: "cskh01",
            email: "cskh01@gmail.com",
            avatar: "https://i.pravatar.cc/100?img=3",
            quyen: "CSKH",
            mauRole: "info",
            trangThai: "Online",
            ngayTao: "03/05/2026"
          },
  
          {
            hoTen: "Lê Bảo móm",
            tenDangNhap: "kho01",
            email: "kho01@gmail.com",
            avatar: "https://tse1.mm.bing.net/th/id/OIP.8FZl8L2CgeiahDZnmrKNhwHaEL?rs=1&pid=ImgDetMain&o=7&rm=3",
            quyen: "Quản Lý Chatbot",
            mauRole: "warning",
            trangThai: "Online",
            ngayTao: "02/05/2026"
          },

          {
            hoTen: "Nguyễn Thị Béo",
            tenDangNhap: "kho01",
            email: "beo01@gmail.com",
            avatar: "https://th.bing.com/th/id/R.a68aeb419f5087e04af3b08b1d3470a0?rik=6uU8kuJcbv3DtQ&pid=ImgRaw&r=0",
            quyen: "Báo cáo Doanh thu",
            mauRole: "warning",
            trangThai: "Online",
            ngayTao: "02/05/2026"
          }
  
        ]
  
      }
    }
  }
  </script>