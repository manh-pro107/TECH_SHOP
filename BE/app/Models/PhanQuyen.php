<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = 'phan_quyens';

    protected $primaryKey = 'MaQuyen';

    public $timestamps = false;

    protected $fillable = [
        'TenQuyen',
    ];
}