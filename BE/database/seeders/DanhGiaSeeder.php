<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhGiaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danh_gias')->insert([
            [
                'MaSP' => 1,
                'MaND' => 2,
                'SoSao' => 5,
                'NoiDung' => 'Máy chạy rất tốt, hiệu năng ổn trong tầm giá.',
                'NgayDG' => '2026-09-10 10:00:00',
            ],
            [
                'MaSP' => 1,
                'MaND' => 3,
                'SoSao' => 4,
                'NoiDung' => 'Thiết kế đẹp, chơi game khá mượt.',
                'NgayDG' => '2026-09-11 14:30:00',
            ],
            [
                'MaSP' => 16,
                'MaND' => 2,
                'SoSao' => 5,
                'NoiDung' => 'Chuột dùng tốt, cầm khá vừa tay.',
                'NgayDG' => '2026-09-12 09:15:00',
            ],
            [
                'MaSP' => 11,
                'MaND' => 4,
                'SoSao' => 4,
                'NoiDung' => 'Màn hình đẹp, 144Hz dùng rất ổn.',
                'NgayDG' => '2026-09-13 16:00:00',
            ],
            [
                'MaSP' => 18,
                'MaND' => 3,
                'SoSao' => 5,
                'NoiDung' => 'Âm thanh tốt, đeo lâu khá thoải mái.',
                'NgayDG' => '2026-09-14 20:00:00',
            ],
        ]);
    }
}