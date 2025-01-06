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

        Schema::create('unvanlar', function (Blueprint $table) {
            $table->id('unvanlar_id');
            $table->unsignedBigInteger('isletme_turleri_id');
            $table->integer('unvanSira')->nullable();
            $table->string('baslik');
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
        Schema::dropIfExists('unvanlar');
    }
};
