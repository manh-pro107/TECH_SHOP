<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $primaryKey = 'MaVoucher';

    public $timestamps = false;

    protected $fillable = [
        'MaGiamGia',
        'GiaTriGiam',
        'NgayHetHan',
        'TrangThai',
    ];
}