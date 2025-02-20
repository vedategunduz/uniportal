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
        Schema::create('mesaj_kanal_katilimcilari', function (Blueprint $table) {
            $table->id('mesaj_kanal_katilimcilari_id');
            $table->foreignId('mesaj_kanallari_id')->constrained('mesaj_kanallari', 'mesaj_kanallari_id')->restrictOnDelete();
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->boolean('yoneticilikDurumu')->default(false);
            $table->timestamp('left_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesaj_kanal_katilimcilari');
    }
};
