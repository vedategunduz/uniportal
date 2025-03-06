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
            $table->string('baslik', 55);
            $table->string('class', 500)->nullable();
            $table->integer('tip');
            $table->timestamps();
        });


        Schema::create('etkinlik_turleri_log', function (Blueprint $table) {
            $table->integer('etkinlik_turleri_id');
            $table->string('baslik', 55);
            $table->string('class', 500)->nullable();
            $table->integer('tip')->nullable();
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

        DB::unprepared("
            CREATE TRIGGER etkinlik_turleri_insert
            AFTER INSERT ON etkinlik_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_turleri_log (
                    etkinlik_turleri_id,
                    baslik,
                    class,
                    tip,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_turleri_id,
                    NEW.baslik,
                    NEW.class,
                    NEW.tip,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER etkinlik_turleri_update
            AFTER UPDATE ON etkinlik_turleri
            FOR EACH ROW
            BEGIN
                INSERT INTO etkinlik_turleri_log (
                    etkinlik_turleri_id,
                    baslik,
                    class,
                    tip,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.etkinlik_turleri_id,
                    NEW.baslik,
                    NEW.class,
                    NEW.tip,
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
        DB::unprepared("DROP TRIGGER IF EXISTS etkinlik_turleri_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS etkinlik_turleri_update");
        Schema::dropIfExists('etkinlik_turleri');
        Schema::dropIfExists('etkinlik_turleri_log');
    }
};
