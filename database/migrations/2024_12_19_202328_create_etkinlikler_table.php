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

        Schema::create('etkinlikler', function (Blueprint $table) {
            $table->id('etkinlikler_id');
            $table->unsignedBigInteger('etkinlik_turleri_id');
            $table->unsignedBigInteger('isletmeler_id');
            $table->timestamp('etkinlikBasvuruTarihi')->nullable();
            $table->timestamp('etkinlikBasvuruBitisTarihi')->nullable();
            $table->timestamp('etkinlikBaslamaTarihi')->nullable();
            $table->timestamp('etkinlikBitisTarihi')->nullable();
            $table->longText('aciklama');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlikler_log', function (Blueprint $table) {
            $table->integer('etkinlikler_id');
            $table->integer('etkinlik_turleri_id');
            $table->integer('isletmeler_id');
            $table->timestamp('etkinlikBasvuruTarihi')->nullable();
            $table->timestamp('etkinlikBasvuruBitisTarihi')->nullable();
            $table->timestamp('etkinlikBaslamaTarihi')->nullable();
            $table->timestamp('etkinlikBitisTarihi')->nullable();
            $table->longText('aciklama');
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        // AFTER INSERT Trigger
        DB::unprepared("
            CREATE TRIGGER etkinlikler_insert
            AFTER INSERT ON etkinlikler
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlikler_log (
                    etkinlikler_id,
                    etkinlik_turleri_id,
                    isletmeler_id,
                    etkinlikBasvuruTarihi,
                    etkinlikBasvuruBitisTarihi,
                    etkinlikBaslamaTarihi,
                    etkinlikBitisTarihi,
                    aciklama,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlikler_id,
                    NEW.etkinlik_turleri_id,
                    NEW.isletmeler_id,
                    NEW.etkinlikBasvuruTarihi,
                    NEW.etkinlikBasvuruBitisTarihi,
                    NEW.etkinlikBaslamaTarihi,
                    NEW.etkinlikBitisTarihi,
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
            CREATE TRIGGER etkinlikler_update
            AFTER UPDATE ON etkinlikler
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlikler_log (
                    etkinlikler_id,
                    etkinlik_turleri_id,
                    isletmeler_id,
                    etkinlikBasvuruTarihi,
                    etkinlikBasvuruBitisTarihi,
                    etkinlikBaslamaTarihi,
                    etkinlikBitisTarihi,
                    aciklama,
                    yapilanIslem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlikler_id,
                    NEW.etkinlik_turleri_id,
                    NEW.isletmeler_id,
                    NEW.etkinlikBasvuruTarihi,
                    NEW.etkinlikBasvuruBitisTarihi,
                    NEW.etkinlikBaslamaTarihi,
                    NEW.etkinlikBitisTarihi,
                    NEW.aciklama,
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
        DB::unprepared("DROP TRIGGER IF EXISTS etkinlikler_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS etkinlikler_update");
        Schema::dropIfExists('etkinlikler');
        Schema::dropIfExists('etkinlikler_log');
    }
};
