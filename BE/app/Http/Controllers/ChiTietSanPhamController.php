<?php

namespace App\Http\Controllers;

use App\Models\ChiTietSanPham;

use App\Http\Requests\ThemChiTietSanPhamRequest;
use App\Http\Requests\SuaChiTietSanPhamRequest;
use App\Http\Requests\XoaChiTietSanPhamRequest;
use App\Models\ChiTietSP;

class ChiTietSanPhamController extends Controller
{
    // Lấy danh sách chi tiết sản phẩm
    public function getData()
    {
        $data = ChiTietSP::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu chi tiết sản phẩm thành công',
            'data' => $data
        ]);
    }

    // Lấy chi tiết theo mã sản phẩm
    public function getDetail($MaSP)
    {
        $data = ChiTietSP::where("MaSP", $MaSP)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Chi tiết sản phẩm không tồn tại'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy chi tiết sản phẩm thành công',
            'data' => $data
        ]);
    }

    // Thêm chi tiết sản phẩm
    public function addData(ThemChiTietSanPhamRequest $request)
    {
        $data = ChiTietSP::create([
            'MaSP' => $request->MaSP,
            'ThongSo' => $request->ThongSo,
            'MoTaChiTiet' => $request->MoTaChiTiet,
            'HinhAnhChiTiet' => $request->HinhAnhChiTiet,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm chi tiết sản phẩm thành công',
            'data' => $data
        ]);
    }

    // Cập nhật chi tiết sản phẩm
    public function update(SuaChiTietSanPhamRequest $request)
    {
        $chi_tiet = ChiTietSP::where("MaSP", $request->MaSP)->first();

        $chi_tiet->update([
            'ThongSo' => $request->ThongSo,
            'MoTaChiTiet' => $request->MoTaChiTiet,
            'HinhAnhChiTiet' => $request->HinhAnhChiTiet,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật chi tiết sản phẩm thành công',
            'data' => $chi_tiet
        ]);
    }

    // Xóa chi tiết sản phẩm
    public function destroy(XoaChiTietSanPhamRequest $request)
    {
        ChiTietSP::where("MaCTSP", $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa chi tiết sản phẩm thành công'
        ]);
    }
}