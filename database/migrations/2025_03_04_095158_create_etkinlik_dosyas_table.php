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
        Schema::create('etkinlik_dosyalar', function (Blueprint $table) {
            $table->id('etkinlik_dosyalar_id');
            $table->foreignId('etkinlikler_id')->constrained('etkinlikler', 'etkinlikler_id')->restrictOnDelete();
            $table->string('dosyaAdi')->nullable();
            $table->string('dosyaYolu');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etkinlik_dosya');
    }
};
