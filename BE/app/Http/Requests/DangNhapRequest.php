<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangNhapRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Email' => 'required|email',
            'MatKhau' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'Email.required' => 'Email không được để trống',
            'Email.email' => 'Email không đúng định dạng',
            'MatKhau.required' => 'Mật khẩu không được để trống',
        ];
    }
}