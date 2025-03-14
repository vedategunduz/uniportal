<?php

namespace Database\Seeders;

use App\Models\Kullanici;
use Illuminate\Database\Seeder;

class KullaniciSeeder extends Seeder
{
    public function run(): void
    {
        Kullanici::create([
            'unvanlar_id'          => 1,
            'isletmeler_id'        => 156,
            'isletme_birimleri_id' => 121,
            'kod'                  => uniqid(),
            'ad'                   => 'Hayati',
            'soyad'                => 'Tehlike',
            'email'                => 'admin@nku.edu.tr',
            'email_verified_at'    => now(),
            'password'             => '12345600',
        ]);
        Kullanici::create([
            'unvanlar_id'          => 2,
            'isletmeler_id'        => 143,
            'isletme_birimleri_id' => 44,
            'kod'                  => uniqid(),
            'ad'                   => 'Evren',
            'soyad'                => 'Köksal',
            'email'                => 'ekoksal@nku.edu.tr',
            'email_verified_at'    => now(),
            'password'             => '12345600',
            'telefon'              => '0532 123 45 67',
            'profilFotoUrl'        => 'https://bidb.nku.edu.tr/resim.php?no=501'
        ]);
        Kullanici::create([
            'unvanlar_id'          => 4,
            'isletmeler_id'        => 143,
            'isletme_birimleri_id' => 44,
            'kod'                  => uniqid(),
            'ad'                   => 'Gökhan',
            'soyad'                => 'Şenlik',
            'email'                => 'gsenlik@nku.edu.tr',
            'email_verified_at'    => now(),
            'password'             => '12345600',
            'telefon'              => '0532 123 45 67',
            'profilFotoUrl'        => 'https://bidb.nku.edu.tr/resim.php?no=2641'
        ]);
        Kullanici::create([
            'unvanlar_id'          => 3,
            'isletmeler_id'        => 143,
            'isletme_birimleri_id' => 44,
            'kod'                  => uniqid(),
            'ad'                   => 'Vedat Emre',
            'soyad'                => 'Gündüz',
            'email'                => 'vgunduz@nku.edu.tr',
            'email_verified_at'    => now(),
            'password'             => '12345600',
            'telefon'              => '0532 123 45 67',
            'profilFotoUrl'        => 'https://avatars.githubusercontent.com/u/94452068?v=4'
        ]);
        Kullanici::create([
            'unvanlar_id'       => 1,
            'isletmeler_id'     => 2,
            'isletme_birimleri_id' => 121,
            'kod'               => uniqid(),
            'ad'                => 'Emre',
            'soyad'             => 'Gündüz',
            'email'             => 'vgunduz12@nku.edu.tr',
            'email_verified_at' => now(),
            'password'          => '12345600',
            'telefon'           => '0532 123 45 67',
            'profilFotoUrl'     => 'https://avatars.githubusercontent.com/u/94452068?v=4'
        ]);

        Kullanici::create([
            'unvanlar_id'       => 1,
            'isletmeler_id'     => 156,
            'isletme_birimleri_id' => 121,
            'kod'               => uniqid(),
            'ad'                => 'UniPortal',
            'soyad'             => 'Sistem',
            'email'             => 'sistem@uniportal.tr',
            'email_verified_at' => now(),
            'password'          => '12345600',
        ]);

        Kullanici::create([
            'unvanlar_id'          => 2,
            'isletmeler_id'        => 143,
            'isletme_birimleri_id' => 42,
            'kod'                  => uniqid(),
            'ad'                   => 'Mümin',
            'soyad'                => 'Kasap',
            'email'                => 'mkasap@nku.edu.tr',
            'email_verified_at'    => now(),
            'password'             => '12345600',
            'telefon'              => '0543 555 44 33',
            'profilFotoUrl'        => 'https://bidb.nku.edu.tr/resim.php?no=1477'
        ]);
    }
}
