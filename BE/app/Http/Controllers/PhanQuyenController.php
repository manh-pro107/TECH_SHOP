<?php

namespace App\Http\Controllers;

use App\Models\PhanQuyen;

class PhanQuyenController extends Controller
{
    // Lấy danh sách phân quyền
    public function getData()
    {
        $data = PhanQuyen::get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách phân quyền thành công',
            'data' => $data
        ]);
    }
}