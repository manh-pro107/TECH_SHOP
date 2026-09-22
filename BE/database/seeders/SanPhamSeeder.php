<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SanPhamSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('san_phams')->insert([
            [
                'MaSP' => 1,
                'TenSP' => 'ASUS TUF Gaming F15',
                'HinhAnh' => 'asus-tuf-f15.jpg',
                'GiaBan' => 18990000,
                'SoLuongTon' => 10,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],
            [
                'MaSP' => 2,
                'TenSP' => 'Lenovo LOQ 15IRX9',
                'HinhAnh' => 'lenovo-loq-15.jpg',
                'GiaBan' => 22990000,
                'SoLuongTon' => 8,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],
            [
                'MaSP' => 3,
                'TenSP' => 'Acer Nitro V 15',
                'HinhAnh' => 'acer-nitro-v15.jpg',
                'GiaBan' => 19990000,
                'SoLuongTon' => 7,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],
            [
                'MaSP' => 4,
                'TenSP' => 'MSI Katana 15',
                'HinhAnh' => 'msi-katana-15.jpg',
                'GiaBan' => 21990000,
                'SoLuongTon' => 6,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],
            [
                'MaSP' => 5,
                'TenSP' => 'Dell G15 Gaming',
                'HinhAnh' => 'dell-g15.jpg',
                'GiaBan' => 23990000,
                'SoLuongTon' => 5,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],
            [
                'MaSP' => 6,
                'TenSP' => 'HP Victus 15',
                'HinhAnh' => 'hp-victus-15.jpg',
                'GiaBan' => 17990000,
                'SoLuongTon' => 9,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],
            [
                'MaSP' => 7,
                'TenSP' => 'Acer Predator Helios Neo 16',
                'HinhAnh' => 'acer-predator-neo16.jpg',
                'GiaBan' => 32990000,
                'SoLuongTon' => 3,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 1,
            ],

            [
                'MaSP' => 8,
                'TenSP' => 'PC Gaming Ryzen 5 RTX 4060',
                'HinhAnh' => 'pc-ryzen5-rtx4060.jpg',
                'GiaBan' => 24990000,
                'SoLuongTon' => 5,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 2,
            ],
            [
                'MaSP' => 9,
                'TenSP' => 'PC Gaming Core i5 RTX 4060',
                'HinhAnh' => 'pc-i5-rtx4060.jpg',
                'GiaBan' => 26990000,
                'SoLuongTon' => 4,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 2,
            ],
            [
                'MaSP' => 10,
                'TenSP' => 'PC Gaming Ryzen 7 RTX 4070',
                'HinhAnh' => 'pc-ryzen7-rtx4070.jpg',
                'GiaBan' => 38990000,
                'SoLuongTon' => 2,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 2,
            ],

            [
                'MaSP' => 11,
                'TenSP' => 'LG UltraGear 24GN60R',
                'HinhAnh' => 'lg-ultragear-24.jpg',
                'GiaBan' => 3990000,
                'SoLuongTon' => 12,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 3,
            ],
            [
                'MaSP' => 12,
                'TenSP' => 'AOC Gaming 24G2',
                'HinhAnh' => 'aoc-24g2.jpg',
                'GiaBan' => 4290000,
                'SoLuongTon' => 9,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 3,
            ],
            [
                'MaSP' => 13,
                'TenSP' => 'Samsung Odyssey G5 27',
                'HinhAnh' => 'samsung-odyssey-g5.jpg',
                'GiaBan' => 6990000,
                'SoLuongTon' => 0,
                'TrangThaiSP' => 'HetHang',
                'MaDM' => 3,
            ],

            [
                'MaSP' => 14,
                'TenSP' => 'AULA F75 Pro',
                'HinhAnh' => 'aula-f75.jpg',
                'GiaBan' => 1290000,
                'SoLuongTon' => 15,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 4,
            ],
            [
                'MaSP' => 15,
                'TenSP' => 'Keychron K2 Pro',
                'HinhAnh' => 'keychron-k2-pro.jpg',
                'GiaBan' => 2190000,
                'SoLuongTon' => 8,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 4,
            ],

            [
                'MaSP' => 16,
                'TenSP' => 'Logitech G102 Lightsync',
                'HinhAnh' => 'logitech-g102.jpg',
                'GiaBan' => 499000,
                'SoLuongTon' => 20,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 5,
            ],
            [
                'MaSP' => 17,
                'TenSP' => 'Razer DeathAdder Essential',
                'HinhAnh' => 'razer-deathadder.jpg',
                'GiaBan' => 690000,
                'SoLuongTon' => 14,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 5,
            ],

            [
                'MaSP' => 18,
                'TenSP' => 'HyperX Cloud III',
                'HinhAnh' => 'hyperx-cloud3.jpg',
                'GiaBan' => 2390000,
                'SoLuongTon' => 10,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 6,
            ],

            [
                'MaSP' => 19,
                'TenSP' => 'Kingston Fury Beast 16GB DDR5',
                'HinhAnh' => 'kingston-fury-16gb.jpg',
                'GiaBan' => 1490000,
                'SoLuongTon' => 18,
                'TrangThaiSP' => 'DangBan',
                'MaDM' => 7,
            ],
            [
                'MaSP' => 20,
                'TenSP' => 'SSD Samsung 990 EVO 1TB',
                'HinhAnh' => 'ssd-samsung-990-evo.jpg',
                'GiaBan' => 2290000,
                'SoLuongTon' => 0,
                'TrangThaiSP' => 'HetHang',
                'MaDM' => 7,
            ],
        ]);
    }
}