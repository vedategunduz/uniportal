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
            $table->unsignedBigInteger('firmalar_id');
            $table->unsignedBigInteger('kamular_id');

            // Foreign
            $table->foreign('firmalar_id')->references('firmalar_id')->on('firmalar')->onDelete('restrict');
            $table->foreign('kamular_id')->references('kamular_id')->on('kamular')->onDelete('restrict');

            $table->timestamp('etkinlik_basvuru_tarihi')->nullable();
            $table->timestamp('etkinlik_basvuru_bitis_tarihi')->nullable();
            $table->timestamp('etkinlik_baslama_tarihi')->nullable();
            $table->timestamp('etkinlik_bitis_tarihi')->nullable();
            $table->longText('aciklama');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlikler_log', function (Blueprint $table) {
            $table->integer('etkinlikler_id');
            $table->integer('firmalar_id');
            $table->integer('kamular_id');
            $table->timestamp('etkinlik_basvuru_tarihi')->nullable();
            $table->timestamp('etkinlik_basvuru_bitis_tarihi')->nullable();
            $table->timestamp('etkinlik_baslama_tarihi')->nullable();
            $table->timestamp('etkinlik_bitis_tarihi')->nullable();
            $table->longText('aciklama');
            $table->char('islem', 1);
            $table->timestamps();
        });

        // AFTER INSERT Trigger
        DB::statement("
            CREATE TRIGGER etkinlikler_insert
            AFTER INSERT ON etkinlikler
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlikler_log (
                    etkinlikler_id,
                    firmalar_id,
                    kamular_id,
                    etkinlik_basvuru_tarihi,
                    etkinlik_basvuru_bitis_tarihi,
                    etkinlik_baslama_tarihi,
                    etkinlik_bitis_tarihi,
                    aciklama,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlikler_id,
                    NEW.firmalar_id,
                    NEW.kamular_id,
                    NEW.etkinlik_basvuru_tarihi,
                    NEW.etkinlik_basvuru_bitis_tarihi,
                    NEW.etkinlik_baslama_tarihi,
                    NEW.etkinlik_bitis_tarihi,
                    NEW.aciklama,
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
            CREATE TRIGGER etkinlikler_update
            AFTER UPDATE ON etkinlikler
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlikler_log (
                    etkinlikler_id,
                    firmalar_id,
                    kamular_id,
                    etkinlik_basvuru_tarihi,
                    etkinlik_basvuru_bitis_tarihi,
                    etkinlik_baslama_tarihi,
                    etkinlik_bitis_tarihi,
                    aciklama,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlikler_id,
                    NEW.firmalar_id,
                    NEW.kamular_id,
                    NEW.etkinlik_basvuru_tarihi,
                    NEW.etkinlik_basvuru_bitis_tarihi,
                    NEW.etkinlik_baslama_tarihi,
                    NEW.etkinlik_bitis_tarihi,
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

    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS etkinlikler_insert");
        DB::statement("DROP TRIGGER IF EXISTS etkinlikler_update");
        Schema::dropIfExists('etkinlikler');
        Schema::dropIfExists('etkinlikler_log');
    }
};
