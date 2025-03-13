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
                // 1
                [
                    'menuAd'           => 'Dashboard',
                    'menuLink'         => '/yonetim',
                    'menuSira'         => 1,
                    'menuIcon'         => '<i class="bi bi-grid-fill"></i>',
                    'bagli_menuler_id' => null,
                ],
                // 2
                [
                    'menuAd'           => 'Etkinlikler',
                    'menuLink'         => '/yonetim/etkinlikler',
                    'menuSira'         => 550,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                // 3
                [
                    'menuAd'           => 'İşletmeler',
                    'menuLink'         => '',
                    'menuSira'         => 300,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-buildings-fill size-4" viewBox="0 0 16 16"><path d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zM2 11h1v1H2zm2 0h1v1H4zm-1 2v1H2v-1zm1 0h1v1H4zm9-10v1h-1V3zM8 5h1v1H8zm1 2v1H8V7zM8 9h1v1H8zm2 0h1v1h-1zm-1 2v1H8v-1zm1 0h1v1h-1zm3-2v1h-1V9zm-1 2h1v1h-1zm-2-4h1v1h-1zm3 0v1h-1V7zm-2-2v1h-1V5zm1 0h1v1h-1z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 4
                [
                    'menuAd'           => 'Kamular',
                    'menuLink'         => '/yonetim/isletmeler/kamular',
                    'menuSira'         => 320,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 3,
                ],
                // 5
                [
                    'menuAd'           => 'Firmalar',
                    'menuLink'         => '/yonetim/isletmeler/firmalar',
                    'menuSira'         => 310,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 3,
                ],
                // 6
                [
                    'menuAd'           => 'Sendikalar',
                    'menuLink'         => '/yonetim/isletmeler/sendikalar',
                    'menuSira'         => 330,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 3,
                ],
                // 7
                [
                    'menuAd'           => 'Yönetici işlemleri',
                    'menuLink'         => '',
                    'menuSira'         => 400,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-diagram-3-fill size-4" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zm-6 8A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm6 0A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 8
                [
                    'menuAd'           => 'Birim işlemleri',
                    'menuLink'         => '/yonetim/birimler',
                    'menuSira'         => 420,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 7,
                ],
                // 9
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
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-fill-gear size-4" viewBox="0 0 16 16"><path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7.256A4.5 4.5 0 0 0 12.5 8a4.5 4.5 0 0 0-3.59 1.787A.5.5 0 0 0 9 9.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .39-.187A4.5 4.5 0 0 0 8.027 12H6.5a.5.5 0 0 0-.5.5V16H3a1 1 0 0 1-1-1zm2 1.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3 0v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/><path d="M11.886 9.46c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/></svg>',
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
                    'menuAd'           => 'Toplantılar/Ziyaretler',
                    'menuLink'         => '/',
                    'menuSira'         => 600,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill size-4" viewBox="0 0 16 16"><path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5"/><path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 15
                [
                    'menuAd'           => 'Döküman işlemleri',
                    'menuLink'         => '/',
                    'menuSira'         => 700,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text-fill size-4" viewBox="0 0 16 16"><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1"/></svg>',
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
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line-fill size-4" viewBox="0 0 16 16"><path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z"/></svg>',
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
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-pulse-fill size-4" viewBox="0 0 16 16"><path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5"/><path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z"/></svg>',
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
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard-fill size-4" viewBox="0 0 16 16"><path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z"/><path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 35
                [
                    'menuAd'           => 'Kişisel',
                    'menuLink'         => '/',
                    'menuSira'         => 5,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear size-4" viewBox="0 0 16 16"><path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 36
                [
                    'menuAd'           => 'Takvim',
                    'menuLink'         => '/',
                    'menuSira'         => 3000,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week-fill size-4" viewBox="0 0 16 16"><path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 37
                [
                    'menuAd'           => 'İş Takip',
                    'menuLink'         => '/',
                    'menuSira'         => 20,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stack-overflow size-4" viewBox="0 0 16 16"><path d="M12.412 14.572V10.29h1.428V16H1v-5.71h1.428v4.282z"/><path d="M3.857 13.145h7.137v-1.428H3.857zM10.254 0 9.108.852l4.26 5.727 1.146-.852zm-3.54 3.377 5.484 4.567.913-1.097L7.627 2.28l-.914 1.097zM4.922 6.55l6.47 3.013.603-1.294-6.47-3.013zm-.925 3.344 6.985 1.469.294-1.398-6.985-1.468z"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 38
                [
                    'menuAd'           => 'Ziyaret talep',
                    'menuLink'         => '/yonetim/toplantilar/ziyaretler',
                    'menuSira'         => 605,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 14,
                ],
                // 39
                [
                    'menuAd'           => 'Error',
                    'menuLink'         => '',
                    'menuSira'         => 4000,
                    'menuIcon'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill size-4" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/></svg>',
                    'bagli_menuler_id' => null,
                ],
                // 40
                [
                    'menuAd'           => '403',
                    'menuLink'         => 'error/403',
                    'menuSira'         => 4003,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 39,
                ],
                // 41
                [
                    'menuAd'           => '404',
                    'menuLink'         => 'error/404',
                    'menuSira'         => 4004,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 39,
                ],
                // 42
                [
                    'menuAd'           => 'İşlerim',
                    'menuLink'         => '',
                    'menuSira'         => 50,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 37,
                ],
                // 43
                [
                    'menuAd'           => 'İş Taleplerim',
                    'menuLink'         => '',
                    'menuSira'         => 55,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 37,
                ],
                // 44
                [
                    'menuAd'           => 'Bekleyen işler',
                    'menuLink'         => '',
                    'menuSira'         => 60,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 37,
                ],
                // 45
                [
                    'menuAd'           => 'İş Raporu',
                    'menuLink'         => '',
                    'menuSira'         => 2050,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 28,
                ],
                // 46
                [
                    'menuAd'           => 'Kampanyalar',
                    'menuLink'         => '/yonetim/kampanyalar',
                    'menuSira'         => 560,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                // 47
                [
                    'menuAd'           => 'Ürünler',
                    'menuLink'         => '/yonetim/urunler',
                    'menuSira'         => 510,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 10,
                ],
                // 48
                [
                    'menuAd'           => 'Profil',
                    'menuLink'         => '/yonetim/kullanici',
                    'menuSira'         => 20,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 35,
                ],
                // 49
                [
                    'menuAd'           => 'Paylaşımlar',
                    'menuLink'         => '/yonetim/kullanici/paylasimlar',
                    'menuSira'         => 25,
                    'menuIcon'         => '',
                    'bagli_menuler_id' => 35,
                ]
            ]
        );
    }
}
