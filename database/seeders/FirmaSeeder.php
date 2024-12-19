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
            'kamular_id' => 143,
            'baslik' => "Patates A.Ş.",
            'email' => "patates@harikapatatesler.com",
            'telefon' => "1234567890",
            'adres' => "Tarla",
            'website_url' => "harikapatatesler.com",
            'x_url' => "x.com/patates",
            'instagram_url' => "intagram.com/patates",
            'linkedin_url' => "linkedin.com/patatesas",
            'diger_url' => "",
        ]);
    }
}
