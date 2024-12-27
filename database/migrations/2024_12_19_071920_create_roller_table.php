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
        Schema::create('roller', function (Blueprint $table) {
            $table->id('roller_id');
            $table->string('baslik');
            $table->timestamps();
        });

        Schema::create('roller_log', function (Blueprint $table) {
            $table->integer('roller_id');
            $table->string('baslik');
            $table->char('yapilanIslem', 1);
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER roller_insert
            AFTER INSERT ON roller
            FOR EACH ROW
            BEGIN
                INSERT INTO roller_log (
                    roller_id,
                    baslik,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.roller_id,
                    NEW.baslik,
                    'E',
                    NEW.aktiflik,
                    NEW.islem_yapan_id,
                    NOW(),
                    NOW()
                );
            END;
        ");
        DB::unprepared("
            CREATE TRIGGER roller_update
            AFTER UPDATE ON roller
            FOR EACH ROW
            BEGIN
                INSERT INTO roller_log (
                    roller_id,
                    baslik,
                    yapilanIslem,
                    aktiflik,
                    islem_yapan_id,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.roller_id,
                    NEW.baslik,
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
        Schema::dropIfExists('roller');
        Schema::dropIfExists('roller_log');
        DB::unprepared("DROP TRIGGER IF EXISTS roller_log_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS roller_log_update");
    }
};
