<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamular', function (Blueprint $table) {
            $table->id('kamular_id');
            $table->string('kamu_kodu', 20)->unique();
            $table->unsignedBigInteger('iller_id')->nullable();
            $table->string('baslik', 255);
            $table->string('adres', 500);
            $table->string('website_url', 255);
            $table->string('x_url', 255);
            $table->string('instagram_url', 255);
            $table->string('linkedin_url', 255);
            $table->string('diger_url', 255);
            $table->timestamps();
        });

        Schema::create('kamular_log', function (Blueprint $table) {
            $table->id('kamular_id');
            $table->string('kamu_kodu', 20)->unique();
            $table->unsignedBigInteger('iller_id')->nullable();
            $table->string('baslik', 255);
            $table->string('adres', 500);
            $table->string('website_url', 255);
            $table->string('x_url', 255);
            $table->string('instagram_url', 255);
            $table->string('linkedin_url', 255);
            $table->string('diger_url', 255);
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER kamular_log_update
            AFTER INSERT ON kamular_log
            FOR EACH ROW
            BEGIN
                INSERT INTO kamular_log (
                    firmalar_id,
                    referans_kodu,
                    baslik,
                    email,
                    telefon,
                    adres,
                    website_url,
                    x_url,
                    instagram_url,
                    linkedin_url,
                    diger_url,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at)
                VALUES (
                    NEW.firmalar_id,
                    NEW.referans_kodu,
                    NEW.baslik,
                    NEW.email,
                    NEW.telefon,
                    NEW.website_url,
                    NEW.x_url,
                    NEW.instagram_url,
                    NEW.linkedin_url,
                    NEW.diger_url,
                    'G',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamular');
        Schema::dropIfExists('kamular_log');
    }
};
