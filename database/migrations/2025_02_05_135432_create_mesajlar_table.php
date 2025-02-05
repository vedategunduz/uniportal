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
            $table->unsignedBigInteger('sohber_kanallari_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->text('mesaj');
            $table->enum('durum', ['düzenlendi', 'silindi', 'kaydedildi'])->default('kaydedildi');
            $table->timestamps();

            $table->foreign('sohber_kanallari_id')->references('sohber_kanallari_id')->on('sohber_kanallari')->restrictOnDelete();
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->restrictOnDelete();
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
