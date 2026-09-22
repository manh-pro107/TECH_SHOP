<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra mã voucher khi xóa
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:vouchers,MaVoucher',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Mã voucher không được để trống',
            'id.integer'  => 'Mã voucher phải là số nguyên',
            'id.exists'   => 'Voucher không tồn tại',
        ];
    }
}