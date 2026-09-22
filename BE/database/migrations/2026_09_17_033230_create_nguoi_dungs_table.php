<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoi_dungs', function (Blueprint $table) {
            $table->id('MaND');
            $table->string('HoTen', 100);
            $table->string('Email', 100)->unique();
            $table->string('MatKhau', 255);
            $table->string('SoDienThoai', 20)->nullable();
            $table->text('DiaChi')->nullable();
            $table->string('Avatar', 255)->nullable();
            $table->unsignedBigInteger('MaQuyen');
            $table->string('TrangThai', 30)->default('HoatDong');

            $table->foreign('MaQuyen')
                ->references('MaQuyen')
                ->on('phan_quyens')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoi_dungs');
    }
};