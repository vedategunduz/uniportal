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

        Schema::create('etkinlik_turleri', function (Blueprint $table) {
            $table->id('etkinlik_turleri_id');
            $table->string('tur', 55);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('etkinlik_turleri_log', function (Blueprint $table) {
            $table->integer('etkinlik_turleri_id');
            $table->string('tur', 55);
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER etkinlik_turleri_insert
            AFTER INSERT ON etkinlik_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_turleri_log (
                    etkinlik_turleri_id,
                    tur,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    etkinlik_turleri_id,
                    tur,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER etkinlik_turleri_update
            AFTER UPDATE ON etkinlik_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_turleri_log (
                    etkinlik_turleri_id,
                    tur,
                    islem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    etkinlik_turleri_id,
                    tur,
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
        DB::statement("DROP TRIGGER IF EXISTS etkinlik_turleri_insert");
        DB::statement("DROP TRIGGER IF EXISTS etkinlik_turleri_update");
        Schema::dropIfExists('etkinlik_turleri');
        Schema::dropIfExists('etkinlik_turleri_log');
    }
};