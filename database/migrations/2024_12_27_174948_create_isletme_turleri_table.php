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
        Schema::create('isletme_turleri', function (Blueprint $table) {
            $table->id('isletme_turleri_id');
            $table->string('baslik', 55);
            $table->timestamps();
        });

        Schema::create('isletme_turleri_log', function (Blueprint $table) {
            $table->integer('isletme_turleri_id');
            $table->string('baslik', 55);
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isletme_turleri');
    }
};
