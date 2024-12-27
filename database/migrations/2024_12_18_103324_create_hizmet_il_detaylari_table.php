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
            $table->unsignedBigInteger('hizmetler_id')->nullable();
            $table->unsignedBigInteger('iller_id');
            $table->timestamps();

            // Foreign
            $table->foreign('hizmetler_id')->references('hizmetler_id')->on('hizmetler')->onDelete('restrict');
            $table->foreign('iller_id')->references('iller_id')->on('iller')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('hizmet_il_detaylari_log', function (Blueprint $table) {
            $table->integer('hizmet_il_detaylari_id');
            $table->integer('hizmetler_id')->nullable();
            $table->integer('iller_id');

            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER hizmet_il_detaylari_insert
            AFTER INSERT ON hizmet_il_detaylari
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_il_detaylari_log (
                    hizmet_il_detaylari_id,
                    hizmetler_id,
                    iller_id,
                    yapianIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.hizmet_il_detaylari_id,
                    NEW.hizmetler_id,
                    NEW.iller_id,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER hizmet_il_detaylari_update
            AFTER UPDATE ON hizmet_il_detaylari
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_il_detaylari_log (
                    hizmet_il_detaylari_id,
                    hizmetler_id,
                    iller_id,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.hizmet_il_detaylari_id,
                    NEW.hizmetler_id,
                    NEW.iller_id,
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
        Schema::dropIfExists('hizmet_il_detaylari');
        Schema::dropIfExists('hizmet_il_detaylari_log');
        DB::unprepared("DROP TRIGGER IF EXISTS hizmet_il_detaylari_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS hizmet_il_detaylari_update");
    }
};
