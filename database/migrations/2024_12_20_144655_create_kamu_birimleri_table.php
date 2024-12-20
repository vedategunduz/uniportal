<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kamu_birimleri', function (Blueprint $table) {
            $table->id('kamu_birimleri_id');
            $table->unsignedBigInteger('kamular_id');

            $table->foreign('kamular_id')->references('kamular_id')->on('kamular')->onDelete('restrict');

            $table->string('birim_ad', 155)->nullable();
            $table->string('birim_telefon', 20)->nullable();
            $table->string('birim_email', 155)->nullable();
            $table->string('birim_website_url', 255)->nullable();
            $table->string('birim_adres', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('kamu_birimleri_log', function (Blueprint $table) {
            $table->integer('kamu_birimleri_id');
            $table->integer('kamular_id');
            $table->string('birim_ad', 155)->nullable();
            $table->string('birim_telefon', 20)->nullable();
            $table->string('birim_email', 155)->nullable();
            $table->string('birim_website_url', 255)->nullable();
            $table->string('birim_adres', 255)->nullable();
            $table->char('islem', 1);
            $table->timestamps();
        });


        DB::statement("
            CREATE TRIGGER kamu_birimleri_insert
            AFTER INSERT ON kamu_birimleri
            FOR EACH ROW
            BEGIN
                INSERT INTO kamu_birimleri_log (
                    kamu_birimleri_id,
                    kamular_id,
                    birim_ad,
                    birim_telefon,
                    birim_email,
                    birim_website_url,
                    birim_adres,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                ) VALUES (
                    NEW.kamu_birimleri_id,
                    NEW.kamular_id,
                    NEW.birim_ad,
                    NEW.birim_telefon,
                    NEW.birim_email,
                    NEW.birim_website_url,
                    NEW.birim_adres,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER kamu_birimleri_update
            AFTER UPDATE ON kamu_birimleri
            FOR EACH ROW
            BEGIN
                INSERT INTO kamu_birimleri_log (
                    kamu_birimleri_id,
                    kamular_id,
                    birim_ad,
                    birim_telefon,
                    birim_email,
                    birim_website_url,
                    birim_adres,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                ) VALUES (
                    NEW.kamu_birimleri_id,
                    NEW.kamular_id,
                    NEW.birim_ad,
                    NEW.birim_telefon,
                    NEW.birim_email,
                    NEW.birim_website_url,
                    NEW.birim_adres,
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
        DB::statement("DROP TRIGGER IF EXISTS kamu_birimleri_insert");
        DB::statement("DROP TRIGGER IF EXISTS kamu_birimleri_update");
        Schema::dropIfExists('kamu_birimleri');
        Schema::dropIfExists('kamu_birimleri_log');
    }
};
