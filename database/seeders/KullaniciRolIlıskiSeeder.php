<?php

namespace Database\Seeders;

use App\Models\Kullanici;
use App\Models\KullaniciRolIliski;
use Illuminate\Database\Seeder;

class KullaniciRolIlıskiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kullanicilar = Kullanici::whereIn('kullanicilar_id', [2])->get();

        KullaniciRolIliski::create([
            'kullanicilar_id' => 1,
            'roller_id' => 1,
        ]);
        KullaniciRolIliski::create([
            'kullanicilar_id' => 2,
            'roller_id' => 2,
        ]);
        KullaniciRolIliski::create([
            'kullanicilar_id' => 2,
            'roller_id' => 18,
        ]);

        // foreach ($kullanicilar as $kullanici) {
        //     foreach (range(1, 18) as $rolId) {
        //         KullaniciRolIliski::create([
        //             'kullanicilar_id' => $kullanici->kullanicilar_id,
        //             'roller_id' => $rolId,
        //         ]);
        //     }
        // }
    }
}
