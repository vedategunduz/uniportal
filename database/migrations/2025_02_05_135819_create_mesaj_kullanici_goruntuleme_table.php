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
        Schema::create('mesaj_kullanici_goruntuleme', function (Blueprint $table) {
            $table->id('mesaj_kullanici_goruntuleme_id');
            $table->unsignedBigInteger('mesajlar_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('mesaj_kanallari_id');
            $table->timestamps();

            $table->foreign('mesajlar_id')->references('mesajlar_id')->on('mesajlar')->restrictOnDelete();
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->restrictOnDelete();
            $table->foreign('mesaj_kanallari_id')->references('mesaj_kanallari_id')->on('mesaj_kanallari')->restrictOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesaj_kullanici_goruntuleme');
    }
};
