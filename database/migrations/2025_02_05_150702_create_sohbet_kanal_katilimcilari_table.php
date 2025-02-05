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
        Schema::create('sohbet_kanal_katilimcilari', function (Blueprint $table) {
            $table->id('sohbet_kanal_katilimcilari_id');
            $table->unsignedBigInteger('sohbet_kanallari_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->timestamps();

            $table->foreign('sohbet_kanallari_id')->references('sohbet_kanallari_id')->on('sohbet_kanallari')->restrictOnDelete();
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->restrictOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sohbet_kanal_katilimcilari');
    }
};
