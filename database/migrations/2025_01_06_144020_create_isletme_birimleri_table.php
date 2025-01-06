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

        Schema::create('isletme_birimleri', function (Blueprint $table) {
            $table->id('isletme_birimleri_id');
            $table->unsignedBigInteger('isletmeler_id');
            $table->unsignedBigInteger('birim_tipleri_id');
            $table->string('baslik', 100);
            $table->timestamps();

            $table->foreign('isletmeler_id')->references('isletmeler_id')->on('isletmeler')->onDelete('restrict');
            $table->foreign('birim_tipleri_id')->references('birim_tipleri_id')->on('birim_tipleri')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isletme_birimleri');
    }
};
