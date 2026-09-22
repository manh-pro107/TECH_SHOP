<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaGioHangRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi sửa giỏ hàng
    public function rules(): array
    {
        return [
            'MaGH'    => 'required|integer|exists:gio_hangs,MaGH',
            'SoLuong' => 'required|integer|min:1',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'MaGH.required'    => 'Mã giỏ hàng không được để trống',
            'MaGH.integer'     => 'Mã giỏ hàng phải là số nguyên',
            'MaGH.exists'      => 'Sản phẩm trong giỏ hàng không tồn tại',

            'SoLuong.required' => 'Số lượng không được để trống',
            'SoLuong.integer'  => 'Số lượng phải là số nguyên',
            'SoLuong.min'      => 'Số lượng phải lớn hơn 0',
        ];
    }
}