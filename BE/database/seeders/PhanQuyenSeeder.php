<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhanQuyenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phan_quyens')->insert([
            [
                'MaQuyen' => 1,
                'TenQuyen' => 'Admin',
            ],
            [
                'MaQuyen' => 2,
                'TenQuyen' => 'KhachHang',
            ],
        ]);
    }
}