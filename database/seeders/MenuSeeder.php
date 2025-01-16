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
                    'menuAd'           => 'Anasayfa(Dashboard)',
                    'menuLink'         => '/yonetim',
                    'menuSira'         => 1,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>',
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd'           => 'Etkinlikler',
                    'menuLink'         => '/yonetim/etkinlikler',
                    'menuSira'         => 550,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                [
                    'menuAd'           => 'İşletmeler',
                    'menuLink'         => '',
                    'menuSira'         => 300,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>',
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd'           => 'Kamular',
                    'menuLink'         => '/yonetim/isletmeler/kamular',
                    'menuSira'         => 320,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 3,
                ],
                [
                    'menuAd'           => 'Firmalar',
                    'menuLink'         => '/yonetim/isletmeler/firmalar',
                    'menuSira'         => 310,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 3,
                ],
                [
                    'menuAd'           => 'Sendikalar',
                    'menuLink'         => '/yonetim/isletmeler/sendikalar',
                    'menuSira'         => 330,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 3,
                ],
                [
                    'menuAd'           => 'Yönetici işlemleri',
                    'menuLink'         => '',
                    'menuSira'         => 400,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="size-6"><path d="M224 0a128 128 0 1 1 0 256A128 128 0 1 1 224 0zM178.3 304l91.4 0c11.8 0 23.4 1.2 34.5 3.3c-2.1 18.5 7.4 35.6 21.8 44.8c-16.6 10.6-26.7 31.6-20 53.3c4 12.9 9.4 25.5 16.4 37.6s15.2 23.1 24.4 33c15.7 16.9 39.6 18.4 57.2 8.7l0 .9c0 9.2 2.7 18.5 7.9 26.3L29.7 512C13.3 512 0 498.7 0 482.3C0 383.8 79.8 304 178.3 304zM436 218.2c0-7 4.5-13.3 11.3-14.8c10.5-2.4 21.5-3.7 32.7-3.7s22.2 1.3 32.7 3.7c6.8 1.5 11.3 7.8 11.3 14.8l0 30.6c7.9 3.4 15.4 7.7 22.3 12.8l24.9-14.3c6.1-3.5 13.7-2.7 18.5 2.4c7.6 8.1 14.3 17.2 20.1 27.2s10.3 20.4 13.5 31c2.1 6.7-1.1 13.7-7.2 17.2l-25 14.4c.4 4 .7 8.1 .7 12.3s-.2 8.2-.7 12.3l25 14.4c6.1 3.5 9.2 10.5 7.2 17.2c-3.3 10.6-7.8 21-13.5 31s-12.5 19.1-20.1 27.2c-4.8 5.1-12.5 5.9-18.5 2.4l-24.9-14.3c-6.9 5.1-14.3 9.4-22.3 12.8l0 30.6c0 7-4.5 13.3-11.3 14.8c-10.5 2.4-21.5 3.7-32.7 3.7s-22.2-1.3-32.7-3.7c-6.8-1.5-11.3-7.8-11.3-14.8l0-30.5c-8-3.4-15.6-7.7-22.5-12.9l-24.7 14.3c-6.1 3.5-13.7 2.7-18.5-2.4c-7.6-8.1-14.3-17.2-20.1-27.2s-10.3-20.4-13.5-31c-2.1-6.7 1.1-13.7 7.2-17.2l24.8-14.3c-.4-4.1-.7-8.2-.7-12.4s.2-8.3 .7-12.4L343.8 325c-6.1-3.5-9.2-10.5-7.2-17.2c3.3-10.6 7.7-21 13.5-31s12.5-19.1 20.1-27.2c4.8-5.1 12.4-5.9 18.5-2.4l24.8 14.3c6.9-5.1 14.5-9.4 22.5-12.9l0-30.5zm92.1 133.5a48.1 48.1 0 1 0 -96.1 0 48.1 48.1 0 1 0 96.1 0z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                [
                    'menuAd'           => 'Birim işlemleri',
                    'menuLink'         => '/yonetim/birimler',
                    'menuSira'         => 420,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 7,
                ],
                [
                    'menuAd'           => 'Kullanici işlemleri',
                    'menuLink'         => '/yonetim/kullanicilar',
                    'menuSira'         => 430,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 7,
                ],
                // 10
                [
                    'menuAd'           => 'Kurum işlemleri',
                    'menuLink'         => '/',
                    'menuSira'         => 500,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 11
                [
                    'menuAd'           => 'Sarf istek/fazla',
                    'menuLink'         => '/',
                    'menuSira'         => 580,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                // 12
                [
                    'menuAd'           => 'Sponsor talepleri',
                    'menuLink'         => '/',
                    'menuSira'         => 590,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                // 13
                [
                    'menuAd'           => 'Ortak alım talepleri',
                    'menuLink'         => '/',
                    'menuSira'         => 570,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                // 14
                [
                    'menuAd'           => 'Toplantılar',
                    'menuLink'         => '/',
                    'menuSira'         => 600,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 640 512"><path d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176L96 176l0 128c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7c0 0 0 0 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128l38.9 0 40 0 40 0c8.8 0 16 7.2 16 16l0 208c0 17.7-14.3 32-32 32l-32 0c-11.8 0-22.2-6.4-27.7-16l-84.9 0c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384l-32 0c-17.7 0-32-14.3-32-32L0 144c0-8.8 7.2-16 16-16l40 0 40 0 19.8 0c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64L259 64c4.4 0 8.9 .2 13.2 .6zM544 320l0-144-48 0c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1l74.8 0zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 15
                [
                    'menuAd'           => 'Döküman işlemleri',
                    'menuLink'         => '/',
                    'menuSira'         => 700,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 512 512"><path d="M184 48l144 0c4.4 0 8 3.6 8 8l0 40L176 96l0-40c0-4.4 3.6-8 8-8zm-56 8l0 40L64 96C28.7 96 0 124.7 0 160l0 96 192 0 128 0 192 0 0-96c0-35.3-28.7-64-64-64l-64 0 0-40c0-30.9-25.1-56-56-56L184 0c-30.9 0-56 25.1-56 56zM512 288l-192 0 0 32c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-32L0 288 0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-128z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 16
                [
                    'menuAd'           => 'Döküman yönetim',
                    'menuLink'         => '/',
                    'menuSira'         => 710,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 15,
                ],
                // 17
                [
                    'menuAd'           => 'Döküman oluştur',
                    'menuLink'         => '/',
                    'menuSira'         => 720,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 15,
                ],
                // 18
                [
                    'menuAd'           => 'Döküman birim onay',
                    'menuLink'         => '/',
                    'menuSira'         => 740,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 15,
                ],
                // 19
                [
                    'menuAd'           => 'Döküman onay',
                    'menuLink'         => '/',
                    'menuSira'         => 730,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 15,
                ],
                // 20
                [
                    'menuAd'           => 'Döküman incele',
                    'menuLink'         => '/',
                    'menuSira'         => 750,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 15,
                ],
                // 21
                [
                    'menuAd'           => 'Gösterge işlemleri',
                    'menuLink'         => '/',
                    'menuSira'         => 800,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 576 512"><path d="M304 240l0-223.4c0-9 7-16.6 16-16.6C443.7 0 544 100.3 544 224c0 9-7.6 16-16.6 16L304 240zM32 272C32 150.7 122.1 50.3 239 34.3c9.2-1.3 17 6.1 17 15.4L256 288 412.5 444.5c6.7 6.7 6.2 17.7-1.5 23.1C371.8 495.6 323.8 512 272 512C139.5 512 32 404.6 32 272zm526.4 16c9.3 0 16.6 7.8 15.4 17c-7.7 55.9-34.6 105.6-73.9 142.3c-6 5.6-15.4 5.2-21.2-.7L320 288l238.4 0z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 22
                [
                    'menuAd'           => 'İzlem göstergeleri',
                    'menuLink'         => '/',
                    'menuSira'         => 850,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 21,
                ],
                // 23
                [
                    'menuAd'           => 'İG yönetim',
                    'menuLink'         => '/',
                    'menuSira'         => 860,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 22,
                ],
                // 24
                [
                    'menuAd'           => 'İG giriş',
                    'menuLink'         => '/',
                    'menuSira'         => 865,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 22,
                ],
                // 25
                [
                    'menuAd'           => 'Stratejik plan',
                    'menuLink'         => '/',
                    'menuSira'         => 870,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 21,
                ],
                // 26
                [
                    'menuAd'           => 'SP yönetim',
                    'menuLink'         => '/',
                    'menuSira'         => 875,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 25,
                ],
                // 27
                [
                    'menuAd'           => 'SP giriş',
                    'menuLink'         => '/',
                    'menuSira'         => 880,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 25,
                ],
                // 28
                [
                    'menuAd'           => 'Raporlar',
                    'menuLink'         => '/',
                    'menuSira'         => 2000,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M256 398.8c-11.8 5.1-23.4 9.7-34.9 13.5c16.7 33.8 31 35.7 34.9 35.7s18.1-1.9 34.9-35.7c-11.4-3.9-23.1-8.4-34.9-13.5zM446 256c33 45.2 44.3 90.9 23.6 128c-20.2 36.3-62.5 49.3-115.2 43.2c-22 52.1-55.6 84.8-98.4 84.8s-76.4-32.7-98.4-84.8c-52.7 6.1-95-6.8-115.2-43.2C21.7 346.9 33 301.2 66 256c-33-45.2-44.3-90.9-23.6-128c20.2-36.3 62.5-49.3 115.2-43.2C179.6 32.7 213.2 0 256 0s76.4 32.7 98.4 84.8c52.7-6.1 95 6.8 115.2 43.2c20.7 37.1 9.4 82.8-23.6 128zm-65.8 67.4c-1.7 14.2-3.9 28-6.7 41.2c31.8 1.4 38.6-8.7 40.2-11.7c2.3-4.2 7-17.9-11.9-48.1c-6.8 6.3-14 12.5-21.6 18.6zm-6.7-175.9c2.8 13.1 5 26.9 6.7 41.2c7.6 6.1 14.8 12.3 21.6 18.6c18.9-30.2 14.2-44 11.9-48.1c-1.6-2.9-8.4-13-40.2-11.7zM290.9 99.7C274.1 65.9 259.9 64 256 64s-18.1 1.9-34.9 35.7c11.4 3.9 23.1 8.4 34.9 13.5c11.8-5.1 23.4-9.7 34.9-13.5zm-159 88.9c1.7-14.3 3.9-28 6.7-41.2c-31.8-1.4-38.6 8.7-40.2 11.7c-2.3 4.2-7 17.9 11.9 48.1c6.8-6.3 14-12.5 21.6-18.6zM110.2 304.8C91.4 335 96 348.7 98.3 352.9c1.6 2.9 8.4 13 40.2 11.7c-2.8-13.1-5-26.9-6.7-41.2c-7.6-6.1-14.8-12.3-21.6-18.6zM336 256a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zm-80-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 29
                [
                    'menuAd'           => 'İG Raporu',
                    'menuLink'         => '/',
                    'menuSira'         => 2010,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 28,
                ],
                // 30
                [
                    'menuAd'           => 'SP Raporu',
                    'menuLink'         => '/',
                    'menuSira'         => 2020,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 28,
                ],
                // 31
                [
                    'menuAd'           => 'Kurum Yönetim',
                    'menuLink'         => '/',
                    'menuSira'         => 410,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 7,
                ],
                // 32
                [
                    'menuAd'           => 'Toplantı talep',
                    'menuLink'         => '/',
                    'menuSira'         => 610,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 14,
                ],
                // 33
                [
                    'menuAd'           => 'Geçmiş toplantılar',
                    'menuLink'         => '/',
                    'menuSira'         => 620,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 14,
                ],
                // 34
                [
                    'menuAd'           => 'Eğitimler',
                    'menuLink'         => '/',
                    'menuSira'         => 650,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 35
                [
                    'menuAd'           => 'Profil',
                    'menuLink'         => '/',
                    'menuSira'         => 5,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l293.1 0c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1l-91.4 0zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 36
                [
                    'menuAd'           => 'Takvim',
                    'menuLink'         => '/',
                    'menuSira'         => 3000,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 37
                [
                    'menuAd'           => 'İşlerim',
                    'menuLink'         => '/',
                    'menuSira'         => 20,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l293.1 0c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1l-91.4 0zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
            ]
        );
    }
}
