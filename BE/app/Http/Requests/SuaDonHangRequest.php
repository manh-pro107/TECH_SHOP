<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaDonHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi cập nhật đơn hàng
    public function rules(): array
    {
        return [
            'MaDH'        => 'required|integer|exists:don_hangs,MaDH',
            'TrangThaiDH' => 'required|string|in:ChoXacNhan,DaXacNhan,DangGiao,DaGiao,DaHuy',
        ];
    }

    public function messages(): array
    {
        return [
            'MaDH.required' => 'Mã đơn hàng không được để trống',
            'MaDH.integer'  => 'Mã đơn hàng phải là số nguyên',
            'MaDH.exists'   => 'Đơn hàng không tồn tại',

            'TrangThaiDH.required' => 'Trạng thái đơn hàng không được để trống',
            'TrangThaiDH.string'   => 'Trạng thái đơn hàng phải là chuỗi ký tự',
            'TrangThaiDH.in'       => 'Trạng thái đơn hàng không hợp lệ',
        ];
    }
}