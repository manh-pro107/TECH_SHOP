<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use App\Http\Requests\DangNhapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function dangNhap(DangNhapRequest $request)
    {
        $nguoi_dung = NguoiDung::where(
            'Email',
            $request->Email
        )->first();

        if (!$nguoi_dung) {
            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không đúng'
            ]);
        }

        if (!Hash::check($request->MatKhau, $nguoi_dung->MatKhau)) {
            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không đúng'
            ]);
        }

        if ($nguoi_dung->TrangThai != 'HoatDong') {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản đã bị khóa'
            ]);
        }

        $token = $nguoi_dung->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'data' => [
                'nguoi_dung' => $nguoi_dung,
                'token' => $token
            ]
        ]);
    }

    public function checkToken(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa đăng nhập'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Token hợp lệ',
            'data' => $user
        ]);
    }

    public function dangXuat(Request $request)
{
    $user = Auth::guard('sanctum')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Bạn chưa đăng nhập'
        ], 401);
    }

    $user->currentAccessToken()->delete();

    return response()->json([
        'status' => true,
        'message' => 'Đăng xuất thành công'
    ]);
}
}