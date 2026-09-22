<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;

class ChiTietDonHangController extends Controller
{
    public function getData($MaDH)
    {
        $user = auth('sanctum')->user();

        $data = ChiTietDonHang::where("MaDH", $MaDH)
            ->whereHas('donHang', function ($query) use ($user) {
                $query->where("MaND", $user->MaND);
            })
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy chi tiết đơn hàng thành công',
            'data' => $data
        ]);
    }
}