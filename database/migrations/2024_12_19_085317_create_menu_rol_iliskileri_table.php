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

        Schema::create('menu_rol_iliskileri', function (Blueprint $table) {
            $table->id('menu_rol_iliskileri_id');
            $table->unsignedBigInteger('roller_id');
            $table->unsignedBigInteger('menuler_id');

            $table->foreign('roller_id')->references('roller_id')->on('roller')->onDelete('restrict');
            $table->foreign('menuler_id')->references('menuler_id')->on('menuler')->onDelete('restrict');

            $table->timestamps();
        });

        Schema::create('menu_rol_iliskileri_log', function (Blueprint $table) {
            $table->integer('menu_rol_iliskileri_id');
            $table->integer('roller_id');
            $table->integer('menuler_id');
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
        CREATE TRIGGER menu_rol_iliskileri_insert
            AFTER INSERT ON menu_rol_iliskileri
            FOR EACH ROW
            BEGIN
                INSERT INTO menu_rol_iliskileri_log (
                    menu_rol_iliskileri_id,
                    roller_id,
                    menuler_id,
                    islem,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menu_rol_iliskileri_id,
                    NEW.roller_id,
                    NEW.menuler_id,
                    'E',
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER menu_rol_iliskileri_update
            AFTER UPDATE ON menu_rol_iliskileri
            FOR EACH ROW
            BEGIN
                INSERT INTO menu_rol_iliskileri_log (
                    menu_rol_iliskileri_id,
                    roller_id,
                    menuler_id,
                    islem,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menu_rol_iliskileri_id,
                    NEW.roller_id,
                    NEW.menuler_id,
                    'G',
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_rol_iliskileri');
    }
};
