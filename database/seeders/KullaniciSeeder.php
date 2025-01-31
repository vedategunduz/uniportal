<?php

namespace Database\Seeders;

use App\Models\Kullanici;
use Illuminate\Database\Seeder;

class KullaniciSeeder extends Seeder
{
    public function run(): void
    {
        Kullanici::create([
            'roller_id' => 1,
            'unvanlar_id' => 1,
            'ad'        => 'Hayati',
            'soyad'     => 'Tehlike',
            'email'     => 'admin@nku.edu.tr',
            'email_verified_at' => now(),
            'password'  => '12345600',
        ]);
        Kullanici::create([
            'roller_id'     => 2,
            'unvanlar_id' => 1,
            'ad'            => 'Evren',
            'soyad'         => 'Köksal',
            'email'         => 'ekoksal@nku.edu.tr',
            'email_verified_at' => now(),
            'password'      => '12345600',
            'telefon'      => '0532 123 45 67',
            'profilFotoUrl' => 'https://bidb.nku.edu.tr/resim.php?no=501'
        ]);
        Kullanici::create([
            'roller_id'     => 3,
            'unvanlar_id' => 3,
            'ad'            => 'Gökhan',
            'soyad'         => 'Şenlik',
            'email'         => 'gsenlik@nku.edu.tr',
            'email_verified_at' => now(),
            'password'      => '12345600',
            'telefon'       => '0532 123 45 67',
            'profilFotoUrl' => 'https://bidb.nku.edu.tr/resim.php?no=2641'
        ]);
        Kullanici::create([
            'roller_id'     => 3,
            'unvanlar_id' => 2,
            'ad'            => 'Vedat Emre',
            'soyad'         => 'Gündüz',
            'email'         => 'vgunduz@nku.edu.tr',
            'email_verified_at' => now(),
            'password'      => '12345600',
            'telefon'       => '0532 123 45 67',
            'profilFotoUrl' => 'https://avatars.githubusercontent.com/u/94452068?v=4'
        ]);
        Kullanici::create([
            'roller_id'     => 3,
            'unvanlar_id' => 1,
            'ad'            => 'Emre',
            'soyad'         => 'Gündüz',
            'email'         => 'vgunduz12@nku.edu.tr',
            'email_verified_at' => now(),
            'password'      => '12345600',
            'telefon'       => '0532 123 45 67',
            'profilFotoUrl' => 'https://avatars.githubusercontent.com/u/94452068?v=4'
        ]);
    }
}
