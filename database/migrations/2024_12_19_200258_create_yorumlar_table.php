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
        Schema::disableForeignKeyConstraints();

        Schema::create('yorumlar', function (Blueprint $table) {
            $table->id('yorumlar_id');
            $table->unsignedBigInteger('firmalar_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('kamular_id');
            $table->unsignedBigInteger('etkinlikler_id');
            $table->unsignedBigInteger('firma_hizmetleri_id');
            $table->unsignedBigInteger('kamu_hizmetleri_id');

            // Foreign
            $table->foreign('firmalar_id')->references('firmalar_id')->on('firmalar')->onDelete('restrict');
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->onDelete('restrict');
            $table->foreign('kamular_id')->references('kamular_id')->on('kamular')->onDelete('restrict');
            $table->foreign('etkinlikler_id')->references('etkinlikler_id')->on('etkinlikler')->onDelete('restrict');
            $table->foreign('firma_hizmetleri_id')->references('firma_hizmetleri_id')->on('firma_hizmetleri')->onDelete('restrict');
            $table->foreign('kamu_hizmetleri_id')->references('kamu_hizmetleri_id')->on('kamu_hizmetleri')->onDelete('restrict');

            $table->longText('aciklama');
            $table->double('puan');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('yorumlar_log', function (Blueprint $table) {
            $table->integer('yorumlar_id');
            $table->integer('firmalar_id');
            $table->integer('kullanicilar_id');
            $table->integer('kamular_id');
            $table->integer('etkinlikler_id');
            $table->integer('firma_hizmetleri_id');
            $table->integer('kamu_hizmetleri_id');
            $table->longText('aciklama');
            $table->double('puan');
            $table->char('islem', 1);
            $table->timestamps();
        });

        // AFTER INSERT Trigger
        DB::statement("
            CREATE TRIGGER yorumlar_insert
            AFTER INSERT ON yorumlar
            FOR EACH ROW
            BEGIN
                INSERT INTO yorumlar_log (
                    firmalar_id,
                    kullanicilar_id,
                    kamular_id,
                    etkinlikler_id,
                    firma_hizmetleri_id,
                    kamu_hizmetleri_id,
                    aciklama,
                    puan,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.firmalar_id,
                    NEW.kullanicilar_id,
                    NEW.kamular_id,
                    NEW.etkinlikler_id,
                    NEW.firma_hizmetleri_id,
                    NEW.kamu_hizmetleri_id,
                    NEW.aciklama,
                    NEW.puan,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        // AFTER UPDATE Trigger
        DB::statement("
            CREATE TRIGGER yorumlar_update
            AFTER UPDATE ON yorumlar
            FOR EACH ROW
            BEGIN
                INSERT INTO yorumlar_log (
                    firmalar_id,
                    kullanicilar_id,
                    kamular_id,
                    etkinlikler_id,
                    firma_hizmetleri_id,
                    kamu_hizmetleri_id,
                    aciklama,
                    puan,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.firmalar_id,
                    NEW.kullanicilar_id,
                    NEW.kamular_id,
                    NEW.etkinlikler_id,
                    NEW.firma_hizmetleri_id,
                    NEW.kamu_hizmetleri_id,
                    NEW.aciklama,
                    NEW.puan,
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
        DB::statement("DROP TRIGGER IF EXISTS yorumlar_insert");
        DB::statement("DROP TRIGGER IF EXISTS yorumlar_update");
        Schema::dropIfExists('yorumlar');
        Schema::dropIfExists('yorumlar_log');
    }
};
