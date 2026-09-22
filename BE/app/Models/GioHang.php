<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SanPham;

class GioHang extends Model
{
    protected $table = 'gio_hangs';
    protected $primaryKey = 'MaGH';
    public $timestamps = false;

    protected $fillable = [
        'MaND',
        'MaSP',
        'SoLuong',
    ];

    // Liên kết giỏ hàng với sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSP', 'MaSP');
    }
}