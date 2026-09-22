<template>
  <div class="row">
    <div class="col-lg-12">
      <div class="card radius-10 border-top border-0 border-3 border-info">
        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between">
          <h4><b>QUẢN LÝ SẢN PHẨM</b></h4>

          <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addModal"
          >
            Thêm sản phẩm
          </button>
        </div>

        <!-- TABLE -->
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
            <thead>
              <tr
                class="bg-primary text-light text-nowrap text-center align-middle"
              >
                <th>STT</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Hình</th>
                <th>Tồn</th>
                <th>Trạng thái</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(sp, index) in danhSach" :key="sp.MaSP">
                <td class="text-center">
                  {{ index + 1 }}
                </td>

                <td>{{ sp.MaSP }}</td>

                <td>{{ sp.TenSP }}</td>

                <td>{{ Number(sp.GiaBan).toLocaleString() }} đ</td>

                <td class="text-center">
                  <img
                    :src="sp.HinhAnh"
                    width="60"
                    height="50"
                    style="border-radius: 8px"
                  />
                </td>

                <td class="text-center">
                  {{ sp.SoLuongTon }}
                </td>

                <td>
    <span
        v-if="sp.SoLuongTon > 0"
        class="badge bg-success"
    >
        Đang bán
    </span>

    <span
        v-else
        class="badge bg-danger"
    >
        Hết hàng
    </span>
</td>

                <td class="text-center">
                  <button
                    class="btn btn-warning me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#updateModal"
                    @click="moSua(sp)"
                  >
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>

                  <button
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    @click="moXoa(index)"
                  >
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

  <!-- ================== MODAL THÊM ================== -->


<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Thêm sản phẩm</h5>

        <button
          class="btn-close"
          data-bs-dismiss="modal"
        ></button>
      </div>

      <div class="modal-body">

        <div class="row">

          <!-- TÊN -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spMoi.TenSP"
              class="form-control"
              placeholder="Tên sản phẩm"
            />
          </div>

          <!-- GIÁ -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spMoi.GiaBan"
              type="number"
              class="form-control"
              placeholder="Giá bán"
            />
          </div>

          <!-- HÌNH -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spMoi.HinhAnh"
              class="form-control"
              placeholder="Link hình"
            />
          </div>

          <!-- TỒN KHO -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spMoi.SoLuongTon"
              type="number"
              class="form-control"
              placeholder="Số lượng tồn"
            />
          </div>

          <!-- TRẠNG THÁI -->
          <div class="col-md-6 mb-2">
            <select
              v-model="spMoi.TrangThaiSP"
              class="form-select"
            >
              <option value="">-- Chọn trạng thái --</option>
              <option value="DangBan">Đang bán</option>
              <option value="HetHang">Hết hàng</option>
            </select>
          </div>

          <!-- DANH MỤC -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spMoi.MaDM"
              type="number"
              class="form-control"
              placeholder="Mã danh mục"
            />
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          Đóng
        </button>

        <button
          class="btn btn-success"
          data-bs-dismiss="modal"
          @click="themSP()"
        >
          Thêm
        </button>

      </div>

    </div>
  </div>
</div>
  <!-- ================== MODAL SỬA ================== -->

<!-- ================== MODAL SỬA ================== -->

