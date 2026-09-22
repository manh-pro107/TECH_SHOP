<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi thêm voucher
    public function rules(): array
    {
        return [
            'MaGiamGia'  => 'required|string|max:50|unique:vouchers,MaGiamGia',
            'GiaTriGiam' => 'required|numeric|min:0|max:100',
            'NgayHetHan' => 'nullable|date',
            'TrangThai'  => 'nullable|string|max:30',
        ];
    }

    public function messages(): array
    {
        return [
            'MaGiamGia.required' => 'Mã giảm giá không được để trống',
            'MaGiamGia.string'   => 'Mã giảm giá phải là chuỗi ký tự',
            'MaGiamGia.max'      => 'Mã giảm giá không được vượt quá :max ký tự',
            'MaGiamGia.unique'   => 'Mã giảm giá đã tồn tại',

            'GiaTriGiam.required' => 'Giá trị giảm không được để trống',
            'GiaTriGiam.numeric'  => 'Giá trị giảm phải là số',
            'GiaTriGiam.min'      => 'Giá trị giảm không được nhỏ hơn 0',
            'GiaTriGiam.max'      => 'Giá trị giảm không được lớn hơn 100',

            'NgayHetHan.date' => 'Ngày hết hạn không đúng định dạng',

            'TrangThai.string' => 'Trạng thái phải là chuỗi ký tự',
            'TrangThai.max'    => 'Trạng thái không được vượt quá :max ký tự',
        ];
    }
}