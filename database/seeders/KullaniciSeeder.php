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
                'ad' => 'big',
                'soyad' => 'admin',
                'email' => 'admin@nku.edu.tr',
                'password' => '12345600',
            ]
        );
        Kullanici::create(
            [
                'roller_id' => 2,
                'ad' => 'Jhon',
                'soyad' => 'Doe',
                'email' => 'ziyaretci@nku.edu.tr',
                'password' => '12345600',
            ]
        );
    }
}
