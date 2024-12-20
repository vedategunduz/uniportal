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

        Schema::create('etkinlik_katilimlari', function (Blueprint $table) {
            $table->id('etkinlik_katilimlari_id');
            $table->unsignedBigInteger('etkinlikler_id')->nullable();
            $table->unsignedBigInteger('kullanicilar_id')->nullable();
            $table->unsignedBigInteger('firmalar_id')->nullable();
            $table->unsignedBigInteger('kamular_id')->nullable();

            // Foreign
            $table->foreign('etkinlikler_id')->references('etkinlikler_id')->on('etkinlikler')->onDelete('restrict');
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->onDelete('restrict');
            $table->foreign('firmalar_id')->references('firmalar_id')->on('firmalar')->onDelete('restrict');
            $table->foreign('kamular_id')->references('kamular_id')->on('kamular')->onDelete('restrict');

            $table->enum('durum', ['beklemede', 'onaylandi', 'iptal']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlik_katilimlari_log', function (Blueprint $table) {
            $table->integer('etkinlik_katilimlari_id');
            $table->integer('etkinlikler_id')->nullable();
            $table->integer('kullanicilar_id')->nullable();
            $table->integer('firmalar_id')->nullable();
            $table->integer('kamular_id')->nullable();
            $table->enum('durum', ['beklemede', 'onaylandi', 'iptal']);
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER etkinlik_katilimlari_insert
            AFTER INSERT ON etkinlik_katilimlari
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_katilimlari_log (
                    etkinlik_katilimlari_id,
                    etkinlikler_id,
                    kullanicilar_id,
                    firmalar_id,
                    kamular_id,
                    aktiflik,
                    islem_yapan_id,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_katilimlari_id,
                    NEW.etkinlikler_id,
                    NEW.kullanicilar_id,
                    NEW.firmalar_id,
                    NEW.kamular_id,
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER etkinlik_katilimlari_update
            AFTER UPDATE ON etkinlik_katilimlari
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_katilimlari_log (
                    etkinlik_katilimlari_id,
                    etkinlikler_id,
                    kullanicilar_id,
                    firmalar_id,
                    kamular_id,
                    aktiflik,
                    islem_yapan_id,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_katilimlari_id,
                    NEW.etkinlikler_id,
                    NEW.kullanicilar_id,
                    NEW.firmalar_id,
                    NEW.kamular_id,
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
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
        DB::statement("DROP TRIGGER IF EXISTS hizmet_il_detaylari_insert");
        DB::statement("DROP TRIGGER IF EXISTS hizmet_il_detaylari_update");
        Schema::dropIfExists('etkinlik_katilimlari');
        Schema::dropIfExists('etkinlik_katilimlari_log');
    }
};
