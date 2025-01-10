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
                'isletmeler_id'   => $isletme->isletmeler_id,
            ]);
        }

        IsletmeYetkili::create([
            'kullanicilar_id' => 2,
            'isletmeler_id'   => 143,
        ]);
        IsletmeYetkili::create([
            'kullanicilar_id' => 3,
            'isletmeler_id'   => 143,
        ]);
        IsletmeYetkili::create([
            'kullanicilar_id' => 4,
            'isletmeler_id'   => 143,
        ]);
    }
}
