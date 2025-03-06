<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('isletmeler', function (Blueprint $table) {
            $table->id('isletmeler_id');
            $table->unsignedBigInteger('isletme_turleri_id');
            $table->unsignedBigInteger('iller_id')->nullable();
            $table->string('referans_kodu', 20)->unique()->nullable();
            $table->string('referans', 20)->nullable();
            $table->string('baslik', 255)->nullable();
            $table->string('adres', 500)->nullable();
            $table->string('kisaltma', 10)->nullable();
            $table->string('mailUzanti', 50)->nullable();
            $table->string('vectorelLogoUrl', 500)->nullable();
            $table->string('logoUrl', 500)->nullable();
            $table->string('websiteUrl', 255)->nullable();
            $table->string('xUrl', 255)->nullable();
            $table->string('instagramUrl', 255)->nullable();
            $table->string('linkedinUrl', 255)->nullable();
            $table->string('digerUrl', 255)->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('isletme_turleri_id')->references('isletme_turleri_id')->on('isletme_turleri')->onDelete('restrict');
            $table->foreign('iller_id')->references('iller_id')->on('iller')->onDelete('restrict');
        });


        Schema::create('isletmeler_log', function (Blueprint $table) {
            $table->integer('isletmeler_id');
            $table->integer('isletme_turleri_id');
            $table->integer('iller_id')->nullable();
            $table->string('referans_kodu', 20)->nullable();
            $table->string('referans', 20)->nullable();
            $table->string('baslik', 255)->nullable();
            $table->string('adres', 500)->nullable();
            $table->string('kisaltma', 10)->nullable();
            $table->string('mailUzanti', 50)->nullable();
            $table->string('vectorelLogoUrl', 500)->nullable();
            $table->string('logoUrl', 500)->nullable();
            $table->string('websiteUrl', 255)->nullable();
            $table->string('xUrl', 255)->nullable();
            $table->string('instagramUrl', 255)->nullable();
            $table->string('linkedinUrl', 255)->nullable();
            $table->string('digerUrl', 255)->nullable();
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        DB::unprepared("
            CREATE TRIGGER isletmeler_insert
            AFTER INSERT ON isletmeler
            FOR EACH ROW
            BEGIN
                INSERT INTO isletmeler_log (
                    isletmeler_id,
                    isletme_turleri_id,
                    iller_id,
                    referans_kodu,
                    referans,
                    baslik,
                    adres,
                    kisaltma,
                    mailUzanti,
                    vectorelLogoUrl,
                    logoUrl,
                    websiteUrl,
                    xUrl,
                    instagramUrl,
                    linkedinUrl,
                    digerUrl,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                ) VALUES (
                    NEW.isletmeler_id,
                    NEW.isletme_turleri_id,
                    NEW.iller_id,
                    NEW.referans_kodu,
                    NEW.referans,
                    NEW.baslik,
                    NEW.adres,
                    NEW.kisaltma,
                    NEW.mailUzanti,
                    NEW.vectorelLogoUrl,
                    NEW.logoUrl,
                    NEW.websiteUrl,
                    NEW.xUrl,
                    NEW.instagramUrl,
                    NEW.linkedinUrl,
                    NEW.digerUrl,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER isletmeler_update
            AFTER UPDATE ON isletmeler
            FOR EACH ROW
            BEGIN
                INSERT INTO isletmeler_log (
                    isletmeler_id,
                    isletme_turleri_id,
                    iller_id,
                    referans_kodu,
                    referans,
                    baslik,
                    adres,
                    kisaltma,
                    mailUzanti,
                    vectorelLogoUrl,
                    logoUrl,
                    websiteUrl,
                    xUrl,
                    instagramUrl,
                    linkedinUrl,
                    digerUrl,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                ) VALUES (
                    NEW.isletmeler_id,
                    NEW.isletme_turleri_id,
                    NEW.iller_id,
                    NEW.referans_kodu,
                    NEW.referans,
                    NEW.baslik,
                    NEW.adres,
                    NEW.kisaltma,
                    NEW.mailUzanti,
                    NEW.vectorelLogoUrl,
                    NEW.logoUrl,
                    NEW.websiteUrl,
                    NEW.xUrl,
                    NEW.instagramUrl,
                    NEW.linkedinUrl,
                    NEW.digerUrl,
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
        DB::unprepared("DROP TRIGGER IF EXISTS isletmeler_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS isletmeler_update");
        Schema::dropIfExists('isletmeler');
        Schema::dropIfExists('isletmeler_log');
    }
};
