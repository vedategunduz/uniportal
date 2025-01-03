<?php

namespace Database\Seeders;

use App\Models\Isletme;
use App\Models\IsletmeYetkili;
use Illuminate\Database\Seeder;

class IsletmeYetkiliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $isletmeler = Isletme::select('isletmeler_id')->get();

        foreach ($isletmeler as $isletme) {
            IsletmeYetkili::insert([
                'kullanicilar_id' => 1,
                'isletmeler_id' => $isletme->isletmeler_id,
            ]);
        }
    }
}
