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
                    'menuAd' => 'Kurum İşlemleri',
                    'menuLink' => '',
                    'menuIcon' => '',
                    'menuAciklama' => 'Kurum işlemleri menüsü',
                    'menuSira' => 1,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd' => 'Kurum Yönetim',
                    'menuLink' => '/kurum/yonetim',
                    'menuIcon' => '',
                    'menuAciklama' => '',
                    'menuSira' => 100,
                    'bagli_menuler_id' => 1,
                ],
                [
                    'menuAd' => 'Firma İşlemleri',
                    'menuLink' => '',
                    'menuIcon' => '',
                    'menuAciklama' => 'Firma işlemleri menüsü',
                    'menuSira' => 2,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd' => 'Etkinlik işlemleri',
                    'menuLink' => '',
                    'menuIcon' => '',
                    'menuAciklama' => 'Etkinlik işlemleri menüsü',
                    'menuSira' => 3,
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd' => 'Etkinlikler',
                    'menuLink' => '/etkinlikler',
                    'menuIcon' => '',
                    'menuAciklama' => '',
                    'menuSira' => 300,
                    'bagli_menuler_id' => 4,
                ],
                [
                    'menuAd' => 'Etkinlik ekle',
                    'menuLink' => '/etkinlikler/ekle',
                    'menuIcon' => '',
                    'menuAciklama' => '',
                    'menuSira' => 301,
                    'bagli_menuler_id' => 4,
                ],
            ]
        );
    }
}
