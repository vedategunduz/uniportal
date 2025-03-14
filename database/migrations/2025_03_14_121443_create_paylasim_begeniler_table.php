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
        Schema::create('paylasim_begeniler', function (Blueprint $table) {
            $table->id('paylasim_begeniler_id');
            $table->foreignId('paylasimlar_id')->constrained('paylasimlar', 'paylasimlar_id')->restrictOnDelete();
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paylasim_begeniler');
    }
};
