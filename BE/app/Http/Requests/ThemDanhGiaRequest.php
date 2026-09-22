<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemDanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'MaSP' => 'required|integer|exists:san_phams,MaSP',
            'MaND' => 'required|integer|exists:nguoi_dungs,MaND',
            'SoSao' => 'required|integer|min:1|max:5',
            'NoiDung' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'MaSP.required' => 'Mã sản phẩm không được để trống',
            'MaSP.exists' => 'Sản phẩm không tồn tại',

            'MaND.required' => 'Mã người dùng không được để trống',
            'MaND.exists' => 'Người dùng không tồn tại',

            'SoSao.required' => 'Số sao không được để trống',
            'SoSao.min' => 'Số sao phải từ 1 đến 5',
            'SoSao.max' => 'Số sao chỉ được tối đa 5',

            'NoiDung.string' => 'Nội dung đánh giá phải là chuỗi',
        ];
    }
}   