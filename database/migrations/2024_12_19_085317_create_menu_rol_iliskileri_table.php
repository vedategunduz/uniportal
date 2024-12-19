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
            $table->string('baslik');
            $table->unsignedBigInteger('roller_id');
            $table->unsignedBigInteger('menuler_id');
            $table->timestamps();
        });

        Schema::create('menu_rol_iliskileri_log', function (Blueprint $table) {
            $table->integer('menu_rol_iliskileri_id');
            $table->string('baslik');
            $table->integer('roller_id');
            $table->integer('menuler_id');
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER menu_rol_iliskileri_update
            AFTER UPDATE ON menu_rol_iliskileri
            FOR EACH ROW
            BEGIN
                INSERT INTO menu_rol_iliskileri_log (
                    menuler_id,
                    menu_adi,
                    menu_link,
                    menu_icon,
                    menu_aciklama,
                    menu_sira,
                    bagli_menuler_id,
                    islem,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menuler_id,
                    NEW.menu_adi,
                    NEW.menu_link,
                    NEW.menu_icon,
                    NEW.menu_aciklama,
                    NEW.menu_sira,
                    NEW.bagli_menuler_id,
                    'G',
                    NOW(),
                    NOW()
                );
            END;
        ");

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_rol_iliskileri');
    }
};
