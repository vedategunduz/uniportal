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
        Schema::create('mesaj_kanallari', function (Blueprint $table) {
            $table->id('mesaj_kanallari_id');
            $table->unsignedBigInteger('etkinlikler_id')->nullable();
            $table->string('baslik');
            $table->string('resim')->default('image/default_mesaj.png');
            $table->enum('tur', ['genel', 'ozel', 'bireysel', 'ziyaret', 'toplanti'])->default('genel');
            $table->boolean('sadeceYonetici')->default(false);
            $table->timestamps();

            $table->foreign('etkinlikler_id')->references('etkinlikler_id')->on('etkinlikler')->restrictOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesaj_kanallari');
    }
};
