<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaSanPhamRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi sửa sản phẩm
    public function rules(): array
    {
        return [
            'MaSP'        => 'required|integer|exists:san_phams,MaSP',
            'TenSP'       => 'required|string|max:255',
            'HinhAnh'     => 'nullable|string|max:255',
            'GiaBan'      => 'required|numeric|min:0',
            'SoLuongTon'  => 'required|integer|min:0',
            'TrangThaiSP' => 'nullable|string|max:30',
            'MaDM'        => 'required|integer|exists:danh_mucs,MaDM',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'MaSP.required'       => 'Mã sản phẩm không được để trống',
            'MaSP.integer'        => 'Mã sản phẩm phải là số nguyên',
            'MaSP.exists'         => 'Sản phẩm không tồn tại',

            'TenSP.required'      => 'Tên sản phẩm không được để trống',
            'TenSP.string'        => 'Tên sản phẩm phải là chuỗi ký tự',
            'TenSP.max'           => 'Tên sản phẩm không được vượt quá :max ký tự',

            'HinhAnh.string'      => 'Hình ảnh phải là chuỗi ký tự',
            'HinhAnh.max'         => 'Hình ảnh không được vượt quá :max ký tự',

            'GiaBan.required'     => 'Giá bán không được để trống',
            'GiaBan.numeric'      => 'Giá bán phải là số',
            'GiaBan.min'          => 'Giá bán không được nhỏ hơn 0',

            'SoLuongTon.required' => 'Số lượng tồn không được để trống',
            'SoLuongTon.integer'  => 'Số lượng tồn phải là số nguyên',
            'SoLuongTon.min'      => 'Số lượng tồn không được nhỏ hơn 0',

            'TrangThaiSP.string'  => 'Trạng thái sản phẩm phải là chuỗi ký tự',
            'TrangThaiSP.max'     => 'Trạng thái sản phẩm không được vượt quá :max ký tự',

            'MaDM.required'       => 'Mã danh mục không được để trống',
            'MaDM.integer'        => 'Mã danh mục phải là số nguyên',
            'MaDM.exists'         => 'Danh mục không tồn tại',
        ];
    }
}