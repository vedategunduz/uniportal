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
        Schema::create('hizmet_turleri', function (Blueprint $table) {
            $table->id('hizmet_turleri_id');
            $table->unsignedBigInteger('bagli_hizmet_turleri_id')->nullable();
            $table->string('baslik', 100);
            $table->integer('derinlik');
            $table->timestamps();
        });

        Schema::create('hizmet_turleri_log', function (Blueprint $table) {
            $table->integer('hizmet_turleri_id');
            $table->integer('bagli_hizmet_turleri_id')->nullable();
            $table->string('baslik', 100);
            $table->integer('derinlik');
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
        DB::unprepared("
            CREATE TRIGGER hizmet_turleri_insert
            AFTER INSERT ON hizmet_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_turleri_log (
                    hizmet_turleri_id,
                    bagli_hizmet_turleri_id,
                    baslik,
                    derinlik,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at)
                VALUES (
                    NEW.hizmet_turleri_id,
                    NEW.bagli_hizmet_turleri_id,
                    NEW.baslik,
                    NEW.derinlik,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER hizmet_turleri_update
            AFTER UPDATE ON hizmet_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_turleri_log (
                    hizmet_turleri_id,
                    bagli_hizmet_turleri_id,
                    baslik,
                    derinlik,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at)
                VALUES (
                    NEW.hizmet_turleri_id,
                    NEW.bagli_hizmet_turleri_id,
                    NEW.baslik,
                    NEW.derinlik,
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
        DB::unprepared("DROP TRIGGER IF EXISTS hizmet_turleri_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS hizmet_turleri_update");
        Schema::dropIfExists('hizmet_turleri');
        Schema::dropIfExists('hizmet_turleri_log');
    }
};
