<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class NguoiDung extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'nguoi_dungs';

    protected $primaryKey = 'MaND';

    public $timestamps = false;

    protected $fillable = [
        'HoTen',
        'Email',
        'MatKhau',
        'SoDienThoai',
        'DiaChi',
        'Avatar',
        'MaQuyen',
        'TrangThai',
    ];

    protected $hidden = [
        'MatKhau',
    ];

    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
}