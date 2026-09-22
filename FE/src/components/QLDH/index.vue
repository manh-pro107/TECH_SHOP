<template>
    <div class="row">
      <div class="col-lg-12">
        <div class="card radius-10 border-top border-0 border-3 border-success">
  
          <!-- HEADER -->
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4><b>QUẢN LÝ ĐƠN HÀNG</b></h4>
  
           
          </div>
  
          <!-- TABLE -->
          <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
  
              <thead>
                <tr class="bg-success text-light text-center text-nowrap">
                  <th>STT</th>
                  <th>Mã ĐH</th>
                  <th>Mã KH</th>
                  <th>Ngày Đặt</th>
                  <th>Tổng Tiền</th>
                  <th>Trạng Thái</th>
                  <th>Voucher</th>
                  <th>Số SP</th>
                  <th>Thanh Toán</th>
                  <th>Action</th>
                </tr>
              </thead>
  
              <tbody>
                <tr v-for="(dh, index) in danhSachDonHang" :key="index">
  
                  <td class="text-center">{{ index + 1 }}</td>
  
                  <td>
                    <span class="badge bg-dark">
                      {{ dh.maDon }}
                    </span>
                  </td>
  
                  <td>{{ dh.maKH }}</td>
  
                  <td>{{ dh.ngayDat }}</td>
  
                  <td class="text-danger fw-bold">
                    {{ dh.tongTien.toLocaleString() }} đ
                  </td>
  
                  <td class="text-center">
  
                    <span
                      class="badge"
                      :class="{
                        'bg-warning': dh.trangThai == 'Chờ xác nhận',
                        'bg-info': dh.trangThai == 'Đang giao',
                        'bg-success': dh.trangThai == 'Hoàn thành',
                        'bg-danger': dh.trangThai == 'Đã hủy'
                      }">
  
                      {{ dh.trangThai }}
  
                    </span>
  
                  </td>
  
                  <td class="text-center">
                    {{ dh.voucher }}
                  </td>
  
                  <td class="text-center">
                    {{ dh.soLuongSP }}
                  </td>
  
                  <td class="text-center">
  
                    <span
                      class="badge"
                      :class="dh.thanhToan == 'Đã thanh toán'
                      ? 'bg-success'
                      : 'bg-secondary'">
  
                      {{ dh.thanhToan }}
  
                    </span>
  
                  </td>
  
                  <!-- ACTION -->
                  <td class="text-center">
  
                    <button class="btn btn-warning me-1"
                      data-bs-toggle="modal"
                      data-bs-target="#updateModal">
  
                      <i class="fa-solid fa-pen-to-square"></i>
  
                    </button>
  
                    <button class="btn btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteModal">
  
                      <i class="fa-solid fa-xmark"></i>
  
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
  
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Thêm đơn hàng</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
                <label>Mã đơn hàng</label>
                <input type="text" class="form-control" placeholder="VD: DH001">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Mã khách hàng</label>
                <input type="text" class="form-control" placeholder="VD: KH001">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Ngày đặt</label>
                <input type="datetime-local" class="form-control">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Tổng tiền</label>
                <input type="number" class="form-control" placeholder="Nhập tổng tiền">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Trạng thái</label>
  
                <select class="form-select">
                  <option>Chờ xác nhận</option>
                  <option>Đang giao</option>
                  <option>Hoàn thành</option>
                  <option>Đã hủy</option>
                </select>
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Voucher</label>
                <input type="text" class="form-control" placeholder="SALE10">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Số lượng sản phẩm</label>
                <input type="number" class="form-control">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Thanh toán</label>
  
                <select class="form-select">
                  <option>Đã thanh toán</option>
                  <option>Chưa thanh toán</option>
                </select>
  
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">
              Đóng
            </button>
  
            <button class="btn btn-success" data-bs-dismiss="modal">
              Thêm đơn hàng
            </button>
          </div>
  
        </div>
      </div>
    </div>
  
    <!-- ================= SỬA ================= -->
    <div class="modal fade" id="updateModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
  
          <div class="modal-header bg-warning">
            <h5 class="modal-title">Cập nhật đơn hàng</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
  
          <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-6 mb-3">
                <label>Mã đơn hàng</label>
                <input type="text" class="form-control">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Mã khách hàng</label>
                <input type="text" class="form-control">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Ngày đặt</label>
                <input type="datetime-local" class="form-control">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Tổng tiền</label>
                <input type="number" class="form-control">
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Trạng thái</label>
  
                <select class="form-select">
                  <option>Chờ xác nhận</option>
                  <option>Đang giao</option>
                  <option>Hoàn thành</option>
                  <option>Đã hủy</option>
                </select>
  
              </div>
  
              <div class="col-md-6 mb-3">
                <label>Voucher</label>
                <input type="text" class="form-control">
              </div>
  
            </div>
  
          </div>
  
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">
              Hủy
            </button>
  
            <button class="btn btn-warning" data-bs-dismiss="modal">
              Lưu thay đổi
            </button>
          </div>
  
        </div>
      </div>
    </div>
  
    <!-- ================= XÓA ================= -->
    <div class="modal fade" id="deleteModal">
      <div class="modal-dialog">
        <div class="modal-content">
  
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Xóa đơn hàng</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
  
          <div class="modal-body text-center">
            <h5>Bạn có chắc muốn xóa đơn hàng này?</h5>
          </div>
  
          <div class="modal-footer">
  
            <button class="btn btn-secondary" data-bs-dismiss="modal">
              Hủy
            </button>
  
            <button class="btn btn-danger" data-bs-dismiss="modal">
              Xóa đơn hàng
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
        danhSachDonHang: [
  
          {
            maDon: "DH001",
            maKH: "KH001",
            ngayDat: "2026-05-05 08:30",
            tongTien: 25500000,
            trangThai: "Chờ xác nhận",
            voucher: "SALE10",
            soLuongSP: 2,
            thanhToan: "Chưa thanh toán"
          },
  
          {
            maDon: "DH002",
            maKH: "KH002",
            ngayDat: "2026-05-04 14:20",
            tongTien: 18000000,
            trangThai: "Đang giao",
            voucher: "FREESHIP",
            soLuongSP: 1,
            thanhToan: "Đã thanh toán"
          },
  
          {
            maDon: "DH003",
            maKH: "KH003",
            ngayDat: "2026-05-03 10:15",
            tongTien: 32000000,
            trangThai: "Hoàn thành",
            voucher: "SALE20",
            soLuongSP: 3,
            thanhToan: "Đã thanh toán"
          },
  
          {
            maDon: "DH004",
            maKH: "KH004",
            ngayDat: "2026-05-02 09:40",
            tongTien: 4500000,
            trangThai: "Đã hủy",
            voucher: "Không",
            soLuongSP: 1,
            thanhToan: "Chưa thanh toán"
          },
  
          {
            maDon: "DH005",
            maKH: "KH005",
            ngayDat: "2026-05-01 16:10",
            tongTien: 12000000,
            trangThai: "Hoàn thành",
            voucher: "SALE5",
            soLuongSP: 2,
            thanhToan: "Đã thanh toán"
          }
  
        ]
      }
    }
  }
  </script>