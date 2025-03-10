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

        Schema::create('etkinlik_katilimlari', function (Blueprint $table) {
            $table->id('etkinlik_katilimlari_id');
            $table->foreignId('etkinlikler_id')->constrained('etkinlikler', 'etkinlikler_id')->restrictOnDelete();
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->text('aciklama')->nullable();
            $table->enum('durum', ['beklemede', 'onaylandi', 'reddedildi', 'iptal']);
            $table->enum('katilimciTipi', ['davetli', 'giden', 'gidilen', 'katilimci']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etkinlik_katilimlari');
    }
};
