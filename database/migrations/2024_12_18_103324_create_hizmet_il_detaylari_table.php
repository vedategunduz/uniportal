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

        Schema::create('hizmet_il_detaylari', function (Blueprint $table) {
            $table->id('hizmet_il_detaylari_id');
            $table->unsignedBigInteger('firma_hizmetleri_id')->nullable();
            $table->unsignedBigInteger('kamu_hizmetleri_id')->nullable();
            $table->unsignedBigInteger('iller_id');

            // Foreign
            $table->foreign('firma_hizmetleri_id')->references('firma_hizmetleri_id')->on('firma_hizmetleri')->onDelete('restrict');
            $table->foreign('kamu_hizmetleri_id')->references('kamu_hizmetleri_id')->on('kamu_hizmetleri')->onDelete('restrict');
            $table->foreign('iller_id')->references('iller_id')->on('iller')->onDelete('restrict');

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('hizmet_il_detaylari_log', function (Blueprint $table) {
            $table->integer('hizmet_il_detaylari_id');
            $table->integer('firma_hizmetleri_id')->nullable();
            $table->integer('kamu_hizmetleri_id')->nullable();
            $table->integer('iller_id');

            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER hizmet_il_detaylari_insert
            AFTER INSERT ON hizmet_il_detaylari
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_il_detaylari_log (
                    hizmet_il_detaylari_id,
                    firma_hizmetleri_id,
                    kamu_hizmetleri_id,
                    iller_id,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.hizmet_il_detaylari_id,
                    NEW.firma_hizmetleri_id,
                    NEW.kamu_hizmetleri_id,
                    NEW.iller_id,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER hizmet_il_detaylari_update
            AFTER UPDATE ON hizmet_il_detaylari
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_il_detaylari_log (
                    hizmet_il_detaylari_id,
                    firma_hizmetleri_id,
                    kamu_hizmetleri_id,
                    iller_id,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.hizmet_il_detaylari_id,
                    NEW.firma_hizmetleri_id,
                    NEW.kamu_hizmetleri_id,
                    NEW.iller_id,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
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
        Schema::dropIfExists('hizmet_il_detaylari');
        Schema::dropIfExists('hizmet_il_detaylari_log');
        DB::statement("DROP TRIGGER IF EXISTS hizmet_il_detaylari_insert");
        DB::statement("DROP TRIGGER IF EXISTS hizmet_il_detaylari_update");
    }
};
