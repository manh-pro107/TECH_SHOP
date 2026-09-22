<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SanPhamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'TenSP' => 'required|string|max:255',
            'HinhAnh' => 'nullable|string|max:255',
            'GiaBan' => 'required|numeric|min:0',
            'SoLuongTon' => 'required|integer|min:0',
            'TrangThaiSP' => 'nullable|string|max:30',
            'MaDM' => 'required|integer|exists:danh_mucs,MaDM',
        ];
    }
}
