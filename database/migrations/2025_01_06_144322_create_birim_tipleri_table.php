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

        Schema::create('birim_tipleri', function (Blueprint $table) {
            $table->id('birim_tipleri_id');
            $table->unsignedBigInteger('isletme_turleri_id');
            $table->string('baslik', 100);
            $table->timestamps();

            $table->foreign('isletme_turleri_id')->references('isletme_turleri_id')->on('isletme_turleri')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birim_tipleri');
    }
};
