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

        Schema::create('kamu_hizmetleri', function (Blueprint $table) {
            $table->id('kamu_hizmetleri_id');
            $table->unsignedBigInteger('hizmet_turleri_id');
            $table->unsignedBigInteger('kamular_id');

            // Foreign
            //$table->foreign('hizmet_turleri_id')->references('hizmet_turleri_id')->on('hizmet_turleri')->onDelete('restrict');
            //$table->foreign('kamular_id')->references('kamular_id')->on('kamular')->onDelete('restrict');
            //$table->foreign('islem_yapan_id')->references('kullanicilar_id')->on('kullanicilar')->onDelete('restrict');

            $table->longText('aciklama');
            $table->timestamps();
        });

        Schema::create('log_kamu_hizmetleri', function (Blueprint $table) {
            $table->unsignedBigInteger('kamu_hizmetleri_id');
            $table->unsignedBigInteger('hizmet_turleri_id');
            $table->unsignedBigInteger('kamular_id');
            $table->char('islem', 1);

            $table->longText('aciklama');
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER kamu_hizmetleri_insert
            AFTER INSERT ON kamu_hizmetleri
            FOR EACH ROW
            BEGIN
                INSERT INTO log_kamu_hizmetleri (kamu_hizmetleri_id, hizmet_turleri_id, kamular_id, islem_yapan_id, islem, aktiflik, aciklama, created_at, updated_at)
                VALUES (
                    NEW.kamu_hizmetleri_id,
                    NEW.hizmet_turleri_id,
                    NEW.kamular_id,
                    NEW.islem_yapan_id,
                    'E',
                    NEW.aktiflik,
                    NEW.aciklama,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER kamu_hizmetleri_update
            AFTER UPDATE ON kamu_hizmetleri
            FOR EACH ROW
            BEGIN
                INSERT INTO log_kamu_hizmetleri (kamu_hizmetleri_id, hizmet_turleri_id, kamular_id, islem_yapan_id, islem, aktiflik, aciklama, created_at, updated_at)
                VALUES (
                    NEW.kamu_hizmetleri_id,
                    NEW.hizmet_turleri_id,
                    NEW.kamular_id,
                    NEW.islem_yapan_id,
                    'G',
                    NEW.aktiflik,
                    NEW.aciklama,
                    NOW(),
                    NOW()
                );
            END;
        ");

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('kamu_hizmetleri');
        Schema::dropIfExists('log_kamu_hizmetleri');
        DB::statement("DROP TRIGGER IF EXISTS kamu_hizmetleri_insert");
        DB::statement("DROP TRIGGER IF EXISTS kamu_hizmetleri_update");
    }
};
