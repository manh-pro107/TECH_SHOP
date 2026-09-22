<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HuyDonHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã đơn hàng khi hủy
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:don_hangs,MaDH',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Mã đơn hàng không được để trống',
            'id.integer'  => 'Mã đơn hàng phải là số nguyên',
            'id.exists'   => 'Đơn hàng không tồn tại',
        ];
    }
}