<?php

namespace App\Providers;

use App\Models\EtkinlikTur;
use App\Models\Il;
use App\Models\Isletme;
use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;
use App\Models\Menu;
use App\Models\MenuRolIliski;
use App\Models\MesajKanal;
use App\Models\MesajKanalKatilimci;
use App\Models\SohbetKanalKatilimci;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['yonetim.*', 'personel.*', 'components.menu.*'], function ($view) {
            if (Auth::check()) {
                $roller = Kullanici::find(Auth::user()->kullanicilar_id)->roller()->pluck('roller_id');
                $menuler_id = MenuRolIliski::whereIn('roller_id', $roller)->pluck('menuler_id');

                $isletmeler = Isletme::isletmelerimiGetir();

                $bildirimler = [];

                $birimeYerlesmemisPersonelSayisi = 0;

                foreach ($isletmeler as $isletme) {
                    $birimeYerlesmemisPersonelSayisi += KullaniciBirimUnvan::birimeYerlesmemisPersonelSayisi($isletme->isletmeler_id);
                }

                $bildirimler['birimeYerlesmemisPersonelSayisi'] = $birimeYerlesmemisPersonelSayisi;
                $bildirimler['mesajlar'] = "5 yeni mesajınız var.";

                $menuler =
                    Menu::whereIn('menuler_id', $menuler_id)
                    ->whereNull('bagli_menuler_id')
                    ->orderBy('menuSira', 'asc')
                    ->get();

                $view->with(compact('menuler', 'isletmeler', 'bildirimler'));
            }
        });

        View::composer(['layouts.auth'], function ($view) {

            // $kanallar = Kullanici::mesajKanallari();
            $kanallar = Kullanici::aktifMesajKanallari();

            $view->with(compact('kanallar'));
        });

        View::composer('components.etkinlik.*', function ($view) {
            if (Auth::check()) {
                $isletmeler = IsletmeYetkili::aitOldugumIsletmeleriGetir();
                $isletmeler = Isletme::select('isletmeler_id', 'baslik')->whereIn('isletmeler_id', $isletmeler)->get();

                $etkinlikTurleri = EtkinlikTur::select('etkinlik_turleri_id', 'baslik')->where('tip', 1)->orderBy('baslik', 'asc')->get();
                $iller = Il::select('iller_id', 'baslik')->get();

                $view->with(compact('isletmeler', 'etkinlikTurleri', 'iller'));
            }
        });

        View::composer('components.birim-data-table', function ($view) {
            if (Auth::check()) {
                $isletmeler = IsletmeYetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)->pluck('isletmeler_id');

                $isletmeBirimleri = IsletmeBirim::whereIn('isletmeler_id', $isletmeler)
                    ->where('aktiflik', 1)
                    ->orderBy('baslik', 'asc')
                    ->get();

                $view->with(compact('isletmeler', 'isletmeBirimleri'));
            }
        });

        View::composer('yonetim.birimler.components.personel-popover-cart', function ($view) {
            if (Auth::check()) {
                $isletmeler = IsletmeYetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)->pluck('isletmeler_id');

                $isletmeBirimleri = IsletmeBirim::whereIn('isletmeler_id', $isletmeler)
                    ->where('aktiflik', 1)
                    ->orderBy('baslik', 'asc')
                    ->get();

                $view->with(compact('isletmeler', 'isletmeBirimleri'));
            }
        });
    }
}
