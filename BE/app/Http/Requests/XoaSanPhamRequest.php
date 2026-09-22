<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaSanPhamRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã sản phẩm khi xóa
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:san_phams,MaSP',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'id.required' => 'Mã sản phẩm không được để trống',
            'id.integer'  => 'Mã sản phẩm phải là số nguyên',
            'id.exists'   => 'Sản phẩm không tồn tại',
        ];
    }
}