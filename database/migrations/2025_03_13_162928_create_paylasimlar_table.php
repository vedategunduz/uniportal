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
        Schema::create('paylasimlar', function (Blueprint $table) {
            $table->id('paylasimlar_id');
            $table->foreignId('kullanicilar_id')->constrained('kullanicilar', 'kullanicilar_id')->restrictOnDelete();
            $table->text('aciklama')->nullable();
            $table->boolean('yorumDurumu')->default(1);
            $table->string('kapakFotoUrl', 255)->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paylasimlar');
    }
};
