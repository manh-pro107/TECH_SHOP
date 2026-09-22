<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\ChiTietDonHang;
use App\Models\SanPham;
use App\Models\Voucher;

use App\Http\Requests\ThemDonHangRequest;
use App\Http\Requests\SuaDonHangRequest;
use App\Http\Requests\HuyDonHangRequest;

use Illuminate\Support\Facades\DB;

class DonHangController extends Controller
{
    // Lấy danh sách đơn hàng
    public function getData()
    {
        $user = auth('sanctum')->user();

        $data = DonHang::where("MaND", $user->MaND)->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu đơn hàng thành công',
            'data' => $data
        ]);
    }

    // Đặt hàng
    public function addData(ThemDonHangRequest $request)
    {
        $user = auth('sanctum')->user();
    
        return DB::transaction(function () use ($request, $user) {
    
            // Lấy giỏ hàng của khách hàng đang đăng nhập
            $gio_hangs = GioHang::where("MaND", $user->MaND)
                ->with('sanPham')
                ->get();
    
            // Kiểm tra giỏ hàng
            if ($gio_hangs->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Giỏ hàng đang trống'
                ]);
            }
    
            $tong_tien = 0;
    
            // Khóa sản phẩm để tránh 2 người mua cùng lúc
            foreach ($gio_hangs as $gio_hang) {
    
                $san_pham = SanPham::where("MaSP", $gio_hang->MaSP)
                    ->lockForUpdate()
                    ->first();
    
                // Kiểm tra tồn kho
                if ($san_pham->SoLuongTon < $gio_hang->SoLuong) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Sản phẩm ' . $san_pham->TenSP .
                            ' không đủ số lượng. Chỉ còn ' .
                            $san_pham->SoLuongTon . ' sản phẩm'
                    ]);
                }
    
                // Tính tiền
                $tong_tien += $san_pham->GiaBan * $gio_hang->SoLuong;
            }
    
            // Kiểm tra voucher
            $voucher = null;
    
            if ($request->MaVoucher) {
    
                $voucher = Voucher::where("MaVoucher", $request->MaVoucher)
                    ->first();
    
                if (!$voucher) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Voucher không tồn tại'
                    ]);
                }
    
                // Kiểm tra trạng thái voucher
                if ($voucher->TrangThai != 'DangSuDung') {
                    return response()->json([
                        'status' => false,
                        'message' => 'Voucher không còn được sử dụng'
                    ]);
                }
    
                // Kiểm tra hạn voucher
                if ($voucher->NgayHetHan &&
                    now()->toDateString() > $voucher->NgayHetHan) {
    
                    return response()->json([
                        'status' => false,
                        'message' => 'Voucher đã hết hạn'
                    ]);
                }
    
                // Giảm theo phần trăm
                $tong_tien = $tong_tien -
                    ($tong_tien * $voucher->GiaTriGiam / 100);
            }
    
            // Tạo đơn hàng
            $don_hang = DonHang::create([
                'MaND'                 => $user->MaND,
                'NgayDat'              => now(),
                'TongTien'             => $tong_tien,
                'PhuongThucThanhToan' => $request->PhuongThucThanhToan,
                'TrangThaiDH'          => 'ChoXacNhan',
                'MaVoucher'            => $request->MaVoucher,
                'TenNguoiNhan'         => $request->TenNguoiNhan,
                'SoDienThoaiNhan'      => $request->SoDienThoaiNhan,
                'DiaChiGiaoHang'       => $request->DiaChiGiaoHang,
            ]);
    
            // Tạo chi tiết đơn hàng và trừ kho
            foreach ($gio_hangs as $gio_hang) {
    
                $san_pham = SanPham::where("MaSP", $gio_hang->MaSP)
                    ->lockForUpdate()
                    ->first();
    
                ChiTietDonHang::create([
                    'MaDH'    => $don_hang->MaDH,
                    'MaSP'    => $san_pham->MaSP,
                    'SoLuong' => $gio_hang->SoLuong,
                    'GiaBan'  => $san_pham->GiaBan,
                ]);
    
                // Trừ tồn kho
                $san_pham->update([
                    'SoLuongTon' =>
                        $san_pham->SoLuongTon - $gio_hang->SoLuong
                ]);
            }
    
            // Xóa sản phẩm khỏi giỏ sau khi đặt hàng
            GioHang::where("MaND", $user->MaND)->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Đặt hàng thành công',
                'data' => $don_hang
            ]);
        });
    }
    // Cập nhật trạng thái đơn hàng
    public function update(SuaDonHangRequest $request)
    {
        $don_hang = DonHang::where("MaDH", $request->MaDH)->first();

        $don_hang->update([
            'TrangThaiDH' => $request->TrangThaiDH
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật đơn hàng thành công',
            'data' => $don_hang
        ]);
    }

    // Hủy đơn hàng và hoàn lại tồn kho
    public function cancel(HuyDonHangRequest $request)
    {
        return DB::transaction(function () use ($request) {
    
            $user = auth('sanctum')->user();
    
            $don_hang = DonHang::where("MaDH", $request->id)
                ->where("MaND", $user->MaND)
                ->lockForUpdate()
                ->first();
    
            // Kiểm tra đơn hàng
            if (!$don_hang) {
                return response()->json([
                    'status' => false,
                    'message' => 'Đơn hàng không tồn tại hoặc không thuộc tài khoản của bạn'
                ]);
            }
    
            // Chỉ cho hủy khi đơn đang chờ xác nhận
            if ($don_hang->TrangThaiDH != 'ChoXacNhan') {
                return response()->json([
                    'status' => false,
                    'message' => 'Đơn hàng không thể hủy ở trạng thái hiện tại'
                ]);
            }
    
            $chi_tiets = ChiTietDonHang::where("MaDH", $don_hang->MaDH)->get();
    
            // Hoàn lại tồn kho
            foreach ($chi_tiets as $chi_tiet) {
    
                $san_pham = SanPham::where("MaSP", $chi_tiet->MaSP)
                    ->lockForUpdate()
                    ->first();
    
                $san_pham->update([
                    'SoLuongTon' =>
                        $san_pham->SoLuongTon + $chi_tiet->SoLuong
                ]);
            }
    
            // Chuyển trạng thái thành đã hủy
            $don_hang->update([
                'TrangThaiDH' => 'DaHuy'
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Hủy đơn hàng thành công',
                'data' => $don_hang
            ]);
        });
    }
}