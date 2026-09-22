<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;

use Illuminate\Http\Request;

use App\Http\Requests\ThemDanhMucRequest;
use App\Http\Requests\SuaDanhMucRequest;
use App\Http\Requests\XoaDanhMucRequest;

class DanhMucController extends Controller
{
    // Lấy danh sách danh mục
    public function getData()
    {
        $data = DanhMuc::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu danh mục thành công',
            'data' => $data
        ]);
    }

    // Thêm danh mục
    public function addData(ThemDanhMucRequest $request)
    {
        $data = DanhMuc::create([
            'TenDM' => $request->TenDM,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm danh mục thành công',
            'data' => $data
        ]);
    }

    // Cập nhật danh mục
    public function update(SuaDanhMucRequest $request)
    {
        $danh_muc = DanhMuc::where("MaDM", $request->id)->first();

        $danh_muc->update([
            'TenDM' => $request->TenDM,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật danh mục thành công',
            'data' => $danh_muc
        ]);
    }

    // Xóa danh mục
    public function destroy(XoaDanhMucRequest $request)
    {
        DanhMuc::where("MaDM", $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa danh mục thành công'
        ]);
    }
}