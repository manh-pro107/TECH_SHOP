<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\ChiTietDonHang;
use App\Http\Requests\ThemDanhGiaRequest;
use App\Http\Requests\SuaDanhGiaRequest;
use App\Http\Requests\XoaDanhGiaRequest;

class DanhGiaController extends Controller
{
    public function getData($MaSP)
    {
        $data = DanhGia::where("MaSP", $MaSP)->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách đánh giá thành công',
            'data' => $data
        ]);
    }

    public function addData(ThemDanhGiaRequest $request)
    {
        $user = auth('sanctum')->user();

        $da_mua = ChiTietDonHang::where("MaSP", $request->MaSP)
            ->whereHas('donHang', function ($query) use ($user) {
                $query->where("MaND", $user->MaND);
            })
            ->exists();

        if (!$da_mua) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải mua sản phẩm này mới được đánh giá'
            ]);
        }

        $da_danh_gia = DanhGia::where("MaND", $user->MaND)
            ->where("MaSP", $request->MaSP)
            ->exists();

        if ($da_danh_gia) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn đã đánh giá sản phẩm này rồi'
            ]);
        }

        $data = DanhGia::create([
            'MaSP' => $request->MaSP,
            'MaND' => $user->MaND,
            'SoSao' => $request->SoSao,
            'NoiDung' => $request->NoiDung,
            'NgayDG' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm đánh giá thành công',
            'data' => $data
        ]);
    }

    public function update(SuaDanhGiaRequest $request)
    {
        $user = auth('sanctum')->user();

        $danh_gia = DanhGia::where("MaDG", $request->MaDG)
            ->where("MaND", $user->MaND)
            ->first();

        if (!$danh_gia) {
            return response()->json([
                'status' => false,
                'message' => 'Đánh giá không tồn tại hoặc không thuộc tài khoản của bạn'
            ]);
        }

        $danh_gia->update([
            'SoSao' => $request->SoSao,
            'NoiDung' => $request->NoiDung,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật đánh giá thành công',
            'data' => $danh_gia
        ]);
    }

    public function destroy(XoaDanhGiaRequest $request)
    {
        $user = auth('sanctum')->user();
    
        $danh_gia = DanhGia::where("MaDG", $request->id)
            ->where("MaND", $user->MaND)
            ->first();
    
        if (!$danh_gia) {
            return response()->json([
                'status' => false,
                'message' => 'Đánh giá không tồn tại hoặc không thuộc tài khoản của bạn'
            ]);
        }
    
        $danh_gia->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Xóa đánh giá thành công'
        ]);
    }
}