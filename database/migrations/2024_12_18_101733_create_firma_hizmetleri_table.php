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

        Schema::create('firma_hizmetleri', function (Blueprint $table) {
            $table->id('firma_hizmetleri_id');
            $table->unsignedBigInteger('hizmet_turleri_id')->nullable();
            $table->unsignedBigInteger('firmalar_id')->nullable();
            $table->longText('aciklama');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('firma_hizmetleri_log', function (Blueprint $table) {
            $table->integer('firma_hizmetleri_id');
            $table->integer('hizmet_turleri_id')->nullable();
            $table->integer('firmalar_id')->nullable();
            $table->char('islem', 1);
            $table->longText('aciklama');
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER firma_hizmetleri_insert
            AFTER INSERT ON firma_hizmetleri_log
            FOR EACH ROW
            BEGIN
                INSERT INTO firma_hizmetleri_log (firma_hizmetleri_id, hizmet_turleri_id, firmalar_id, islem, aktiflik, islem_yapan_id, created_at, updated_at)
                VALUES (
                    NEW.firma_hizmetleri_id,
                    NEW.hizmet_turleri_id,
                    NEW.firmalar_id,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER firma_hizmetleri_update
            AFTER UPDATE ON firma_hizmetleri_log
            FOR EACH ROW
            BEGIN
                INSERT INTO firma_hizmetleri_log (firma_hizmetleri_id, hizmet_turleri_id, firmalar_id, islem, aktiflik, islem_yapan_id, created_at, updated_at)
                VALUES (
                    NEW.firma_hizmetleri_id,
                    NEW.hizmet_turleri_id,
                    NEW.firmalar_id,
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
        Schema::dropIfExists('firma_hizmetleri');
        Schema::dropIfExists('firma_hizmetleri_log');
        DB::statement("DROP TRIGGER IF EXISTS firma_hizmetleri_insert");
        DB::statement("DROP TRIGGER IF EXISTS firma_hizmetleri_update");
    }
};
