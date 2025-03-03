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
        Schema::create('iletisim_form_dosya', function (Blueprint $table) {
            $table->id('iletisim_form_dosya_id');
            $table->foreignId('iletisim_form_id')->constrained('iletisim_form', 'iletisim_form_id')->restrictOnDelete();
            $table->string('dosya_adi');
            $table->string('dosya_yolu');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iletisim_form_dosya');
    }
};
