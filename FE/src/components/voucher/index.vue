<template>
    <div class="row">
  
      <div class="col-lg-12">
  
        <div class="card radius-10 border-top border-0 border-3 border-success">
  
          <!-- HEADER -->
          <div class="card-header d-flex justify-content-between align-items-center">
  
            <h4><b>QUẢN LÝ VOUCHER</b></h4>
  
            <button class="btn btn-success"
              data-bs-toggle="modal"
              data-bs-target="#addModal">
  
              <i class="fa-solid fa-plus"></i>
              Thêm Voucher
  
            </button>
  
          </div>
  
          <!-- TABLE -->
          <div class="card-body">
  
            <div class="table-responsive">
  
              <table class="table table-bordered table-hover align-middle text-nowrap">
  
                <thead>
                  <tr class="bg-success text-light text-center">
  
                    <th>STT</th>
                    <th>Mã Voucher</th>
                    <th>Mã Code</th>
                    <th>Loại</th>
                    <th>Giảm Giá</th>
                    <th>Đơn Tối Thiểu</th>
                    <th>Ngày BĐ</th>
                    <th>Ngày HH</th>
                    <th>Lượt Dùng</th>
                    <th>Trạng Thái</th>
                    <th>Action</th>
  
                  </tr>
                </thead>
  
                <tbody>
  
                  <tr v-for="(vc, index) in danhSachVoucher" :key="index">
  
                    <!-- STT -->
                    <td class="text-center">
                      {{ index + 1 }}
                    </td>
  
                    <!-- MÃ -->
                    <td class="text-center">
  
                      <span class="badge bg-dark">
                        {{ vc.maVoucher }}
                      </span>
  
                    </td>
  
                    <!-- CODE -->
                    <td>
  
                      <span class="badge bg-warning text-dark">
                        {{ vc.maCode }}
                      </span>
  
                    </td>
  
                    <!-- LOẠI -->
                    <td class="text-center">
  
                      <span
                        class="badge"
                        :class="{
                          'bg-primary': vc.loai == 'Giảm tiền',
                          'bg-danger': vc.loai == 'Giảm %',
                          'bg-info': vc.loai == 'Miễn phí ship'
                        }">
  
                        {{ vc.loai }}
  
                      </span>
  
                    </td>
  
                    <!-- GIÁ TRỊ -->
                    <td class="text-danger fw-bold text-center">
  
                      <span v-if="vc.loai == 'Giảm %'">
                        {{ vc.giaTri }} %
                      </span>
  
                      <span v-else>
                        {{ vc.giaTri.toLocaleString() }} đ
                      </span>
  
                    </td>
  
                    <!-- ĐƠN TỐI THIỂU -->
                    <td class="text-center">
  
                      {{ vc.donToiThieu.toLocaleString() }} đ
  
                    </td>
  
                    <!-- NGÀY -->
                    <td class="text-center">
                      {{ vc.ngayBatDau }}
                    </td>
  
                    <td class="text-center">
                      {{ vc.ngayHetHan }}
                    </td>
  
                    <!-- LƯỢT DÙNG -->
                    <td>
  
                      <div class="d-flex align-items-center">
  
                        <div class="progress w-100 me-2">
  
                          <div
                            class="progress-bar bg-success"
                            :style="{
                              width: (vc.luotDung / vc.gioiHan * 100) + '%'
                            }">
  
                          </div>
  
                        </div>
  
                        <small>
                          {{ vc.luotDung }}/{{ vc.gioiHan }}
                        </small>
  
                      </div>
  
                    </td>
  
                    <!-- STATUS -->
                    <td class="text-center">
  
                      <span
                        class="badge"
                        :class="'bg-' + vc.mauTrangThai">
  
                        {{ vc.trangThai }}
  
                      </span>
  
                    </td>
  
                    <!-- ACTION -->
                    <td class="text-center text-nowrap">
  
                      
  
                      <!-- UPDATE -->
                      <button class="btn btn-warning me-1"
                        data-bs-toggle="modal"
                        data-bs-target="#updateModal">
  
                        <i class="fa-solid fa-pen-to-square"></i>
  
                      </button>
  
                      <!-- DELETE -->
                      <button class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal">
  
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
  
    </div>
  
    <!-- ================= ADD ================= -->
    <div class="modal fade" id="addModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
  
          <div class="modal-header bg-success text-white">
  
            <h5 class="modal-title">
              Thêm Voucher
            </h5>
  
            <button class="btn-close" data-bs-dismiss="modal"></button>
  
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
  
                <label>Mã Voucher</label>
  
                <input type="text"
                  class="form-control"
                  placeholder="VD: VC001">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Mã Code</label>
  
                <input type="text"
                  class="form-control"
                  placeholder="VD: SALE50">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Loại Voucher</label>
  
                <select class="form-select">
  
                  <option>Giảm tiền</option>
                  <option>Giảm %</option>
                  <option>Miễn phí ship</option>
  
                </select>
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Giá trị giảm</label>
  
                <input type="number"
                  class="form-control"
                  placeholder="Nhập giá trị">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Đơn tối thiểu</label>
  
                <input type="number"
                  class="form-control"
                  placeholder="Nhập đơn tối thiểu">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Giới hạn lượt dùng</label>
  
                <input type="number"
                  class="form-control"
                  placeholder="100">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Ngày bắt đầu</label>
  
                <input type="date"
                  class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Ngày hết hạn</label>
  
                <input type="date"
                  class="form-control">
  
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
  
            <button class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Đóng
  
            </button>
  
            <button class="btn btn-success"
              data-bs-dismiss="modal">
  
              Thêm Voucher
  
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
              Cập nhật Voucher
            </h5>
  
            <button class="btn-close" data-bs-dismiss="modal"></button>
  
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
  
                <label>Mã Voucher</label>
  
                <input type="text"
                  class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Mã Code</label>
  
                <input type="text"
                  class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Loại Voucher</label>
  
                <select class="form-select">
  
                  <option>Giảm tiền</option>
                  <option>Giảm %</option>
                  <option>Miễn phí ship</option>
  
                </select>
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Giá trị giảm</label>
  
                <input type="number"
                  class="form-control">
  
              </div>
  
              <div class="col-md-6 mb-3">
  
                <label>Ngày hết hạn</label>
  
                <input type="date"
                  class="form-control">
  
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
              Xóa Voucher
            </h5>
  
            <button class="btn-close" data-bs-dismiss="modal"></button>
  
          </div>
  
          <div class="modal-body text-center">
  
            <img
              src="https://cdn-icons-png.flaticon.com/512/595/595067.png"
              width="80"
              class="mb-3"
            >
  
            <h5>
              Bạn có chắc muốn xóa voucher này?
            </h5>
  
          </div>
  
          <div class="modal-footer">
  
            <button class="btn btn-secondary"
              data-bs-dismiss="modal">
  
              Hủy
  
            </button>
  
            <button class="btn btn-danger"
              data-bs-dismiss="modal">
  
              Xóa Voucher
  
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
  
        danhSachVoucher: [
  
          {
            maVoucher: "VC001",
            maCode: "SALE50",
            loai: "Giảm tiền",
            giaTri: 50000,
            donToiThieu: 500000,
            ngayBatDau: "01/05/2026",
            ngayHetHan: "20/05/2026",
            luotDung: 25,
            gioiHan: 100,
            trangThai: "Đang hoạt động",
            mauTrangThai: "success"
          },
  
          {
            maVoucher: "VC002",
            maCode: "FREESHIP",
            loai: "Miễn phí ship",
            giaTri: 30000,
            donToiThieu: 200000,
            ngayBatDau: "03/05/2026",
            ngayHetHan: "18/05/2026",
            luotDung: 40,
            gioiHan: 150,
            trangThai: "Đang hoạt động",
            mauTrangThai: "primary"
          },
  
          {
            maVoucher: "VC003",
            maCode: "LAPTOP100",
            loai: "Giảm tiền",
            giaTri: 100000,
            donToiThieu: 10000000,
            ngayBatDau: "01/04/2026",
            ngayHetHan: "10/05/2026",
            luotDung: 80,
            gioiHan: 80,
            trangThai: "Hết hạn",
            mauTrangThai: "danger"
          },
  
          {
            maVoucher: "VC004",
            maCode: "PCVIP",
            loai: "Giảm %",
            giaTri: 10,
            donToiThieu: 20000000,
            ngayBatDau: "05/05/2026",
            ngayHetHan: "30/05/2026",
            luotDung: 5,
            gioiHan: 30,
            trangThai: "Đang hoạt động",
            mauTrangThai: "warning"
          }
  
        ]
  
      }
    }
  }
  </script>