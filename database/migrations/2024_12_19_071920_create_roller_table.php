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
            $table->string('tur');
            $table->timestamps();
        });

        Schema::create('roller_log', function (Blueprint $table) {
            $table->integer('roller_id');
            $table->string('tur');
            $table->char('islem', 1);
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER roller_insert
            AFTER INSERT ON roller
            FOR EACH ROW
            BEGIN
                INSERT INTO roller_log (
                    roller_id,
                    tur,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.roller_id,
                    NEW.tur,
                    NEW.islem_yapan_id,
                    NEW.aktiflik,
                    'E',
                    NOW(),
                    NOW()
                );
            END;
        ");
        DB::statement("
            CREATE TRIGGER roller_update
            AFTER UPDATE ON roller
            FOR EACH ROW
            BEGIN
                INSERT INTO roller_log (
                    roller_id,
                    tur,
                    islem_yapan_id,
                    aktiflik,
                    islem,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.roller_id,
                    NEW.tur,
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
        Schema::dropIfExists('roller');
        Schema::dropIfExists('roller_log');
        DB::statement("DROP TRIGGER IF EXISTS roller_log_insert");
        DB::statement("DROP TRIGGER IF EXISTS roller_log_update");
    }
};
