<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuRolIliski;
use Illuminate\Database\Seeder;

class MenuRolIliskiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tum_menuler = Menu::all();

        $kurumYonetici = [1, 2, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42];
        $personel = [35, 15, 20, 42];

        foreach ($tum_menuler as $menu) {
            MenuRolIliski::create([
                'roller_id'  => 1,
                'menuler_id' => $menu['menuler_id']
            ]);
        }

        foreach ($kurumYonetici as $menuId) {
            MenuRolIliski::create([
                'roller_id'  => 2,
                'menuler_id' => $menuId
            ]);
        }
        foreach ($personel as $menuId) {
            MenuRolIliski::create([
                'roller_id'  => 18,
                'menuler_id' => $menuId
            ]);
        }
    }
}
