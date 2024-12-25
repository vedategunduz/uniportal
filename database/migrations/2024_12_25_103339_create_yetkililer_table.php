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

        Schema::create('yetkililer', function (Blueprint $table) {
            $table->id('yetkililer_id');
            $table->unsignedBigInteger('kullanicilar_id');
            $table->unsignedBigInteger('kamular_id')->nullable();
            $table->unsignedBigInteger('firmalar_id')->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('kullanicilar_id')->references('kullanicilar_id')->on('kullanicilar')->onDelete('restrict');
            $table->foreign('kamular_id')->references('kamular_id')->on('kamular')->onDelete('restrict');
            $table->foreign('firmalar_id')->references('firmalar_id')->on('firmalar')->onDelete('restrict');
        });

        Schema::enableForeignKeyConstraints();

        Schema::create('yetkililer_log', function (Blueprint $table) {
            $table->integer('yetkililer_id');
            $table->integer('kullanicilar_id');
            $table->integer('kamular_id')->nullable();
            $table->integer('firmalar_id')->nullable();
            $table->char('islem', 1);
            $table->timestamps();
        });

        // AFTER INSERT trigger
        DB::unprepared("
            CREATE TRIGGER yetkililer_insert
            AFTER INSERT ON yetkililer
            FOR EACH ROW
            BEGIN
                INSERT INTO yetkililer_log (
                    yetkililer_id,
                    kullanicilar_id,
                    kamular_id,
                    firmalar_id,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.yetkililer_id,
                    NEW.kullanicilar_id,
                    NEW.kamular_id,
                    NEW.firmalar_id,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");


        // AFTER UPDATE trigger
        DB::unprepared("
            CREATE TRIGGER yetkililer_update
            AFTER UPDATE ON yetkililer
            FOR EACH ROW
            BEGIN
                INSERT INTO yetkililer_log (
                    yetkililer_id,
                    kullanicilar_id,
                    kamular_id,
                    firmalar_id,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.yetkililer_id,
                    NEW.kullanicilar_id,
                    NEW.kamular_id,
                    NEW.firmalar_id,
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
        Schema::dropIfExists('yetkililer');
        Schema::dropIfExists('yetkililer_log');
        DB::statement("DROP TRIGGER IF EXISTS yetkililer_insert");
        DB::statement("DROP TRIGGER IF EXISTS yetkililer_update");
    }
};
