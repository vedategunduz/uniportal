<?php

namespace Database\Seeders;

use App\Models\Kullanici;
use Illuminate\Database\Seeder;

class KullaniciSeeder extends Seeder
{
    public function run(): void
    {
        Kullanici::create(
            [
                'roller_id' => 1,
                'ad' => 'Hayati',
                'soyad' => 'Tehlike',
                'email' => 'admin@nku.edu.tr',
                'password' => '12345600',
            ]
        );
        Kullanici::create(
            [
                'roller_id' => 2,
                'ad' => 'Evren',
                'soyad' => 'Köksal',
                'email' => 'ziyaretci@nku.edu.tr',
                'password' => '12345600',
            ]
        );
        Kullanici::create(
            [
                'roller_id' => 2,
                'ad' => 'Gökhan',
                'soyad' => 'Şenlik',
                'email' => 'ziyaretci2@nku.edu.tr',
                'password' => '12345600',
            ]
        );
        Kullanici::create(
            [
                'roller_id' => 2,
                'ad' => 'Vedat Emre',
                'soyad' => 'Gündüz',
                'email' => 'ziyaretci3@nku.edu.tr',
                'password' => '12345600',
            ]
        );
    }
}
