<?php

namespace App\Http\Controllers;

use App\Models\SanPham;

use App\Http\Requests\ThemSanPhamRequest;
use App\Http\Requests\SuaSanPhamRequest;
use App\Http\Requests\XoaSanPhamRequest;

class SanPhamController extends Controller
{
    // Lấy danh sách sản phẩm
    public function getData()
    {
        $data = SanPham::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu sản phẩm thành công',
            'data' => $data
        ]);
    }

    // Thêm sản phẩm
    public function addData(ThemSanPhamRequest $request)
    {
        $data = SanPham::create([
            'TenSP'       => $request->TenSP,
            'HinhAnh'     => $request->HinhAnh,
            'GiaBan'      => $request->GiaBan,
            'SoLuongTon'  => $request->SoLuongTon,
            'TrangThaiSP' => $request->TrangThaiSP ?? 'DangBan',
            'MaDM'        => $request->MaDM,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm sản phẩm thành công',
            'data' => $data
        ]);
    }

    // Cập nhật sản phẩm
    public function update(SuaSanPhamRequest $request)
    {
        $san_pham = SanPham::where("MaSP", $request->MaSP)->first();

        $san_pham->update([
            'TenSP'       => $request->TenSP,
            'HinhAnh'     => $request->HinhAnh,
            'GiaBan'      => $request->GiaBan,
            'SoLuongTon'  => $request->SoLuongTon,
            'TrangThaiSP' => $request->TrangThaiSP,
            'MaDM'        => $request->MaDM,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật sản phẩm thành công',
            'data' => $san_pham
        ]);
    }

    // Xóa sản phẩm
    public function destroy(XoaSanPhamRequest $request)
    {
        SanPham::where("MaSP", $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa sản phẩm thành công'
        ]);
    }
}