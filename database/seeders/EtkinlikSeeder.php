<?php

namespace Database\Seeders;

use App\Models\Etkinlik;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EtkinlikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('tr_TR');

        Etkinlik::create([
            'etkinlik_turleri_id' => 1,
            'firmalar_id' => 1,
            'kamular_id' => null,
            'etkinlik_basvuru_tarihi' => Carbon::create(2024, 12, 22),
            'etkinlik_basvuru_bitis_tarihi' => Carbon::create(2024, 12, 24),
            'etkinlik_baslama_tarihi' => Carbon::create(2025, 1, 2),
            'etkinlik_bitis_tarihi' => Carbon::create(2025, 1, 4),
            'aciklama' => $faker->paragraph,
        ]);
    }
}
