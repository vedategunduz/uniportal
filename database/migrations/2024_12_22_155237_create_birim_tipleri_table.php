<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('birim_tipleri', function (Blueprint $table) {
            $table->id('birim_tipleri_id');
            $table->string('baslik', 55);
            $table->timestamps();
        });

        Schema::create('birim_tipleri_log', function (Blueprint $table) {
            $table->integer('birim_tipleri_id');
            $table->string('baslik', 55);
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER birim_tipleri_insert
            AFTER INSERT ON birim_tipleri
            FOR EACH ROW
            BEGIN
                INSERT INTO birim_tipleri_log (
                    birim_tipleri_id,
                    baslik,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.birim_tipleri_id,
                    NEW.baslik,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER birim_tipleri_update
            AFTER UPDATE ON birim_tipleri
            FOR EACH ROW
            BEGIN
                INSERT INTO birim_tipleri_log (
                    birim_tipleri_id,
                    baslik,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.birim_tipleri_id,
                    NEW.baslik,
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
        DB::statement("DROP TRIGGER IF EXISTS birim_tipleri_insert");
        DB::statement("DROP TRIGGER IF EXISTS birim_tipleri_update");
        Schema::dropIfExists('birim_tipleri');
        Schema::dropIfExists('birim_tipleri_log');
    }
};
