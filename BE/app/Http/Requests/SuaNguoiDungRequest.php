<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaNguoiDungRequest extends FormRequest
{
    // Cho phép thực hiện request
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu khi sửa người dùng
    public function rules(): array
    {
        return [
            'HoTen'       => 'required|string|min:2|max:100',
            'Email'       => 'required|email|max:100|unique:nguoi_dungs,Email,' . $this->route('id') . ',MaND',
            'MatKhau'     => 'nullable|string|min:6|max:255',
            'SoDienThoai' => 'nullable|digits:10',
            'DiaChi'      => 'nullable|string',
            'Avatar'      => 'nullable|string|max:255',
            'MaQuyen'     => 'required|integer|exists:phan_quyens,MaQuyen',
            'TrangThai'   => 'nullable|string|max:30',
        ];
    }

    // Thông báo lỗi bằng tiếng Việt
    public function messages(): array
    {
        return [
            'HoTen.required' => 'Họ và tên không được để trống',
            'HoTen.string'   => 'Họ và tên phải là chuỗi ký tự',
            'HoTen.min'      => 'Họ và tên phải có ít nhất :min ký tự',
            'HoTen.max'      => 'Họ và tên không được vượt quá :max ký tự',

            'Email.required' => 'Email không được để trống',
            'Email.email'    => 'Email không đúng định dạng',
            'Email.max'      => 'Email không được vượt quá :max ký tự',
            'Email.unique'   => 'Email đã tồn tại',

            'MatKhau.string' => 'Mật khẩu phải là chuỗi ký tự',
            'MatKhau.min'    => 'Mật khẩu phải có ít nhất :min ký tự',
            'MatKhau.max'    => 'Mật khẩu không được vượt quá :max ký tự',

            'SoDienThoai.digits' => 'Số điện thoại phải có đúng 10 chữ số',

            'DiaChi.string' => 'Địa chỉ phải là chuỗi ký tự',

            'Avatar.string' => 'Avatar phải là chuỗi ký tự',
            'Avatar.max'    => 'Avatar không được vượt quá :max ký tự',

            'MaQuyen.required' => 'Mã quyền không được để trống',
            'MaQuyen.integer'  => 'Mã quyền phải là số nguyên',
            'MaQuyen.exists'   => 'Mã quyền không tồn tại',

            'TrangThai.string' => 'Trạng thái phải là chuỗi ký tự',
            'TrangThai.max'    => 'Trạng thái không được vượt quá :max ký tự',
        ];
    }
}