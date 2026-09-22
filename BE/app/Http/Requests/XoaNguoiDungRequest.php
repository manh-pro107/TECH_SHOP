<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaNguoiDungRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã người dùng khi xóa
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:nguoi_dungs,MaND',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'id.required' => 'Mã người dùng không được để trống',
            'id.integer'  => 'Mã người dùng phải là số nguyên',
            'id.exists'   => 'Người dùng không tồn tại',
        ];
    }
}