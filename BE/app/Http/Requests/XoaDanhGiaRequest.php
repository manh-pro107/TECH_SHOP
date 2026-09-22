<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoaDanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:danh_gias,MaDG',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Mã đánh giá không được để trống',
            'id.exists' => 'Đánh giá không tồn tại',
        ];
    }
}