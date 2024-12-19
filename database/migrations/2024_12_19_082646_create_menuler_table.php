<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menuler', function (Blueprint $table) {
            $table->id('menuler_id');
            $table->string('menu_adi', 100);
            $table->string('menu_link', 100);
            $table->string('menu_icon', 1000);
            $table->string('menu_aciklama', 255);
            $table->integer('menu_sira');
            $table->unsignedBigInteger('bagli_menuler_id')->nullable();
            $table->timestamps();
        });

        Schema::create('menuler_log', function (Blueprint $table) {
            $table->integer('menuler_id');
            $table->string('menu_adi', 100);
            $table->string('menu_link', 100);
            $table->string('menu_icon', 1000);
            $table->string('menu_aciklama', 255);
            $table->integer('menu_sira');
            $table->integer('bagli_menuler_id')->nullable();
            $table->char('islem', 1);
            $table->timestamps();
        });

        // AFTER INSERT Trigger
        DB::statement("
            CREATE TRIGGER menuler_insert
            AFTER INSERT ON menuler
            FOR EACH ROW
            BEGIN
                INSERT INTO menuler_log (
                    menuler_id,
                    menu_adi,
                    menu_link,
                    menu_icon,
                    menu_aciklama,
                    menu_sira,
                    bagli_menuler_id,
                    islem,
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
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");

        // AFTER UPDATE Trigger
        DB::statement("
            CREATE TRIGGER menuler_update
            AFTER UPDATE ON menuler
            FOR EACH ROW
            BEGIN
                INSERT INTO menuler_log (
                    menuler_id,
                    menu_adi,
                    menu_link,
                    menu_icon,
                    menu_aciklama,
                    menu_sira,
                    bagli_menuler_id,
                    islem,
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
    }

    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS menuler_insert");
        DB::statement("DROP TRIGGER IF EXISTS menuler_update");
        Schema::dropIfExists('menuler_log');
        Schema::dropIfExists('menuler');
    }
};
