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
        Schema::create('chi_tiet_s_p_s', function (Blueprint $table) {
            $table->id('MaCTSP');
        
            $table->unsignedBigInteger('MaSP')->unique();
        
            $table->json('ThongSo')->nullable();
        
            $table->text('MoTaChiTiet')->nullable();
        
            $table->json('HinhAnhChiTiet')->nullable();
        
            $table->foreign('MaSP')
                  ->references('MaSP')
                  ->on('san_phams')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_s_p_s');
    }
};
