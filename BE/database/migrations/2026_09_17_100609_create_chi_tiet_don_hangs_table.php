<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id('MaCTDH');

            $table->unsignedBigInteger('MaDH');
            $table->unsignedBigInteger('MaSP');

            $table->integer('SoLuong');

            $table->decimal('GiaBan', 15, 2);

            $table->foreign('MaDH')
                  ->references('MaDH')
                  ->on('don_hangs')
                  ->onDelete('cascade');

            $table->foreign('MaSP')
                  ->references('MaSP')
                  ->on('san_phams')
                  ->onDelete('restrict');

            $table->unique(['MaDH', 'MaSP']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hangs');
    }
};