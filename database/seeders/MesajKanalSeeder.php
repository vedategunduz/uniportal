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
            // 1
            [
                'baslik' => 'Patates',
                'resim' => 'image/potato-transparent-background-png.webp',
                'tur' => 'ozel',
            ],
            // 2
            [
                'baslik' => 'Domates',
                'resim' =>  'image/domates.jpg',
                'tur' => 'ozel',
            ],
            // 3
            [
                'baslik' => 'Marul',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 4
            [
                'baslik' => 'Salatalık',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 5
            [
                'baslik' => 'Mısır',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 6
            [
                'baslik' => 'Soğan',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 7
            [
                'baslik' => 'Tereyağ',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 8
            [
                'baslik' => 'Un',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 9
            [
                'baslik' => 'Şeker',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
            // 10
            [
                'baslik' => 'Helva',
                'resim' =>  'image/marul.png',
                'tur' => 'ozel',
            ],
        ]);
    }
}
