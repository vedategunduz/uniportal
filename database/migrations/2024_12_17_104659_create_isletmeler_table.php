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
            $table->unsignedBigInteger('isletme_turleri_id');


            $table->unsignedBigInteger('iller_id')->nullable();

            $table->string('referans_kodu', 20)->unique()->nullable();
            // Foreign
            $table->foreign('iller_id')->references('iller_id')->on('iller')->onDelete('restrict');

            $table->string('baslik', 255)->nullable();
            $table->string('adres', 500)->nullable();
            $table->string('logoUrl', 500)->nullable();
            $table->string('websiteUrl', 255)->nullable();
            $table->string('xUrl', 255)->nullable();
            $table->string('instagramUrl', 255)->nullable();
            $table->string('linkedinUrl', 255)->nullable();
            $table->string('digerUrl', 255)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('isletmeler_log', function (Blueprint $table) {
            $table->integer('isletmeler_id');
            $table->string('referans_kodu', 20)->nullable();
            $table->integer('iller_id')->nullable();
            $table->string('baslik', 255)->nullable();
            $table->string('adres', 500)->nullable();
            $table->string('logoUrl', 500)->nullable();
            $table->string('websiteUrl', 255)->nullable();
            $table->string('xUrl', 255)->nullable();
            $table->string('instagramUrl', 255)->nullable();
            $table->string('linkedinUrl', 255)->nullable();
            $table->string('digerUrl', 255)->nullable();
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER isletmeler_insert
            AFTER INSERT ON isletmeler
            FOR EACH ROW
            BEGIN
                INSERT INTO isletmeler_log (
                    isletmeler_id,
                    referans_kodu,
                    iller_id,
                    baslik,
                    adres,
                    logoUrl,
                    websiteUrl,
                    xUrl,
                    instagramUrl,
                    linkedinUrl,
                    diger_url,
                    yapilanIslem,
                    created_at,
                    updated_at
                ) VALUES (
                    NEW.isletmeler_id,
                    NEW.referans_kodu,
                    NEW.iller_id,
                    NEW.baslik,
                    NEW.adres,
                    NEW.logoUrl,
                    NEW.websiteUrl,
                    NEW.xUrl,
                    NEW.instagramUrl,
                    NEW.linkedinUrl,
                    NEW.diger_url,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
        CREATE TRIGGER isletmeler_update
        AFTER UPDATE ON isletmeler
        FOR EACH ROW
        BEGIN
            INSERT INTO isletmeler_log (
                isletmeler_id,
                referans_kodu,
                iller_id,
                baslik,
                adres,
                logoUrl,
                websiteUrl,
                xUrl,
                instagramUrl,
                linkedinUrl,
                diger_url,
                yapilanIslem,
                created_at,
                updated_at
            ) VALUES (
                NEW.isletmeler_id,
                NEW.referans_kodu,
                NEW.iller_id,
                NEW.baslik,
                NEW.adres,
                NEW.logoUrl,
                NEW.websiteUrl,
                NEW.xUrl,
                NEW.instagramUrl,
                NEW.linkedinUrl,
                NEW.diger_url,
                'G',
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
        DB::statement("DROP TRIGGER IF EXISTS isletmeler_insert");
        DB::statement("DROP TRIGGER IF EXISTS isletmeler_update");
        Schema::dropIfExists('isletmeler');
        Schema::dropIfExists('isletmeler_log');
    }
};
