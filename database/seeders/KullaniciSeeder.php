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
            'ad' => 'Rıfkı',
        ]);
    }
}
