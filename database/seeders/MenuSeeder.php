<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert(
            [
                [
                    'menuAd' => 'Etkinlikler',
                    'menuLink' => '/etkinlikler',
                    'menuSira' => 1,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd' => 'İşletmeler',
                    'menuLink' => '/isletmeler',
                    'menuSira' => 2,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd' => 'Menü',
                    'menuLink' => '',
                    'menuSira' => 3,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd' => 'Alt menü',
                    'menuLink' => '',
                    'menuSira' => 4,
                    'bagli_menuler_id' => 3,
                ],
                [
                    'menuAd' => 'Alt menü 2',
                    'menuLink' => '',
                    'menuSira' => 5,
                    'bagli_menuler_id' => 3,
                ],
            ]
        );
    }
}
