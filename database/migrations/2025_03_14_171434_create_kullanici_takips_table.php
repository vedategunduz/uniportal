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
        Schema::disableForeignKeyConstraints();
        Schema::create('kullanici_takip', function (Blueprint $table) {
            $table->id('kullanici_takip_id');
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->foreignId('takip_eden_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->boolean('durum')->default(1);
            $table->unique(['kullanicilar_id', 'takip_eden_id']);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanici_takip');
    }
};
