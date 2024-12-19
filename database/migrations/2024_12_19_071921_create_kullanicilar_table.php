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

        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->id('kullanicilar_id');
            $table->unsignedBigInteger('roller_id');

            $table->foreign('roller_id')->references('roller_id')->on('roller')->onDelete('restrict');

            $table->string('ad');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('kullanicilar_log', function (Blueprint $table) {
            $table->integer('kullanicilar_id');
            $table->integer('roller_id');
            $table->string('ad');

            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER kullanicilar_insert
            AFTER INSERT ON kullanicilar
            FOR EACH ROW
            BEGIN
                INSERT INTO kullanicilar_log (
                    kullanicilar_id,
                    roller_id,
                    ad,
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
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");

        DB::statement("
            CREATE TRIGGER kullanicilar_update
            AFTER UPDATE ON kullanicilar
            FOR EACH ROW
            BEGIN
                INSERT INTO kullanicilar_log (
                    kullanicilar_id,
                    roller_id,
                    ad,
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
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'G',
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
        Schema::dropIfExists('kullanicilar');
        Schema::dropIfExists('kullanicilar_log');
        DB::statement("DROP TRIGGER IF EXISTS kullanicilar_insert");
        DB::statement("DROP TRIGGER IF EXISTS kullanicilar_update");
    }
};
