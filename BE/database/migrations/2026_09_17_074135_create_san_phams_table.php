<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id('MaSP');
            $table->string('TenSP', 255);
            $table->string('HinhAnh', 255)->nullable();
            $table->decimal('GiaBan', 15, 2);
            $table->integer('SoLuongTon')->default(0);
            $table->string('TrangThaiSP', 30)->default('DangBan');
        
            $table->unsignedBigInteger('MaDM');
        
            $table->foreign('MaDM')
                  ->references('MaDM')
                  ->on('danh_mucs')
                  ->onDelete('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
