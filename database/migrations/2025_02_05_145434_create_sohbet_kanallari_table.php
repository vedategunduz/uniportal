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
        Schema::create('sohbet_kanallari', function (Blueprint $table) {
            $table->id('sohbet_kanallari_id');
            $table->unsignedBigInteger('etkinlikler_id')->nullable();
            $table->string('baslik');
            $table->string('resim')->default(asset('image/default_mesaj.png'));
            $table->enum('tur', ['genel', 'ozel', 'ziyaret', 'toplanti'])->default('genel');
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
        Schema::dropIfExists('sohbet_kanallari');
    }
};
