<?php

namespace App\Http\Controllers;

use App\Models\Voucher;

use App\Http\Requests\ThemVoucherRequest;
use App\Http\Requests\SuaVoucherRequest;
use App\Http\Requests\XoaVoucherRequest;

class VoucherController extends Controller
{
    // Lấy danh sách voucher
    public function getData()
    {
        $data = Voucher::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu voucher thành công',
            'data' => $data
        ]);
    }

    // Thêm voucher
    public function addData(ThemVoucherRequest $request)
    {
        $data = Voucher::create([
            'MaGiamGia'  => $request->MaGiamGia,
            'GiaTriGiam' => $request->GiaTriGiam,
            'NgayHetHan' => $request->NgayHetHan,
            'TrangThai'  => $request->TrangThai ?? 'DangSuDung',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm voucher thành công',
            'data' => $data
        ]);
    }

    // Cập nhật voucher
    public function update(SuaVoucherRequest $request)
    {
        $voucher = Voucher::where("MaVoucher", $request->id)->first();

        $voucher->update([
            'MaGiamGia'  => $request->MaGiamGia,
            'GiaTriGiam' => $request->GiaTriGiam,
            'NgayHetHan' => $request->NgayHetHan,
            'TrangThai'  => $request->TrangThai,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật voucher thành công',
            'data' => $voucher
        ]);
    }

    // Xóa voucher
    public function destroy(XoaVoucherRequest $request)
    {
        Voucher::where("MaVoucher", $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa voucher thành công'
        ]);
    }
}