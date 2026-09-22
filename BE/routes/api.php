<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChiTietDonHangController;
use App\Http\Controllers\ChiTietSanPhamController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;


// =====================================================
// PUBLIC - KHÔNG CẦN ĐĂNG NHẬP
// =====================================================

// Đăng nhập khách hàng
Route::post('/client/dang-nhap', [AuthController::class, 'dangNhap']);

// Sản phẩm
Route::get('/san-pham/get-data', [SanPhamController::class, 'getData']);
Route::get('/san-pham/tim-kiem/{keyword}', [SanPhamController::class, 'search']);

// Chi tiết sản phẩm
Route::get('/chi-tiet-san-pham/get-data', [ChiTietSanPhamController::class, 'getData']);
Route::get('/chi-tiet-san-pham/get-detail/{MaSP}', [ChiTietSanPhamController::class, 'getDetail']);

// Đánh giá - ai cũng xem được
Route::get('/danh-gia/get-data/{MaSP}', [DanhGiaController::class, 'getData']);

// Chatbot
Route::post('/chatbot', [ChatbotController::class, 'chat']);


// =====================================================
// CLIENT - KHÁCH HÀNG PHẢI ĐĂNG NHẬP
// =====================================================

// Kiểm tra token
Route::get('/client/check-token', [AuthController::class, 'checkToken'])
    ->middleware('check.login');

// Đăng xuất
Route::post('/client/dang-xuat', [AuthController::class, 'dangXuat'])
    ->middleware('check.login');


// -------------------------
// Giỏ hàng
// -------------------------

Route::get('/gio-hang/get-data', [GioHangController::class, 'getData'])
    ->middleware('check.login');
    
Route::post('/gio-hang/add-data', [GioHangController::class, 'addData'])
    ->middleware('check.login');

Route::put('/gio-hang/update', [GioHangController::class, 'update'])
    ->middleware('check.login');

Route::delete('/gio-hang/delete', [GioHangController::class, 'destroy'])
    ->middleware('check.login');


// -------------------------
// Đơn hàng
// -------------------------

Route::get('/don-hang/get-data', [DonHangController::class, 'getData'])
    ->middleware('check.login');

Route::post('/don-hang/add-data', [DonHangController::class, 'addData'])
    ->middleware('check.login');

Route::put('/don-hang/update', [DonHangController::class, 'update'])
    ->middleware('check.login');

Route::delete('/don-hang/delete', [DonHangController::class, 'cancel'])
    ->middleware('check.login');


// -------------------------
// Chi tiết đơn hàng
// -------------------------

Route::get('/chi-tiet-don-hang/get-data/{MaDH}', [ChiTietDonHangController::class, 'getData'])
    ->middleware('check.login');


// -------------------------
// Đánh giá
// -------------------------

Route::post('/danh-gia/add-data', [DanhGiaController::class, 'addData'])
    ->middleware('check.login');

Route::put('/danh-gia/update', [DanhGiaController::class, 'update'])
    ->middleware('check.login');

Route::delete('/danh-gia/delete', [DanhGiaController::class, 'destroy'])
    ->middleware('check.login');


// =====================================================
// ADMIN - CHƯA DÙNG MIDDLEWARE ĐĂNG NHẬP
// =====================================================

// -------------------------
// Phân quyền
// -------------------------

Route::get('/phan-quyen/get-data', [PhanQuyenController::class, 'getData']);


// -------------------------
// Người dùng
// -------------------------

Route::get('/nguoi-dung/get-data', [NguoiDungController::class, 'getData']);

Route::post('/nguoi-dung/add-data', [NguoiDungController::class, 'addData']);

Route::put('/nguoi-dung/update', [NguoiDungController::class, 'update']);

Route::delete('/nguoi-dung/delete', [NguoiDungController::class, 'destroy']);


// -------------------------
// Danh mục
// -------------------------

Route::get('/danh-muc/get-data', [DanhMucController::class, 'getData']);

Route::post('/danh-muc/add-data', [DanhMucController::class, 'addData']);

Route::put('/danh-muc/update', [DanhMucController::class, 'update']);

Route::delete('/danh-muc/delete', [DanhMucController::class, 'destroy']);


// -------------------------
// Sản phẩm
// -------------------------

Route::post('/san-pham/add-data', [SanPhamController::class, 'addData']);

Route::put('/san-pham/update', [SanPhamController::class, 'update']);

Route::delete('/san-pham/delete', [SanPhamController::class, 'destroy']);


// -------------------------
// Chi tiết sản phẩm
// -------------------------

Route::post('/chi-tiet-san-pham/add-data', [ChiTietSanPhamController::class, 'addData']);

Route::put('/chi-tiet-san-pham/update', [ChiTietSanPhamController::class, 'update']);

Route::delete('/chi-tiet-san-pham/delete', [ChiTietSanPhamController::class, 'destroy']);


// -------------------------
// Voucher
// -------------------------

Route::get('/voucher/get-data', [VoucherController::class, 'getData']);

Route::post('/voucher/add-data', [VoucherController::class, 'addData']);

Route::put('/voucher/update', [VoucherController::class, 'update']);

Route::delete('/voucher/delete', [VoucherController::class, 'destroy']);


// -------------------------
// Quản lý đơn hàng
// -------------------------

Route::get('/admin/don-hang/get-data', [DonHangController::class, 'getData']);

Route::put('/admin/don-hang/update', [DonHangController::class, 'update']);

Route::delete('/admin/don-hang/delete', [DonHangController::class, 'cancel']);