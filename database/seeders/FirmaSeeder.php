<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Firma;

class FirmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Firma::create([
            'kamular_id' => 1,
            'baslik' => "patates",
            'email' => "patates",
            'telefon' => "patates",
            'adres' => "patates",
            'website_url' => "patates",
        ]);
    }
}
