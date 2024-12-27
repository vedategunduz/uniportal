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
        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->id('kullanicilar_id');
            $table->unsignedBigInteger('roller_id');
            $table->string('ad', 155);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('roller_id')->references('roller_id')->on('roller')->onDelete('restrict');
        });

        Schema::create('kullanicilar_log', function (Blueprint $table) {
            $table->integer('kullanicilar_id');
            $table->integer('roller_id');
            $table->string('ad', 155);
            $table->string('email', 255);

            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER kullanicilar_insert
            AFTER INSERT ON kullanicilar
            FOR EACH ROW
            BEGIN
                INSERT INTO kullanicilar_log (
                    kullanicilar_id,
                    roller_id,
                    ad,
                    email,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.kullanicilar_id,
                    NEW.roller_id,
                    NEW.ad,
                    NEW.email,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER kullanicilar_update
            AFTER UPDATE ON kullanicilar
            FOR EACH ROW
            BEGIN
                INSERT INTO kullanicilar_log (
                    kullanicilar_id,
                    roller_id,
                    ad,
                    email,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.kullanicilar_id,
                    NEW.roller_id,
                    NEW.ad,
                    NEW.email,
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
        DB::unprepared("DROP TRIGGER IF EXISTS kullanicilar_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS kullanicilar_update");
        Schema::dropIfExists('kullanicilar');
        Schema::dropIfExists('kullanicilar_log');
    }
};
