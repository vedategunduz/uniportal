<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('etkinlikler', function (Blueprint $table) {
            $table->id('etkinlikler_id');
            $table->foreignId('etkinlik_turleri_id')->constrained('etkinlik_turleri', 'etkinlik_turleri_id')->restrictOnDelete();
            $table->foreignId('isletmeler_id')->constrained('isletmeler', 'isletmeler_id')->restrictOnDelete();
            $table->foreignId('iller_id')->nullable()->constrained('iller', 'iller_id')->restrictOnDelete();
            $table->foreignId('giden_isletmeler_id')->nullable()->constrained('isletmeler', 'isletmeler_id')->restrictOnDelete();
            $table->foreignId('gidilen_isletmeler_id')->nullable()->constrained('isletmeler', 'isletmeler_id')->restrictOnDelete();
            $table->string('kod')->nullable()->default(uniqid());
            $table->integer('kontenjan')->nullable();
            $table->timestamp('etkinlikBasvuruTarihi')->nullable();
            $table->timestamp('etkinlikBasvuruBitisTarihi')->nullable();
            $table->timestamp('etkinlikBaslamaTarihi')->nullable();
            $table->timestamp('etkinlikBitisTarihi')->nullable();
            $table->string('kapakResmiYolu')->nullable()->default('image/etkinlikresim.png');
            $table->string('baslik', 255)->nullable();
            $table->enum('katilimTipi', ['genel', 'uniportal', 'özel'])->default('genel');
            $table->text('aciklama')->nullable();
            $table->string('harita', 1000)->nullable();
            $table->integer('goruntulenmeSayisi')->nullable()->default(0);
            $table->text('katilimSarti')->nullable();
            $table->boolean('sosyalMedyadaPaylas', 1)->nullable()->default(1);
            $table->boolean('yorumDurumu')->nullable()->default(1);
            $table->boolean('mailDurumu')->nullable()->default(1);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etkinlikler');
    }
};
