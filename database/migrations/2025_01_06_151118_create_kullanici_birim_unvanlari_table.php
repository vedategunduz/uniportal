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
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('isletme_birimleri_id');
            $table->unsignedBigInteger('unvanlar_id')->default(46);
            $table->timestamps();

            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->onDelete('restrict');
            $table->foreign('isletme_birimleri_id')->references('isletme_birimleri_id')->on('isletme_birimleri')->onDelete('restrict');
            $table->foreign('unvanlar_id')->references('unvanlar_id')->on('unvanlar')->onDelete('restrict');
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
