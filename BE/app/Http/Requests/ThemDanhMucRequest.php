<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ThemDanhMucRequest extends FormRequest
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
            //
            'TenDM' => 'required|string|min:2|max:100|unique:danh_mucs,TenDM',
        ];
    }
     // Thông báo lỗi bằng tiếng Việt
     public function messages(): array
     {
         return [
             'TenDM.required' => 'Tên danh mục không được để trống',
             'TenDM.string'   => 'Tên danh mục phải là chuỗi ký tự',
             'TenDM.min'      => 'Tên danh mục phải có ít nhất :min ký tự',
             'TenDM.max'      => 'Tên danh mục không được vượt quá :max ký tự',
             'TenDM.unique'   => 'Tên danh mục đã tồn tại',
         ];
     }
}
