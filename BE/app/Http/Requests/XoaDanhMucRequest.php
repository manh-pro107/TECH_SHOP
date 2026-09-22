<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaDanhMucRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã danh mục khi xóa
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:danh_mucs,MaDM',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'id.required' => 'Mã danh mục không được để trống',
            'id.integer'  => 'Mã danh mục phải là số nguyên',
            'id.exists'   => 'Danh mục không tồn tại',
        ];
    }
}