<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('MaVoucher');

            $table->string('MaGiamGia', 50)->unique();

            $table->decimal('GiaTriGiam', 5, 2);

            $table->date('NgayHetHan')->nullable();

            $table->string('TrangThai', 30)->default('DangSuDung');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};