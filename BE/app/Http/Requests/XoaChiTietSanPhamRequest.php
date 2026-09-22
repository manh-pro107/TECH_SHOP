<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaChiTietSanPhamRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã chi tiết sản phẩm khi xóa
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:chi_tiet_san_phams,MaCTSP',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'id.required' => 'Mã chi tiết sản phẩm không được để trống',
            'id.integer'  => 'Mã chi tiết sản phẩm phải là số nguyên',
            'id.exists'   => 'Chi tiết sản phẩm không tồn tại',
        ];
    }
}