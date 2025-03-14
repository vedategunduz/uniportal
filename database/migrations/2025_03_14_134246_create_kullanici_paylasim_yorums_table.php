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
        Schema::create('paylasim_yorumlari', function (Blueprint $table) {
            $table->id('paylasim_yorumlari_id');
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id');
            $table->foreignId('paylasimlar_id')->constrained('paylasimlar', 'paylasimlar_id');
            $table->foreignId('yanitlanan_paylasim_yorum_id')->nullable()->constrained('paylasim_yorumlari', 'paylasim_yorumlari_id');
            $table->text('yorum');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paylasim_yorumlari');
    }
};
