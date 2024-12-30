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

        Schema::create('etkinlik_il_detaylari', function (Blueprint $table) {
            $table->id('etkinlik_il_detaylari_id');
            $table->unsignedBigInteger('etkinlikler_id')->nullable();
            $table->unsignedBigInteger('iller_id');
            $table->timestamps();

            // Foreign
            $table->foreign('etkinlikler_id')->references('etkinlikler_id')->on('etkinlikler')->onDelete('restrict');
            $table->foreign('iller_id')->references('iller_id')->on('iller')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlik_il_detaylari_log', function (Blueprint $table) {
            $table->integer('etkinlik_il_detaylari_id');
            $table->integer('etkinlikler_id')->nullable();
            $table->integer('iller_id');

            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER etkinlik_il_detaylari_insert
            AFTER INSERT ON etkinlik_il_detaylari
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_il_detaylari_log (
                    etkinlik_il_detaylari_id,
                    etkinlikler_id,
                    iller_id,
                    yapianIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_il_detaylari_id,
                    NEW.etkinlikler_id,
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
            CREATE TRIGGER etkinlik_il_detaylari_update
            AFTER UPDATE ON etkinlik_il_detaylari
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_il_detaylari_log (
                    etkinlik_il_detaylari_id,
                    etkinlikler_id,
                    iller_id,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_il_detaylari_id,
                    NEW.etkinlikler_id,
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
        Schema::dropIfExists('etkinlik_il_detaylari');
        Schema::dropIfExists('etkinlik_il_detaylari_log');
        DB::unprepared("DROP TRIGGER IF EXISTS etkinlik_il_detaylari_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS etkinlik_il_detaylari_update");
    }
};
