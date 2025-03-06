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

        Schema::create('menu_rol_iliskileri', function (Blueprint $table) {
            $table->id('menu_rol_iliskileri_id');
            $table->unsignedBigInteger('roller_id');
            $table->unsignedBigInteger('menuler_id');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('roller_id')->references('roller_id')->on('roller')->onDelete('restrict');
            $table->foreign('menuler_id')->references('menuler_id')->on('menuler')->onDelete('restrict');
        });


        Schema::create('menu_rol_iliskileri_log', function (Blueprint $table) {
            $table->integer('menu_rol_iliskileri_id');
            $table->integer('roller_id');
            $table->integer('menuler_id');
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

        // AFTER INSERT Trigger
        DB::unprepared("
            CREATE TRIGGER menu_rol_iliskileri_insert
            AFTER INSERT ON menu_rol_iliskileri
            FOR EACH ROW
            BEGIN
                INSERT INTO menu_rol_iliskileri_log (
                    menu_rol_iliskileri_id,
                    roller_id,
                    menuler_id,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menu_rol_iliskileri_id,
                    NEW.roller_id,
                    NEW.menuler_id,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        // AFTER UPDATE Trigger
        DB::unprepared("
            CREATE TRIGGER menu_rol_iliskileri_update
            AFTER UPDATE ON menu_rol_iliskileri
            FOR EACH ROW
            BEGIN
                INSERT INTO menu_rol_iliskileri_log (
                    menu_rol_iliskileri_id,
                    roller_id,
                    menuler_id,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menu_rol_iliskileri_id,
                    NEW.roller_id,
                    NEW.menuler_id,
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
        DB::unprepared("DROP TRIGGER IF EXISTS menu_rol_iliskileri_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS menu_rol_iliskileri_update");
        Schema::dropIfExists('menu_rol_iliskileri');
        Schema::dropIfExists('menu_rol_iliskileri_log');
    }
};
