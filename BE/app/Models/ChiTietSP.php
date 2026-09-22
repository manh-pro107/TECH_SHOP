<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietSP extends Model
{
    protected $table = 'chi_tiet_s_p_s';

    protected $primaryKey = 'MaCTSP';

    public $timestamps = false;

    protected $fillable = [
        'MaSP',
        'ThongSo',
        'MoTaChiTiet',
        'HinhAnhChiTiet',
    ];

    protected $casts = [
        'ThongSo' => 'array',
        'HinhAnhChiTiet' => 'array',
    ];
}