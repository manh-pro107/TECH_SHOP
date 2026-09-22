<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Models\SanPham;

use App\Http\Requests\ThemGioHangRequest;
use App\Http\Requests\SuaGioHangRequest;
use App\Http\Requests\XoaGioHangRequest;

class GioHangController extends Controller
{
    // Lấy giỏ hàng của khách hàng
    public function getData()
    {
        $user = auth('sanctum')->user();
    
        $data = GioHang::where("MaND", $user->MaND)
            ->with('sanPham')
            ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Lấy giỏ hàng thành công',
            'data' => $data
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addData(ThemGioHangRequest $request)
    {
        $user = auth('sanctum')->user();

        $san_pham = SanPham::where("MaSP", $request->MaSP)->first();

        // Kiểm tra sản phẩm còn hàng
        if ($san_pham->SoLuongTon <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm đã hết hàng'
            ]);
        }

        // Tìm sản phẩm đã có trong giỏ chưa
        $gio_hang = GioHang::where("MaND", $user->MaND)
            ->where("MaSP", $request->MaSP)
            ->first();

        if ($gio_hang) {

            $so_luong_moi = $gio_hang->SoLuong + $request->SoLuong;

            // Không cho vượt quá tồn kho
            if ($so_luong_moi > $san_pham->SoLuongTon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Số lượng sản phẩm vượt quá tồn kho'
                ]);
            }

            $gio_hang->update([
                'SoLuong' => $so_luong_moi
            ]);

        } else {

            // Kiểm tra số lượng thêm lần đầu
            if ($request->SoLuong > $san_pham->SoLuongTon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Số lượng sản phẩm vượt quá tồn kho'
                ]);
            }

            $gio_hang = GioHang::create([
                'MaND' => $user->MaND,
                'MaSP' => $request->MaSP,
                'SoLuong' => $request->SoLuong,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            'data' => $gio_hang
        ]);
    }

    // Cập nhật số lượng trong giỏ hàng
    public function update(SuaGioHangRequest $request)
{
    $user = auth('sanctum')->user();

    $gio_hang = GioHang::where("MaGH", $request->MaGH)
        ->where("MaND", $user->MaND)
        ->first();

    if (!$gio_hang) {
        return response()->json([
            'status' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng của bạn'
        ]);
    }

    $san_pham = SanPham::where("MaSP", $gio_hang->MaSP)->first();

    if ($request->SoLuong > $san_pham->SoLuongTon) {
        return response()->json([
            'status' => false,
            'message' => 'Số lượng sản phẩm vượt quá tồn kho'
        ]);
    }

    $gio_hang->update([
        'SoLuong' => $request->SoLuong
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Cập nhật giỏ hàng thành công',
        'data' => $gio_hang
    ]);
}

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy(XoaGioHangRequest $request)
{
    $user = auth('sanctum')->user();

    $gio_hang = GioHang::where("MaGH", $request->id)
        ->where("MaND", $user->MaND)
        ->first();

    if (!$gio_hang) {
        return response()->json([
            'status' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng của bạn'
        ]);
    }

    $gio_hang->delete();

    return response()->json([
        'status' => true,
        'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công'
    ]);
}
}