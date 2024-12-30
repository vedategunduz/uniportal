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

        Schema::create('resimler', function (Blueprint $table) {
            $table->id('resimler_id');
            $table->unsignedBigInteger('etkinlikler_id')->nullable();
            $table->string('resimYolu');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Schema::create('resimler_log', function (Blueprint $table) {
        //     $table->integer('resimler_id');
        //     $table->integer('etkinlikler_id');
        //     $table->integer('kamu_hizmetleri_id');
        //     $table->integer('firma_hizmetleri_id');
        //     $table->string('resimyolu', 500);
        //     $table->char('islem', 1);
        //     $table->timestamps();
        // });

        // DB::unprepared("
        //     CREATE TRIGGER resimler_insert
        //     AFTER INSERT ON resimler
        //     FOR EACH ROW
        //     BEGIN
        //         INSERT INTO resimler_log (
        //             resimler_id,
        //             etkinlikler_id,
        //             kamu_hizmetleri_id,
        //             firma_hizmetleri_id,
        //             resimyolu,
        //             islem,
        //             aktiflik,
        //             islem_yapan_id,
        //             created_at,
        //             updated_at
        //         )
        //         VALUES (
        //             NEW.resimler_id,
        //             NEW.etkinlikler_id,
        //             NEW.kamu_hizmetleri_id,
        //             NEW.firma_hizmetleri_id,
        //             NEW.resimyolu,
        //             'E',
        //             NEW.aktiflik,
        //             NEW.islem_yapan_id,
        //             NOW(),
        //             NOW()
        //         );
        //     END;
        // ");

        // DB::unprepared("
        //     CREATE TRIGGER resimler_update
        //     AFTER UPDATE ON resimler
        //     FOR EACH ROW
        //     BEGIN
        //         INSERT INTO resimler_log (
        //             resimler_id,
        //             etkinlikler_id,
        //             kamu_hizmetleri_id,
        //             firma_hizmetleri_id,
        //             resimyolu,
        //             islem,
        //             aktiflik,
        //             islem_yapan_id,
        //             created_at,
        //             updated_at
        //         )
        //         VALUES (
        //             NEW.resimler_id,
        //             NEW.etkinlikler_id,
        //             NEW.kamu_hizmetleri_id,
        //             NEW.firma_hizmetleri_id,
        //             NEW.resimyolu,
        //             'G',
        //             NEW.aktiflik,
        //             NEW.islem_yapan_id,
        //             NOW(),
        //             NOW()
        //         );
        //     END;
        // ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::unprepared("DROP TRIGGER IF EXISTS resimler_insert");
        // DB::unprepared("DROP TRIGGER IF EXISTS resimler_update");
        // Schema::dropIfExists('resimler_log');
        Schema::dropIfExists('resimler');
    }
};
