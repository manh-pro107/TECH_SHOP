<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DonHang;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hangs';

    protected $primaryKey = 'MaCTDH';

    public $timestamps = false;

    protected $fillable = [
        'MaDH',
        'MaSP',
        'SoLuong',
        'GiaBan',
    ];

    protected $casts = [
        'GiaBan' => 'decimal:2',
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'MaDH', 'MaDH');
    }
}