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
        Schema::create('kullanici_rol_iliskileri', function (Blueprint $table) {
            $table->id('kullanici_rol_iliskileri_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('roller_id');
            $table->timestamps();

            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->restrictOnDelete();
            $table->foreign('roller_id')->references('roller_id')->on('roller')->restrictOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanici_rol_iliskileri');
    }
};
