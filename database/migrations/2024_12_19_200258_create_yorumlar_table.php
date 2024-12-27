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
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('isletmeler_id');
            $table->unsignedBigInteger('etkinlikler_id');
            $table->unsignedBigInteger('hizmetler_id');
            $table->longText('aciklama');
            $table->double('puan');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('yorumlar_log', function (Blueprint $table) {
            $table->integer('yorumlar_id');
            $table->integer('kullanicilar_id');
            $table->integer('isletmeler_id');
            $table->integer('etkinlikler_id');
            $table->integer('hizmetler_id');
            $table->longText('aciklama');
            $table->double('puan');
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        // AFTER INSERT Trigger
        DB::unprepared("
            CREATE TRIGGER yorumlar_insert
            AFTER INSERT ON yorumlar
            FOR EACH ROW
            BEGIN
                INSERT INTO yorumlar_log (
                    yorumlar_id,
                    kullanicilar_id,
                    isletmeler_id,
                    etkinlikler_id,
                    hizmetler_id,
                    aciklama,
                    puan,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.yorumlar_id,
                    NEW.kullanicilar_id,
                    NEW.isletmeler_id,
                    NEW.etkinlikler_id,
                    NEW.hizmetler_id,
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
        DB::unprepared("
            CREATE TRIGGER yorumlar_update
            AFTER UPDATE ON yorumlar
            FOR EACH ROW
            BEGIN
                                INSERT INTO yorumlar_log (
                    yorumlar_id,
                    kullanicilar_id,
                    isletmeler_id,
                    etkinlikler_id,
                    hizmetler_id,
                    aciklama,
                    puan,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.yorumlar_id,
                    NEW.kullanicilar_id,
                    NEW.isletmeler_id,
                    NEW.etkinlikler_id,
                    NEW.hizmetler_id,
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
        DB::unprepared("DROP TRIGGER IF EXISTS yorumlar_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS yorumlar_update");
        Schema::dropIfExists('yorumlar');
        Schema::dropIfExists('yorumlar_log');
    }
};