<div class="modal fade" id="updateModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title">Sửa sản phẩm</h5>

        <button
          class="btn-close"
          data-bs-dismiss="modal"
        ></button>
      </div>

      <div class="modal-body">

        <div class="row">

          <!-- MÃ -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spSua.MaSP"
              class="form-control"
              placeholder="Mã sản phẩm"
              readonly
            />
          </div>

          <!-- TÊN -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spSua.TenSP"
              class="form-control"
              placeholder="Tên sản phẩm"
            />
          </div>

          <!-- GIÁ -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spSua.GiaBan"
              type="number"
              class="form-control"
              placeholder="Giá bán"
            />
          </div>

          <!-- HÌNH -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spSua.HinhAnh"
              class="form-control"
              placeholder="Link hình"
            />
          </div>

          <!-- TỒN -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spSua.SoLuongTon"
              type="number"
              class="form-control"
              placeholder="Số lượng tồn"
            />
          </div>

          <!-- TRẠNG THÁI -->
          <div class="col-md-6 mb-2">
            <select
              v-model="spSua.TrangThaiSP"
              class="form-select"
            >
              <option value="DangBan">Đang bán</option>
              <option value="HetHang">Hết hàng</option>
            </select>
          </div>

          <!-- DANH MỤC -->
          <div class="col-md-6 mb-2">
            <input
              v-model="spSua.MaDM"
              type="number"
              class="form-control"
              placeholder="Mã danh mục"
            />
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          Hủy
        </button>

        <button
          class="btn btn-success"
          data-bs-dismiss="modal"
          @click="luuSua()"
        >
          Lưu
        </button>

      </div>

    </div>
  </div>
</div>

  <!-- ================== MODAL XÓA ================== -->

  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Xác nhận xóa</h5>

          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">
          <p>Bạn có chắc muốn xóa sản phẩm này không?</p>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>

          <button
            class="btn btn-danger"
            data-bs-dismiss="modal"
            @click="xoaSP()"
          >
            Xóa
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      danhSach: [],

      spMoi: {
        TenSP: "",
        HinhAnh: "",
        GiaBan: "",
        SoLuongTon: "",
        TrangThaiSP: "",
        MaDM: "",
      },

      spSua: {},

      indexXoa: -1,
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    getData() {
      axios
        .get("http://127.0.0.1:8000/api/san-pham/get-data")
        .then((res) => {
          if (res.data.status) {
            this.danhSach = res.data.data;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    themSP() {
    axios
        .post("http://127.0.0.1:8000/api/san-pham/add-data", {
            TenSP: this.spMoi.TenSP,
            HinhAnh: this.spMoi.HinhAnh,
            GiaBan: this.spMoi.GiaBan,
            SoLuongTon: this.spMoi.SoLuongTon,
            TrangThaiSP: this.spMoi.TrangThaiSP || "DangBan",
            MaDM: this.spMoi.MaDM,
        })
        .then((res) => {
            if (res.data.status) {
                this.getData();

                this.spMoi = {
                    TenSP: "",
                    HinhAnh: "",
                    GiaBan: "",
                    SoLuongTon: "",
                    TrangThaiSP: "",
                    MaDM: "",
                };

                alert("Thêm sản phẩm thành công");
            }
        })
        .catch((error) => {
            console.log(error);
            alert("Thêm sản phẩm thất bại");
        });
},

moSua(sp) {
    this.spSua = { ...sp };
},

luuSua() {
    axios
        .put("http://127.0.0.1:8000/api/san-pham/update", {
            MaSP: this.spSua.MaSP,
            TenSP: this.spSua.TenSP,
            HinhAnh: this.spSua.HinhAnh,
            GiaBan: this.spSua.GiaBan,
            SoLuongTon: this.spSua.SoLuongTon,
            TrangThaiSP: this.spSua.TrangThaiSP,
            MaDM: this.spSua.MaDM,
        })
        .then((res) => {
            if (res.data.status) {
                this.getData();
                alert("Cập nhật sản phẩm thành công");
            }
        })
        .catch((error) => {
            console.log(error);
            alert("Cập nhật sản phẩm thất bại");
        });
},

moXoa(index) {
    this.indexXoa = index;
},

xoaSP() {
    let sp = this.danhSach[this.indexXoa];

    axios
        .delete("http://127.0.0.1:8000/api/san-pham/delete", {
            data: {
                id: sp.MaSP
            }
        })
        .then((res) => {
            if (res.data.status) {
                this.getData();
                this.indexXoa = -1;
                alert("Xóa sản phẩm thành công");
            }
        })
        .catch((error) => {
            console.log(error);
            alert("Xóa sản phẩm thất bại");
        });
},
  },
};
</script>






