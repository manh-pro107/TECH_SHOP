<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id('MaDG');

            $table->unsignedBigInteger('MaSP');
            $table->unsignedBigInteger('MaND');

            $table->tinyInteger('SoSao');

            $table->text('NoiDung')->nullable();

            $table->dateTime('NgayDG');

            $table->foreign('MaSP')
                  ->references('MaSP')
                  ->on('san_phams')
                  ->onDelete('cascade');

            $table->foreign('MaND')
                  ->references('MaND')
                  ->on('nguoi_dungs')
                  ->onDelete('cascade');

            $table->unique(['MaND', 'MaSP']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};