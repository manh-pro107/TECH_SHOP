<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\ThemNguoiDungRequest;
use App\Http\Requests\SuaNguoiDungRequest;
use App\Http\Requests\XoaNguoiDungRequest;

class NguoiDungController extends Controller
{
    // Lấy danh sách người dùng
    public function getData()
    {
        $data = NguoiDung::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu người dùng thành công',
            'data' => $data
        ]);
    }

    // Thêm người dùng
    public function addData(ThemNguoiDungRequest $request)
    {
        $data = NguoiDung::create([
            'HoTen'       => $request->HoTen,
            'Email'       => $request->Email,
            'MatKhau'     => Hash::make($request->MatKhau),
            'SoDienThoai' => $request->SoDienThoai,
            'DiaChi'      => $request->DiaChi,
            'Avatar'      => $request->Avatar,
            'MaQuyen'     => $request->MaQuyen,
            'TrangThai'   => $request->TrangThai ?? 'HoatDong',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm người dùng thành công',
            'data' => $data
        ]);
    }

    // Cập nhật người dùng
    public function update(Request $request)
    {
        $nguoi_dung = NguoiDung::where("MaND", $request->MaND)->first();

        $nguoi_dung->update([
            'HoTen'       => $request->HoTen,
            'Email'       => $request->Email,
            'SoDienThoai' => $request->SoDienThoai,
            'DiaChi'      => $request->DiaChi,
            'Avatar'      => $request->Avatar,
            'MaQuyen'     => $request->MaQuyen,
            'TrangThai'   => $request->TrangThai,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật người dùng thành công',
            'data' => $nguoi_dung
        ]);
    }

    // Xóa người dùng
    public function destroy(XoaNguoiDungRequest $request)
    {
        NguoiDung::where("MaND", $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa người dùng thành công'
        ]);
    }
}