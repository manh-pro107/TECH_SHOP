<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GioHangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gio_hangs')->insert([
            [
                'MaND' => 2,
                'MaSP' => 1,
                'SoLuong' => 1,
            ],
            [
                'MaND' => 2,
                'MaSP' => 16,
                'SoLuong' => 2,
            ],
            [
                'MaND' => 3,
                'MaSP' => 8,
                'SoLuong' => 1,
            ],
            [
                'MaND' => 4,
                'MaSP' => 11,
                'SoLuong' => 1,
            ],
        ]);
    }
}