<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id('MaDH');

            $table->unsignedBigInteger('MaND');

            $table->dateTime('NgayDat');

            $table->decimal('TongTien', 15, 2)->default(0);

            $table->string('PhuongThucThanhToan', 50);

            $table->string('TrangThaiDH', 30)->default('ChoXacNhan');

            $table->unsignedBigInteger('MaVoucher')->nullable();

            $table->string('TenNguoiNhan', 100);

            $table->string('SoDienThoaiNhan', 20);

            $table->text('DiaChiGiaoHang');

            $table->foreign('MaND')
                  ->references('MaND')
                  ->on('nguoi_dungs')
                  ->onDelete('restrict');

            $table->foreign('MaVoucher')
                  ->references('MaVoucher')
                  ->on('vouchers')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};