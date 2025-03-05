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
            $table->unsignedBigInteger('giden_isletmeler_id')->nullable();
            $table->unsignedBigInteger('gidilen_isletmeler_id')->nullable();
            $table->text('aciklama')->nullable();
            $table->enum('durum', ['beklemede', 'onaylandi', 'reddedildi', 'iptal']);
            $table->enum('katilimciTipi', ['davetli', 'giden', 'katilimci']);
            $table->timestamps();

            $table->foreign('etkinlikler_id')->references('etkinlikler_id')->on('etkinlikler')->restrictOnDelete();
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->restrictOnDelete();
            $table->foreign('giden_isletmeler_id')->references('isletmeler_id')->on('isletmeler')->restrictOnDelete();
            $table->foreign('gidilen_isletmeler_id')->references('isletmeler_id')->on('isletmeler')->restrictOnDelete();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlik_katilimlari_log', function (Blueprint $table) {
            $table->integer('etkinlik_katilimlari_id');
            $table->integer('etkinlikler_id')->nullable();
            $table->integer('kullanicilar_id')->nullable();
            $table->unsignedBigInteger('giden_isletmeler_id')->nullable();
            $table->unsignedBigInteger('gidilen_isletmeler_id')->nullable();
            $table->text('aciklama')->nullable();
            $table->enum('durum', ['beklemede', 'onaylandi', 'reddedildi', 'iptal']);
            $table->enum('katilimciTipi', ['davetli', 'giden', 'katilimci']);
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER etkinlik_katilimlari_insert
            AFTER INSERT ON etkinlik_katilimlari
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_katilimlari_log (
                    etkinlik_katilimlari_id,
                    etkinlikler_id,
                    kullanicilar_id,
                    giden_isletmeler_id,
                    gidilen_isletmeler_id,
                    aciklama,
                    durum,
                    katilimciTipi,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_katilimlari_id,
                    NEW.etkinlikler_id,
                    NEW.kullanicilar_id,
                    NEW.giden_isletmeler_id,
                    NEW.gidilen_isletmeler_id,
                    NEW.aciklama,
                    NEW.durum,
                    NEW.katilimciTipi,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER etkinlik_katilimlari_update
            AFTER UPDATE ON etkinlik_katilimlari
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_katilimlari_log (
                    etkinlik_katilimlari_id,
                    etkinlikler_id,
                    kullanicilar_id,
                    giden_isletmeler_id,
                    gidilen_isletmeler_id,
                    aciklama,
                    durum,
                    katilimciTipi,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_katilimlari_id,
                    NEW.etkinlikler_id,
                    NEW.kullanicilar_id,
                    NEW.giden_isletmeler_id,
                    NEW.gidilen_isletmeler_id,
                    NEW.aciklama,
                    NEW.durum,
                    NEW.katilimciTipi,
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
        DB::unprepared("DROP TRIGGER IF EXISTS hizmet_il_detaylari_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS hizmet_il_detaylari_update");
        Schema::dropIfExists('etkinlik_katilimlari');
        Schema::dropIfExists('etkinlik_katilimlari_log');
    }
};
