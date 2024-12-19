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
            MenuRolIliski::create(
                [
                    'roller_id' => 1,
                    'menuler_id' => $menu['menuler_id']
                ]
            );
        }
    }
}
