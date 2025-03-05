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
        Schema::create('etkinlik_yorumlari', function (Blueprint $table) {
            $table->id('etkinlik_yorumlari_id');
            $table->foreignId('etkinlikler_id')->constrained('etkinlikler', 'etkinlikler_id')->onDeleteRestrict();
            $table->foreignId('yanitlanan_etkinlik_yorumlari_id')->nullable()->constrained('etkinlik_yorumlari', 'etkinlik_yorumlari_id')->onDeleteRestrict();
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->onDeleteRestrict();
            $table->text('yorum');
            $table->tinyInteger('yorum_tipi')->default(0);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etkinlik_yorumlari');
    }
};
