<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaDanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'MaDG' => 'required|integer|exists:danh_gias,MaDG',
            'SoSao' => 'required|integer|min:1|max:5',
            'NoiDung' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'MaDG.required' => 'Mã đánh giá không được để trống',
            'MaDG.exists' => 'Đánh giá không tồn tại',

            'SoSao.required' => 'Số sao không được để trống',
            'SoSao.min' => 'Số sao phải từ 1 đến 5',
            'SoSao.max' => 'Số sao chỉ được tối đa 5',

            'NoiDung.string' => 'Nội dung đánh giá phải là chuỗi',
        ];
    }
}