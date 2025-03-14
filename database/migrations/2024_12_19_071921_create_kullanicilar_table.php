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
            $table->foreignId('unvanlar_id')->constrained('unvanlar', 'unvanlar_id')->restrictOnDelete()->default(46);
            $table->foreignId('isletmeler_id')->nullable()->constrained('isletmeler', 'isletmeler_id')->restrictOnDelete();
            $table->foreignId('isletme_birimleri_id')->nullable()->constrained('isletme_birimleri', 'isletme_birimleri_id')->restrictOnDelete();
            $table->string('kod')->nullable()->default(uniqid());
            $table->string('ad', 155);
            $table->string('soyad', 155);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telefon', 155)->nullable();
            $table->string('dahiliTelefon', 155)->nullable();
            $table->string('adres', 155)->nullable();
            $table->string('profilFotoUrl', 155)->default('https://placehold.co/128');
            $table->string('password');
            $table->float('puan', 8, 2)->default(0);
            $table->integer('unipuan')->default(0);
            $table->integer('gunlukUnipuan')->default(100);
            $table->boolean('aramaIzni')->default(1);
            $table->boolean('veriGosterimIzni')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::enableForeignKeyConstraints();

        // Schema::create('kullanicilar_log', function (Blueprint $table) {
        //     $table->integer('kullanicilar_id');
        //     $table->unsignedBigInteger('unvanlar_id')->nullable();
        //     $table->unsignedBigInteger('isletmeler_id')->nullable();
        //     $table->string('kod')->nullable();
        //     $table->string('ad', 155);
        //     $table->string('soyad', 155);
        //     $table->string('email', 255)->nullable();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('telefon', 155)->nullable();
        //     $table->string('dahiliTelefon', 155)->nullable();
        //     $table->string('adres', 155)->nullable();
        //     $table->string('profileFotoUrl', 155)->nullable();
        //     $table->boolean('aramaIzni');
        //     $table->boolean('veriGosterimIzni');
        //     $table->char('yapilanIslem', 1);
        //     $table->timestamps();
        // });

        // DB::unprepared("
        //     CREATE TRIGGER kullanicilar_insert
        //     AFTER INSERT ON kullanicilar
        //     FOR EACH ROW
        //     BEGIN
        //         INSERT INTO kullanicilar_log (
        //             kullanicilar_id,
        //             unvanlar_id,
        //             isletmeler_id,
        //             kod,
        //             ad,
        //             soyad,
        //             email,
        //             email_verified_at,
        //             telefon,
        //             dahiliTelefon,
        //             adres,
        //             profileFotoUrl,
        //             aramaIzni,
        //             veriGosterimIzni,
        //             yapilanIslem,
        //             aktiflik,
        //             islem_yapan_id,
        //             created_at,
        //             updated_at
        //         )
        //         VALUES (
        //             NEW.kullanicilar_id,
        //             NEW.unvanlar_id,
        //             NEW.isletmeler_id,
        //             NEW.kod,
        //             NEW.ad,
        //             NEW.soyad,
        //             NEW.email,
        //             NEW.email_verified_at,
        //             NEW.telefon,
        //             NEW.dahiliTelefon,
        //             NEW.adres,
        //             NEW.profilFotoUrl,
        //             NEW.aramaIzni,
        //             NEW.veriGosterimIzni,
        //             'E',
        //             NEW.aktiflik,
        //             NEW.islem_yapan_id,
        //             NOW(),
        //             NOW()
        //         );
        //     END;
        // ");

        // DB::unprepared("
        //     CREATE TRIGGER kullanicilar_update
        //     AFTER UPDATE ON kullanicilar
        //     FOR EACH ROW
        //     BEGIN
        //         INSERT INTO kullanicilar_log (
        //             kullanicilar_id,
        //             unvanlar_id,
        //             isletmeler_id,
        //             kod,
        //             ad,
        //             soyad,
        //             email,
        //             email_verified_at,
        //             telefon,
        //             dahiliTelefon,
        //             adres,
        //             profileFotoUrl,
        //             aramaIzni,
        //             veriGosterimIzni,
        //             yapilanIslem,
        //             aktiflik,
        //             islem_yapan_id,
        //             created_at,
        //             updated_at
        //         )
        //         VALUES (
        //             NEW.kullanicilar_id,
        //             NEW.unvanlar_id,
        //             NEW.isletmeler_id,
        //             NEW.kod,
        //             NEW.ad,
        //             NEW.soyad,
        //             NEW.email,
        //             NEW.email_verified_at,
        //             NEW.telefon,
        //             NEW.dahiliTelefon,
        //             NEW.adres,
        //             NEW.profilFotoUrl,
        //             NEW.aramaIzni,
        //             NEW.veriGosterimIzni,
        //             'G',
        //             NEW.aktiflik,
        //             NEW.islem_yapan_id,
        //             NOW(),
        //             NOW()
        //         );
        //     END;
        // ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::unprepared("DROP TRIGGER IF EXISTS kullanicilar_insert");
        // DB::unprepared("DROP TRIGGER IF EXISTS kullanicilar_update");
        Schema::dropIfExists('kullanicilar');
        Schema::dropIfExists('password_reset_tokens');
        // Schema::dropIfExists('kullanicilar_log');
    }
};
