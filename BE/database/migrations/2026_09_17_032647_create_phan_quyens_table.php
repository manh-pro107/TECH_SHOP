<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phan_quyens', function (Blueprint $table) {
            $table->id('MaQuyen');
            $table->string('TenQuyen', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phan_quyens');
    }
};