<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemChiTietSanPhamRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi thêm chi tiết sản phẩm
    public function rules(): array
    {
        return [
            'MaSP'           => 'required|integer|exists:san_phams,MaSP|unique:chi_tiet_san_phams,MaSP',
            'ThongSo'       => 'nullable|array',
            'MoTaChiTiet'   => 'nullable|string',
            'HinhAnhChiTiet'=> 'nullable|array',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'MaSP.required' => 'Mã sản phẩm không được để trống',
            'MaSP.integer'  => 'Mã sản phẩm phải là số nguyên',
            'MaSP.exists'   => 'Sản phẩm không tồn tại',
            'MaSP.unique'   => 'Sản phẩm đã có chi tiết',

            'ThongSo.array' => 'Thông số phải có dạng danh sách',

            'MoTaChiTiet.string' => 'Mô tả chi tiết phải là chuỗi ký tự',

            'HinhAnhChiTiet.array' => 'Hình ảnh chi tiết phải có dạng danh sách',
        ];
    }
}