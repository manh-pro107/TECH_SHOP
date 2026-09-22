<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nguoi_dungs')->insert([
            [
                'HoTen' => 'Mạnh CR7',
                'Email' => 'manhcr7@gmail.com',
                'MatKhau' => Hash::make('123456'),
                'SoDienThoai' => '0905000001',
                'DiaChi' => 'Đà Nẵng',
                'Avatar' => null,
                'MaQuyen' => 1,
                'TrangThai' => 'HoatDong',
            ],
            [
                'HoTen' => 'Nguyễn Văn An',
                'Email' => 'nguyenvanan@gmail.com',
                'MatKhau' => Hash::make('123456'),
                'SoDienThoai' => '0905000002',
                'DiaChi' => 'Đà Nẵng',
                'Avatar' => null,
                'MaQuyen' => 2,
                'TrangThai' => 'HoatDong',
            ],
            [
                'HoTen' => 'Trần Minh Khoa',
                'Email' => 'tranminhkhoa@gmail.com',
                'MatKhau' => Hash::make('123456'),
                'SoDienThoai' => '0905000003',
                'DiaChi' => 'Huế',
                'Avatar' => null,
                'MaQuyen' => 2,
                'TrangThai' => 'HoatDong',
            ],
            [
                'HoTen' => 'Trần cccc',
                'Email' => 'tranminhkhfsdfsdoa@gmail.com',
                'MatKhau' => Hash::make('123456'),
                'SoDienThoai' => '0905320403',
                'DiaChi' => 'Ống cống',
                'Avatar' => null,
                'MaQuyen' => 2,
                'TrangThai' => 'HoatDong',
            ],
        ]);
    }
}