<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemGioHangRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi thêm vào giỏ hàng
    public function rules(): array
    {
        return [
            'MaND'    => 'required|integer|exists:nguoi_dungs,MaND',
            'MaSP'    => 'required|integer|exists:san_phams,MaSP',
            'SoLuong' => 'required|integer|min:1',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'MaND.required'    => 'Mã người dùng không được để trống',
            'MaND.integer'     => 'Mã người dùng phải là số nguyên',
            'MaND.exists'      => 'Người dùng không tồn tại',

            'MaSP.required'    => 'Mã sản phẩm không được để trống',
            'MaSP.integer'     => 'Mã sản phẩm phải là số nguyên',
            'MaSP.exists'      => 'Sản phẩm không tồn tại',

            'SoLuong.required' => 'Số lượng không được để trống',
            'SoLuong.integer'  => 'Số lượng phải là số nguyên',
            'SoLuong.min'      => 'Số lượng phải lớn hơn 0',
        ];
    }
}