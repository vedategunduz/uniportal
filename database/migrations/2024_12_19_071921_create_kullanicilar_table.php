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

        // Kullanıcılar Tablosu
        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->id('kullanicilar_id');
            $table->unsignedBigInteger('roller_id')->index();
            $table->string('ad', 155);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('roller_id')->references('roller_id')->on('roller')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('kullanicilar_log', function (Blueprint $table) {
            $table->integer('kullanicilar_id');
            $table->integer('roller_id');
            $table->string('ad', 155);
            $table->string('email', 255);

            $table->char('islem', 1);
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
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.kullanicilar_id,
                    NEW.roller_id,
                    NEW.ad,
                    NEW.email,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'E',
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
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.kullanicilar_id,
                    NEW.roller_id,
                    NEW.ad,
                    NEW.email,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'G',
                    NOW(),
                    NOW()
                );
            END;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS kullanicilar_insert");
        DB::statement("DROP TRIGGER IF EXISTS kullanicilar_update");
        Schema::dropIfExists('kullanicilar');
        Schema::dropIfExists('kullanicilar_log');
    }
};
