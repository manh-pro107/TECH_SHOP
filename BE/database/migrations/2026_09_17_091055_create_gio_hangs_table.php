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
        Schema::create('gio_hangs', function (Blueprint $table) {
            $table->id('MaGH');
        
            $table->unsignedBigInteger('MaND');
            $table->unsignedBigInteger('MaSP');
        
            $table->integer('SoLuong')->default(1);
        
            $table->foreign('MaND')
                  ->references('MaND')
                  ->on('nguoi_dungs')
                  ->onDelete('cascade');
        
            $table->foreign('MaSP')
                  ->references('MaSP')
                  ->on('san_phams')
                  ->onDelete('cascade');
        
            $table->unique(['MaND', 'MaSP']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gio_hangs');
    }
};
