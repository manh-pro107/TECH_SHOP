<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danh_mucs')->insert([
            [
                'MaDM' => 1,
                'TenDM' => 'Laptop',
            ],
            [
                'MaDM' => 2,
                'TenDM' => 'PC Gaming',
            ],
            [
                'MaDM' => 3,
                'TenDM' => 'Màn hình',
            ],
            [
                'MaDM' => 4,
                'TenDM' => 'Bàn phím',
            ],
            [
                'MaDM' => 5,
                'TenDM' => 'Chuột',
            ],
            [
                'MaDM' => 6,
                'TenDM' => 'Tai nghe',
            ],
            [
                'MaDM' => 7,
                'TenDM' => 'Linh kiện máy tính',
            ],
            [
                'MaDM' => 8,
                'TenDM' => 'Phụ kiện',
            ],
        ]);
    }
}