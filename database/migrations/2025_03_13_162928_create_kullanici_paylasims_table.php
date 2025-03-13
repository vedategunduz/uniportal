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
        Schema::create('kullanici_paylasimlar', function (Blueprint $table) {
            $table->id('kullanici_paylasimlar_id');
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->text('aciklama')->nullable();
            $table->string('kapak_foto_url', 255)->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanici_paylasimlar');
    }
};
