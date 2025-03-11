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

        Schema::create('kullanici_birim_unvan_iliskileri', function (Blueprint $table) {
            $table->id('kullanici_birim_unvan_iliskileri_id');
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->foreignId('isletmeler_id')->constrained('isletmeler', 'isletmeler_id')->restrictOnDelete();
            $table->foreignId('isletme_birimleri_id')->constrained('isletme_birimleri', 'isletme_birimleri_id')->restrictOnDelete();
            $table->foreignId('unvanlar_id')->default(46)->constrained('unvanlar', 'unvanlar_id')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanici_birim_unvanlari');
    }
};
