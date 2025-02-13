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
        Schema::create('mesajlar', function (Blueprint $table) {
            $table->id('mesajlar_id');
            $table->foreignId('mesaj_kanallari_id')->constrained('mesaj_kanallari', 'mesaj_kanallari_id')->restrictOnDelete();
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->foreignId('alintilanan_mesajlar_id')->nullable()->constrained('mesajlar', 'mesajlar_id')->restrictOnDelete();
            $table->longText('mesaj');
            $table->enum('durum', ['düzenlendi', 'silindi', 'kaydedildi'])->default('kaydedildi');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesajlar');
    }
};
