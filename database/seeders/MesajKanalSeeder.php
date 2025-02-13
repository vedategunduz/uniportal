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
                'resim' =>  'image/salatalık.webp',
                'tur' => 'ozel',
            ],
            // 5
            [
                'baslik' => 'Mısır',
                'resim' =>  'image/mısır.jpg',
                'tur' => 'ozel',
            ],
            // 6
            [
                'baslik' => 'Soğan',
                'resim' =>  'image/sogan.jpeg',
                'tur' => 'ozel',
            ],
            // 7
            [
                'baslik' => 'Tereyağ',
                'resim' =>  'image/tereyag.jpg',
                'tur' => 'ozel',
            ],
            // 8
            [
                'baslik' => 'Un',
                'resim' =>  'image/un.jpg',
                'tur' => 'ozel',
            ],
            // 9
            [
                'baslik' => 'Şeker',
                'resim' =>  'image/seker.jpg',
                'tur' => 'ozel',
            ],
            // 10
            [
                'baslik' => 'Helva',
                'resim' =>  'image/helva.jpg',
                'tur' => 'ozel',
            ],
            // 11
            [
                'baslik' => 'Bal',
                'resim' =>  'image/bal.jpg',
                'tur' => 'ozel',
            ],
            // 12
            [
                'baslik' => 'Peynir',
                'resim' =>  'image/peynir.jpeg',
                'tur' => 'ozel',
            ],
            // 13
            [
                'baslik' => 'Reçel',
                'resim' =>  'image/recel.jpg',
                'tur' => 'ozel',
            ],
        ]);
    }
}
