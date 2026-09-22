<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gias';

    protected $primaryKey = 'MaDG';

    public $timestamps = false;

    protected $fillable = [
        'MaSP',
        'MaND',
        'SoSao',
        'NoiDung',
        'NgayDG',
    ];

    protected $casts = [
        'NgayDG' => 'datetime',
    ];
}