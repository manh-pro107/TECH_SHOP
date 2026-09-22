<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'MaGiamGia' => 'CR7LAGOAT',
                'GiaTriGiam' => 30.00,
                'NgayHetHan' => '2026-12-31',
                'TrangThai' => 'DangSuDung',
            ],
            [
                'MaGiamGia' => 'MANHOYES',
                'GiaTriGiam' => 15.00,
                'NgayHetHan' => '2026-11-30',
                'TrangThai' => 'DangSuDung',
            ],
            [
                'MaGiamGia' => 'SHOPTECH1212',
                'GiaTriGiam' => 20.00,
                'NgayHetHan' => '2026-10-31',
                'TrangThai' => 'DangSuDung',
            ],
            [
                'MaGiamGia' => 'SALE5',
                'GiaTriGiam' => 5.00,
                'NgayHetHan' => '2026-12-15',
                'TrangThai' => 'DangSuDung',
            ],
            [
                'MaGiamGia' => 'WELCOME10',
                'GiaTriGiam' => 10.00,
                'NgayHetHan' => '2027-01-31',
                'TrangThai' => 'DangSuDung',
            ],
        ]);
    }
}