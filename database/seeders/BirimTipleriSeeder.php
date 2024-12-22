<?php

namespace Database\Seeders;

use App\Models\BirimTip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BirimTipleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BirimTip::insert([
            ['baslik' => "fakülte"],
            ['baslik' => "enstitü"],
            ['baslik' => "yüksekokul"],
            ['baslik' => "daire başkanlığı"],
            ['baslik' => "merkez"],
            ['baslik' => "müdürlük"],
            ['baslik' => "birim"],
            ['baslik' => "meslek yüksekokulu"],
            ['baslik' => "genel idare"],
        ]);
    }
}
