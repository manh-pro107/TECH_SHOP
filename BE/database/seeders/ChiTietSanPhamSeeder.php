<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietSanPhamSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chi_tiet_s_p_s')->insert([

            // 1. ASUS TUF Gaming F15
            [
                'MaSP' => 1,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i5-12500H',
                    'RAM' => '16GB DDR4',
                    'VGA' => 'RTX 3050 4GB',
                    'O_Cung' => 'SSD 512GB',
                    'ManHinh' => '15.6 inch FHD 144Hz',
                ]),
                'MoTaChiTiet' => 'Laptop gaming ASUS TUF Gaming F15, thiết kế bền bỉ, hiệu năng tốt cho học tập và gaming.',
                'HinhAnhChiTiet' => json_encode([
                    'asus-tuf-f15-1.jpg',
                    'asus-tuf-f15-2.jpg',
                    'asus-tuf-f15-3.jpg',
                ]),
            ],

            // 2. Lenovo LOQ 15IRX9
            [
                'MaSP' => 2,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i7-13650HX',
                    'RAM' => '16GB DDR5',
                    'VGA' => 'RTX 4060 8GB',
                    'O_Cung' => 'SSD 512GB',
                    'ManHinh' => '15.6 inch FHD 144Hz',
                ]),
                'MoTaChiTiet' => 'Lenovo LOQ 15IRX9 với hiệu năng mạnh, phù hợp gaming và các tác vụ nặng.',
                'HinhAnhChiTiet' => json_encode([
                    'lenovo-loq-1.jpg',
                    'lenovo-loq-2.jpg',
                    'lenovo-loq-3.jpg',
                ]),
            ],

            // 3. Acer Nitro V 15
            [
                'MaSP' => 3,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i5-13420H',
                    'RAM' => '16GB DDR5',
                    'VGA' => 'RTX 4050 6GB',
                    'O_Cung' => 'SSD 512GB',
                    'ManHinh' => '15.6 inch FHD 144Hz',
                ]),
                'MoTaChiTiet' => 'Acer Nitro V 15 mang lại hiệu năng gaming tốt trong tầm giá.',
                'HinhAnhChiTiet' => json_encode([
                    'acer-nitro-v15-1.jpg',
                    'acer-nitro-v15-2.jpg',
                ]),
            ],

            // 4. MSI Katana 15
            [
                'MaSP' => 4,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i7-13620H',
                    'RAM' => '16GB DDR5',
                    'VGA' => 'RTX 4060 8GB',
                    'O_Cung' => 'SSD 1TB',
                    'ManHinh' => '15.6 inch FHD 144Hz',
                ]),
                'MoTaChiTiet' => 'MSI Katana 15 gaming với hiệu năng mạnh và thiết kế đậm chất game thủ.',
                'HinhAnhChiTiet' => json_encode([
                    'msi-katana-1.jpg',
                    'msi-katana-2.jpg',
                    'msi-katana-3.jpg',
                ]),
            ],

            // 5. Dell G15 Gaming
            [
                'MaSP' => 5,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i7-13650HX',
                    'RAM' => '16GB DDR5',
                    'VGA' => 'RTX 4060 8GB',
                    'O_Cung' => 'SSD 1TB',
                    'ManHinh' => '15.6 inch FHD 165Hz',
                ]),
                'MoTaChiTiet' => 'Dell G15 Gaming có thiết kế chắc chắn và hiệu năng cao.',
                'HinhAnhChiTiet' => json_encode([
                    'dell-g15-1.jpg',
                    'dell-g15-2.jpg',
                ]),
            ],

            // 6. HP Victus 15
            [
                'MaSP' => 6,
                'ThongSo' => json_encode([
                    'CPU' => 'AMD Ryzen 5 7535HS',
                    'RAM' => '16GB DDR5',
                    'VGA' => 'RTX 4050 6GB',
                    'O_Cung' => 'SSD 512GB',
                    'ManHinh' => '15.6 inch FHD 144Hz',
                ]),
                'MoTaChiTiet' => 'HP Victus 15 cân bằng giữa hiệu năng, thiết kế và giá thành.',
                'HinhAnhChiTiet' => json_encode([
                    'hp-victus-1.jpg',
                    'hp-victus-2.jpg',
                ]),
            ],

            // 7. Acer Predator Helios Neo 16
            [
                'MaSP' => 7,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i9-14900HX',
                    'RAM' => '32GB DDR5',
                    'VGA' => 'RTX 4070 8GB',
                    'O_Cung' => 'SSD 1TB',
                    'ManHinh' => '16 inch WQXGA 240Hz',
                ]),
                'MoTaChiTiet' => 'Laptop gaming cao cấp Acer Predator dành cho gaming và công việc đồ họa.',
                'HinhAnhChiTiet' => json_encode([
                    'predator-neo16-1.jpg',
                    'predator-neo16-2.jpg',
                    'predator-neo16-3.jpg',
                ]),
            ],

            // 8. PC Gaming Ryzen 5 RTX 4060
            [
                'MaSP' => 8,
                'ThongSo' => json_encode([
                    'CPU' => 'AMD Ryzen 5 5600',
                    'RAM' => '16GB DDR4',
                    'VGA' => 'RTX 4060 8GB',
                    'O_Cung' => 'SSD NVMe 500GB',
                ]),
                'MoTaChiTiet' => 'PC Gaming Ryzen 5 phù hợp chơi game Full HD và sử dụng hàng ngày.',
                'HinhAnhChiTiet' => json_encode([
                    'pc-ryzen5-1.jpg',
                    'pc-ryzen5-2.jpg',
                ]),
            ],

            // 9. PC Gaming Core i5 RTX 4060
            [
                'MaSP' => 9,
                'ThongSo' => json_encode([
                    'CPU' => 'Intel Core i5-12400F',
                    'RAM' => '16GB DDR4',
                    'VGA' => 'RTX 4060 8GB',
                    'O_Cung' => 'SSD NVMe 1TB',
                ]),
                'MoTaChiTiet' => 'PC Gaming Core i5 với hiệu năng ổn định cho gaming.',
                'HinhAnhChiTiet' => json_encode([
                    'pc-i5-1.jpg',
                    'pc-i5-2.jpg',
                ]),
            ],

            // 10. PC Gaming Ryzen 7 RTX 4070
            [
                'MaSP' => 10,
                'ThongSo' => json_encode([
                    'CPU' => 'AMD Ryzen 7 7800X3D',
                    'RAM' => '32GB DDR5',
                    'VGA' => 'RTX 4070 12GB',
                    'O_Cung' => 'SSD NVMe 1TB',
                ]),
                'MoTaChiTiet' => 'PC Gaming cao cấp dành cho game thủ cần hiệu năng mạnh.',
                'HinhAnhChiTiet' => json_encode([
                    'pc-ryzen7-1.jpg',
                    'pc-ryzen7-2.jpg',
                ]),
            ],

            // 11. LG UltraGear 24GN60R
            [
                'MaSP' => 11,
                'ThongSo' => json_encode([
                    'KichThuoc' => '24 inch',
                    'DoPhanGiai' => '1920x1080',
                    'TanSoQuet' => '144Hz',
                    'TamNen' => 'IPS',
                    'ThoiGianDapUng' => '1ms',
                ]),
                'MoTaChiTiet' => 'Màn hình LG UltraGear 24 inch dành cho gaming.',
                'HinhAnhChiTiet' => json_encode([
                    'lg-ultragear-1.jpg',
                    'lg-ultragear-2.jpg',
                ]),
            ],

            // 12. AOC Gaming 24G2
            [
                'MaSP' => 12,
                'ThongSo' => json_encode([
                    'KichThuoc' => '24 inch',
                    'DoPhanGiai' => '1920x1080',
                    'TanSoQuet' => '144Hz',
                    'TamNen' => 'IPS',
                    'ThoiGianDapUng' => '1ms',
                ]),
                'MoTaChiTiet' => 'Màn hình AOC Gaming với tần số quét cao và thời gian phản hồi nhanh.',
                'HinhAnhChiTiet' => json_encode([
                    'aoc-24g2-1.jpg',
                    'aoc-24g2-2.jpg',
                ]),
            ],

            // 13. Samsung Odyssey G5 27
            [
                'MaSP' => 13,
                'ThongSo' => json_encode([
                    'KichThuoc' => '27 inch',
                    'DoPhanGiai' => '2560x1440',
                    'TanSoQuet' => '165Hz',
                    'TamNen' => 'VA',
                    'ThoiGianDapUng' => '1ms',
                ]),
                'MoTaChiTiet' => 'Samsung Odyssey G5 27 inch độ phân giải 2K, phù hợp gaming.',
                'HinhAnhChiTiet' => json_encode([
                    'samsung-g5-1.jpg',
                    'samsung-g5-2.jpg',
                ]),
            ],

            // 14. AULA F75 Pro
            [
                'MaSP' => 14,
                'ThongSo' => json_encode([
                    'Loai' => 'Bàn phím cơ',
                    'Switch' => 'Red Switch',
                    'KetNoi' => 'USB-C',
                    'Layout' => '75%',
                    'DenNen' => 'RGB',
                ]),
                'MoTaChiTiet' => 'Bàn phím cơ AULA F75 Pro nhỏ gọn, phù hợp gaming và làm việc.',
                'HinhAnhChiTiet' => json_encode([
                    'aula-f75-1.jpg',
                    'aula-f75-2.jpg',
                ]),
            ],

            // 15. Keychron K2 Pro
            [
                'MaSP' => 15,
                'ThongSo' => json_encode([
                    'Loai' => 'Bàn phím cơ',
                    'Switch' => 'K Pro Red',
                    'KetNoi' => 'USB-C / Bluetooth',
                    'Layout' => '75%',
                    'DenNen' => 'RGB',
                ]),
                'MoTaChiTiet' => 'Keychron K2 Pro hỗ trợ kết nối có dây và Bluetooth.',
                'HinhAnhChiTiet' => json_encode([
                    'keychron-k2-1.jpg',
                    'keychron-k2-2.jpg',
                ]),
            ],

            // 16. Logitech G102 Lightsync
            [
                'MaSP' => 16,
                'ThongSo' => json_encode([
                    'DPI' => '8000 DPI',
                    'KetNoi' => 'USB',
                    'SoNut' => '6',
                    'TrongLuong' => '85g',
                ]),
                'MoTaChiTiet' => 'Chuột gaming Logitech G102 thiết kế nhỏ gọn, phù hợp nhiều nhu cầu.',
                'HinhAnhChiTiet' => json_encode([
                    'g102-1.jpg',
                    'g102-2.jpg',
                ]),
            ],

            // 17. Razer DeathAdder Essential
            [
                'MaSP' => 17,
                'ThongSo' => json_encode([
                    'DPI' => '6400 DPI',
                    'KetNoi' => 'USB',
                    'SoNut' => '5',
                    'TrongLuong' => '96g',
                ]),
                'MoTaChiTiet' => 'Chuột gaming Razer DeathAdder Essential với thiết kế công thái học.',
                'HinhAnhChiTiet' => json_encode([
                    'razer-deathadder-1.jpg',
                    'razer-deathadder-2.jpg',
                ]),
            ],

            // 18. HyperX Cloud III
            [
                'MaSP' => 18,
                'ThongSo' => json_encode([
                    'Loai' => 'Tai nghe chụp tai',
                    'KetNoi' => 'USB / 3.5mm',
                    'Micro' => 'Có',
                    'AmThanh' => '7.1 Surround',
                ]),
                'MoTaChiTiet' => 'Tai nghe gaming HyperX Cloud III cho âm thanh rõ ràng và thoải mái khi sử dụng.',
                'HinhAnhChiTiet' => json_encode([
                    'hyperx-cloud3-1.jpg',
                    'hyperx-cloud3-2.jpg',
                ]),
            ],

            // 19. Kingston Fury Beast 16GB DDR5
            [
                'MaSP' => 19,
                'ThongSo' => json_encode([
                    'DungLuong' => '16GB',
                    'Loai' => 'DDR5',
                    'Bus' => '5600MHz',
                    'Kit' => '1 thanh',
                ]),
                'MoTaChiTiet' => 'RAM Kingston Fury Beast DDR5 16GB dành cho PC gaming và làm việc.',
                'HinhAnhChiTiet' => json_encode([
                    'kingston-fury-1.jpg',
                    'kingston-fury-2.jpg',
                ]),
            ],

            // 20. SSD Samsung 990 EVO 1TB
            [
                'MaSP' => 20,
                'ThongSo' => json_encode([
                    'DungLuong' => '1TB',
                    'Chuan' => 'NVMe',
                    'GiaoTiep' => 'PCIe',
                    'TocDoDoc' => '5000MB/s',
                    'TocDoGhi' => '4200MB/s',
                ]),
                'MoTaChiTiet' => 'SSD Samsung 990 EVO 1TB tốc độ cao, phù hợp nâng cấp máy tính.',
                'HinhAnhChiTiet' => json_encode([
                    'samsung-990-evo-1.jpg',
                    'samsung-990-evo-2.jpg',
                ]),
            ],
        ]);
    }
}