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

        Schema::create('isletme_yetkilileri', function (Blueprint $table) {
            $table->id('isletme_yetkilileri_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('isletmeler_id')->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->onDelete('restrict');
            $table->foreign('isletmeler_id')->references('isletmeler_id')->on('isletmeler')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('isletme_yetkilileri_log', function (Blueprint $table) {
            $table->integer('isletme_yetkilileri_id');
            $table->integer('kullanicilar_id');
            $table->integer('isletmeler_id')->nullable();
            $table->char('islem', 1);
            $table->timestamps();
        });

        // AFTER INSERT trigger
        DB::unprepared("
            CREATE TRIGGER isletme_yetkilileri_insert
            AFTER INSERT ON isletme_yetkilileri
            FOR EACH ROW
            BEGIN
                INSERT INTO isletme_yetkilileri_log (
                    isletme_yetkilileri_id,
                    kullanicilar_id,
                    isletmeler_id,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.isletme_yetkilileri_id,
                    NEW.kullanicilar_id,
                    NEW.isletmeler_id,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");


        // AFTER UPDATE trigger
        DB::unprepared("
            CREATE TRIGGER isletme_yetkilileri_update
            AFTER UPDATE ON isletme_yetkilileri
            FOR EACH ROW
            BEGIN
                INSERT INTO isletme_yetkilileri_log (
                    isletme_yetkilileri_id,
                    kullanicilar_id,
                    isletmeler_id,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.isletme_yetkilileri_id,
                    NEW.kullanicilar_id,
                    NEW.isletmeler_id,
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
        Schema::dropIfExists('isletme_yetkilileri');
        Schema::dropIfExists('isletme_yetkilileri_log');
        DB::unprepared("DROP TRIGGER IF EXISTS isletme_yetkilileri_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS isletme_yetkilileri_update");
    }
};
