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

        Schema::create('kamular', function (Blueprint $table) {
            $table->id('kamular_id');
            $table->string('kamu_kodu', 20)->unique();
            $table->unsignedBigInteger('iller_id')->nullable();

            // Foreign
            $table->foreign('iller_id')->references('iller_id')->on('iller')->onDelete('restrict');

            $table->string('baslik', 255)->nullable();
            $table->string('adres', 500)->nullable();
            $table->string('logo_url', 500)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('x_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('diger_url', 255)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('kamular_log', function (Blueprint $table) {
            $table->integer('kamular_id');
            $table->string('kamu_kodu', 20);
            $table->integer('iller_id')->nullable();
            $table->string('baslik', 255)->nullable();
            $table->string('adres', 500)->nullable();
            $table->string('logo_url', 500)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('x_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('diger_url', 255)->nullable();
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER kamular_insert
            AFTER INSERT ON kamular
            FOR EACH ROW
            BEGIN
                INSERT INTO kamular_log (
                    kamular_id,
                    kamu_kodu,
                    iller_id,
                    baslik,
                    adres,
                    logo_url,
                    website_url,
                    x_url,
                    instagram_url,
                    linkedin_url,
                    diger_url,
                    islem,
                    created_at,
                    updated_at
                ) VALUES (
                    NEW.kamular_id,
                    NEW.kamu_kodu,
                    NEW.iller_id,
                    NEW.baslik,
                    NEW.adres,
                    NEW.logo_url,
                    NEW.website_url,
                    NEW.x_url,
                    NEW.instagram_url,
                    NEW.linkedin_url,
                    NEW.diger_url,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
        CREATE TRIGGER kamular_update
        AFTER UPDATE ON kamular
        FOR EACH ROW
        BEGIN
            INSERT INTO kamular_log (
                kamular_id,
                kamu_kodu,
                iller_id,
                baslik,
                adres,
                logo_url,
                website_url,
                x_url,
                instagram_url,
                linkedin_url,
                diger_url,
                islem,
                created_at,
                updated_at
            ) VALUES (
                NEW.kamular_id,
                NEW.kamu_kodu,
                NEW.iller_id,
                NEW.baslik,
                NEW.adres,
                NEW.logo_url,
                NEW.website_url,
                NEW.x_url,
                NEW.instagram_url,
                NEW.linkedin_url,
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
        DB::statement("DROP TRIGGER IF EXISTS kamular_insert");
        DB::statement("DROP TRIGGER IF EXISTS kamular_update");
        Schema::dropIfExists('kamular');
        Schema::dropIfExists('kamular_log');
    }
};
