<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_phams';

    protected $primaryKey = 'MaSP';

    public $timestamps = false;

    protected $fillable = [
        'TenSP',
        'HinhAnh',
        'GiaBan',
        'SoLuongTon',
        'TrangThaiSP',
        'MaDM',
    ];
}
