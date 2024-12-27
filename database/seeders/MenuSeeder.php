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
                    'menu_adi' => 'Kurum İşlemleri',
                    'menu_link' => '',
                    'menu_icon' => '',
                    'menu_aciklama' => 'Kurum işlemleri menüsü',
                    'menu_sira' => 1,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menu_adi' => 'Kurum Yönetim',
                    'menu_link' => '/kurum/yonetim',
                    'menu_icon' => '',
                    'menu_aciklama' => '',
                    'menu_sira' => 100,
                    'bagli_menuler_id' => 1,
                ],
                [
                    'menu_adi' => 'Firma İşlemleri',
                    'menu_link' => '',
                    'menu_icon' => '',
                    'menu_aciklama' => 'Firma işlemleri menüsü',
                    'menu_sira' => 2,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menu_adi' => 'Etkinlik işlemleri',
                    'menu_link' => '',
                    'menu_icon' => '',
                    'menu_aciklama' => 'Etkinlik işlemleri menüsü',
                    'menu_sira' => 3,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menu_adi' => 'Etkinlik ekle',
                    'menu_link' => '/etkinlik/ekle',
                    'menu_icon' => '',
                    'menu_aciklama' => '',
                    'menu_sira' => 300,
                    'bagli_menuler_id' => 3,
                ],
            ]
        );
    }
}
