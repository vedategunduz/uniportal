<?php

namespace Database\Seeders;

use App\Models\MesajKanal;
use Illuminate\Database\Seeder;

class MesajKanalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MesajKanal::insert([
            [
                'baslik' => 'Patates',
                'resim' => 'image/potato-transparent-background-png.webp',
                'tur' => 'ozel',
            ],
            [
                'baslik' => 'Domates',
                'resim' =>  'image/domates.jpg',
                'tur' => 'ozel',
            ],
            [
                'baslik' => 'Marul',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
        ]);
    }
}
