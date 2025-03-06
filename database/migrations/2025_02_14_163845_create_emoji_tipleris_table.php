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
        Schema::create('emoji_tipleri', function (Blueprint $table) {
            $table->id('emoji_tipleri_id');
            $table->string('baslik')->nullable();
            $table->text('url')->nullable();
            $table->unsignedBigInteger('grup_id')->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emoji_tipleri');
    }
};
