<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaGioHangRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã giỏ hàng khi xóa
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:gio_hangs,MaGH',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'id.required' => 'Mã giỏ hàng không được để trống',
            'id.integer'  => 'Mã giỏ hàng phải là số nguyên',
            'id.exists'   => 'Giỏ hàng không tồn tại',
        ];
    }
}