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
        Schema::create('menuler', function (Blueprint $table) {
            $table->id('menuler_id');
            $table->unsignedBigInteger('bagli_menuler_id')->nullable();
            $table->string('menuAd', 100)->nullable();
            $table->string('menuLink', 100)->nullable();
            $table->longText('menuIcon')->nullable();
            $table->string('menuAciklama', 255)->nullable();
            $table->integer('menuSira');
            $table->timestamps();
        });

        Schema::create('menuler_log', function (Blueprint $table) {
            $table->integer('menuler_id');
            $table->integer('bagli_menuler_id')->nullable();
            $table->string('menuAd', 100)->nullable();
            $table->string('menuLink', 100)->nullable();
            $table->longText('menuIcon')->nullable();
            $table->string('menuAciklama', 255)->nullable();
            $table->integer('menuSira');
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

        // AFTER INSERT Trigger
        DB::unprepared("
            CREATE TRIGGER menuler_insert
            AFTER INSERT ON menuler
            FOR EACH ROW
            BEGIN
                INSERT INTO menuler_log (
                    menuler_id,
                    bagli_menuler_id,
                    menuAd,
                    menuLink,
                    menuIcon,
                    menuAciklama,
                    menuSira,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menuler_id,
                    NEW.bagli_menuler_id,
                    NEW.menuAd,
                    NEW.menuLink,
                    NEW.menuIcon,
                    NEW.menuAciklama,
                    NEW.menuSira,
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
            CREATE TRIGGER menuler_update
            AFTER UPDATE ON menuler
            FOR EACH ROW
            BEGIN
                INSERT INTO menuler_log (
                    menuler_id,
                    bagli_menuler_id,
                    menuAd,
                    menuLink,
                    menuIcon,
                    menuAciklama,
                    menuSira,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.menuler_id,
                    NEW.bagli_menuler_id,
                    NEW.menuAd,
                    NEW.menuLink,
                    NEW.menuIcon,
                    NEW.menuAciklama,
                    NEW.menuSira,
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
        DB::unprepared("DROP TRIGGER IF EXISTS menuler_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS menuler_update");
        Schema::dropIfExists('menuler_log');
        Schema::dropIfExists('menuler');
    }
};
