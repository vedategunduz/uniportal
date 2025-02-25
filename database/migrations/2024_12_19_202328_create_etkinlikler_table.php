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
            $table->unsignedBigInteger('iller_id')->nullable();
            $table->integer('kontenjan')->nullable();
            $table->timestamp('etkinlikBasvuruTarihi')->nullable();
            $table->timestamp('etkinlikBasvuruBitisTarihi')->nullable();
            $table->timestamp('etkinlikBaslamaTarihi')->nullable();
            $table->timestamp('etkinlikBitisTarihi')->nullable();
            $table->string('kapakResmiYolu')->nullable()->default('image/etkinlikresim.png');
            $table->string('baslik', 255)->nullable();
            $table->enum('katilimTipi', ['genel', 'uniportal', 'özel'])->default('genel');
            $table->longText('aciklama')->nullable();
            $table->boolean('sosyalMedyadaPaylas', 1)->nullable()->default(1);
            $table->boolean('yorumDurumu')->nullable()->default(1);
            $table->timestamps();

            $table->foreign('etkinlik_turleri_id')->references('etkinlik_turleri_id')->on('etkinlik_turleri');
            $table->foreign('isletmeler_id')->references('isletmeler_id')->on('isletmeler');
            $table->foreign('iller_id')->references('iller_id')->on('iller');
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlikler_log', function (Blueprint $table) {
            $table->integer('etkinlikler_id');
            $table->integer('etkinlik_turleri_id');
            $table->integer('isletmeler_id');
            $table->integer('iller_id')->nullable();
            $table->integer('kontenjan')->nullable();
            $table->timestamp('etkinlikBasvuruTarihi')->nullable();
            $table->timestamp('etkinlikBasvuruBitisTarihi')->nullable();
            $table->timestamp('etkinlikBaslamaTarihi')->nullable();
            $table->timestamp('etkinlikBitisTarihi')->nullable();
            $table->string('kapakResmiYolu')->nullable();
            $table->string('baslik', 255)->nullable();
            $table->enum('katilimTipi', ['genel', 'uniportal', 'özel'])->default('genel');
            $table->longText('aciklama')->nullable();
            $table->boolean('sosyalMedyadaPaylas', 1)->nullable()->default(1);
            $table->boolean('yorumDurumu')->nullable()->default(1);
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
                    iller_id,
                    kontenjan,
                    etkinlikBasvuruTarihi,
                    etkinlikBasvuruBitisTarihi,
                    etkinlikBaslamaTarihi,
                    etkinlikBitisTarihi,
                    kapakResmiYolu,
                    baslik,
                    katilimTipi,
                    aciklama,
                    sosyalMedyadaPaylas,
                    yorumDurumu,
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
                    NEW.iller_id,
                    NEW.kontenjan,
                    NEW.etkinlikBasvuruTarihi,
                    NEW.etkinlikBasvuruBitisTarihi,
                    NEW.etkinlikBaslamaTarihi,
                    NEW.etkinlikBitisTarihi,
                    NEW.kapakResmiYolu,
                    NEW.baslik,
                    NEW.katilimTipi,
                    NEW.aciklama,
                    NEW.sosyalMedyadaPaylas,
                    NEW.yorumDurumu,
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
                    iller_id,
                    kontenjan,
                    etkinlikBasvuruTarihi,
                    etkinlikBasvuruBitisTarihi,
                    etkinlikBaslamaTarihi,
                    etkinlikBitisTarihi,
                    kapakResmiYolu,
                    baslik,
                    katilimTipi,
                    aciklama,
                    sosyalMedyadaPaylas,
                    yorumDurumu,
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
                    NEW.iller_id,
                    NEW.kontenjan,
                    NEW.etkinlikBasvuruTarihi,
                    NEW.etkinlikBasvuruBitisTarihi,
                    NEW.etkinlikBaslamaTarihi,
                    NEW.etkinlikBitisTarihi,
                    NEW.kapakResmiYolu,
                    NEW.baslik,
                    NEW.katilimTipi,
                    NEW.aciklama,
                    NEW.sosyalMedyadaPaylas,
                    NEW.yorumDurumu,
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
