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
        Schema::create('hizmet_turleri', function (Blueprint $table) {
            $table->id('hizmet_turleri_id');
            $table->string('baslik', 100);
            $table->integer('derinlik');
            $table->unsignedBigInteger('bagli_hizmet_turleri_id');
            $table->timestamps();
        });

        Schema::create('hizmet_turleri_log', function (Blueprint $table) {
            $table->integer('hizmet_turleri_id');
            $table->string('baslik', 100);
            $table->integer('derinlik');
            $table->integer('bagli_hizmet_turleri_id');
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER hizmet_turleri_insert
            AFTER INSERT ON hizmet_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_turleri_log (
                    hizmet_turleri_id,
                    baslik,
                    derinlik,
                    bagli_hizmet_turleri_id,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at)
                VALUES (
                    NEW.hizmet_turleri_id,
                    NEW.baslik,
                    NEW.derinlik,
                    NEW.bagli_hizmet_turleri_id,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER hizmet_turleri_update
            AFTER UPDATE ON hizmet_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO hizmet_turleri_log (
                    hizmet_turleri_id,
                    baslik,
                    derinlik,
                    bagli_hizmet_turleri_id,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at)
                VALUES (
                    NEW.hizmet_turleri_id,
                    NEW.baslik,
                    NEW.derinlik,
                    NEW.bagli_hizmet_turleri_id,
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
        DB::statement("DROP TRIGGER IF EXISTS hizmet_turleri_insert");
        DB::statement("DROP TRIGGER IF EXISTS hizmet_turleri_update");
        Schema::dropIfExists('hizmet_turleri');
        Schema::dropIfExists('hizmet_turleri_log');
    }
};
