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
        Schema::create('mesaj_detaylari', function (Blueprint $table) {
            $table->id('mesaj_detaylari_id');
            $table->foreignId('mesajlar_id')->constrained('mesajlar', 'mesajlar_id')->onDeleteRestrict();
            $table->foreignId('emoji_tipleri_id')->constrained('emoji_tipleri', 'emoji_tipleri_id')->onDeleteRestrict();
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->onDeleteRestrict();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesaj_detaylari');
    }
};
