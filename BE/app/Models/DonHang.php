<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hangs';

    protected $primaryKey = 'MaDH';

    public $timestamps = false;

    protected $fillable = [
        'MaND',
        'NgayDat',
        'TongTien',
        'PhuongThucThanhToan',
        'TrangThaiDH',
        'MaVoucher',
        'TenNguoiNhan',
        'SoDienThoaiNhan',
        'DiaChiGiaoHang',
    ];

    protected $casts = [
        'NgayDat' => 'datetime',
        'TongTien' => 'decimal:2',
    ];
}