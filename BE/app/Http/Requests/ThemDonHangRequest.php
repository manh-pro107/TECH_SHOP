<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemDonHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi đặt hàng
    public function rules(): array
    {
        return [
            'MaND'                  => 'required|integer|exists:nguoi_dungs,MaND',
            'PhuongThucThanhToan'  => 'required|string|max:50',
            'MaVoucher'            => 'nullable|integer|exists:vouchers,MaVoucher',
            'TenNguoiNhan'         => 'required|string|min:2|max:100',
            'SoDienThoaiNhan'      => 'required|digits:10',
            'DiaChiGiaoHang'       => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'MaND.required' => 'Mã người dùng không được để trống',
            'MaND.integer'  => 'Mã người dùng phải là số nguyên',
            'MaND.exists'   => 'Người dùng không tồn tại',

            'PhuongThucThanhToan.required' => 'Phương thức thanh toán không được để trống',
            'PhuongThucThanhToan.string'   => 'Phương thức thanh toán phải là chuỗi ký tự',
            'PhuongThucThanhToan.max'      => 'Phương thức thanh toán không được vượt quá :max ký tự',

            'MaVoucher.integer' => 'Mã voucher phải là số nguyên',
            'MaVoucher.exists'  => 'Voucher không tồn tại',

            'TenNguoiNhan.required' => 'Tên người nhận không được để trống',
            'TenNguoiNhan.string'   => 'Tên người nhận phải là chuỗi ký tự',
            'TenNguoiNhan.min'      => 'Tên người nhận phải có ít nhất :min ký tự',
            'TenNguoiNhan.max'      => 'Tên người nhận không được vượt quá :max ký tự',

            'SoDienThoaiNhan.required' => 'Số điện thoại nhận không được để trống',
            'SoDienThoaiNhan.digits'  => 'Số điện thoại nhận phải có đúng 10 chữ số',

            'DiaChiGiaoHang.required' => 'Địa chỉ giao hàng không được để trống',
            'DiaChiGiaoHang.string'   => 'Địa chỉ giao hàng phải là chuỗi ký tự',
        ];
    }
}