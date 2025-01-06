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

        foreach ($tum_menuler as $menu) {
            MenuRolIliski::create([
                'roller_id'  => 1,
                'menuler_id' => $menu['menuler_id']
            ]);
        }

        MenuRolIliski::insert([
            [
                'roller_id'  => 2,
                'menuler_id' => 1
            ],
            [
                'roller_id'  => 2,
                'menuler_id' => 2
            ],
            [
                'roller_id'  => 2,
                'menuler_id' => 7
            ],
            [
                'roller_id'  => 2,
                'menuler_id' => 8
            ],
            [
                'roller_id'  => 2,
                'menuler_id' => 9
            ],
        ]);
    }
}
