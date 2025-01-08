<?php

namespace App\Providers;

use App\Models\EtkinlikTur;
use App\Models\Il;
use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use App\Models\Menu;
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
        View::composer('yonetim.*', function ($view) {
            if (Auth::check()) {
                $menuler = Menu::whereHas('MenuRolDetayi', function ($query) {
                    $query->where('roller_id', Auth::user()->roller_id);
                })
                    ->with('altMenuler')
                    ->whereNull('bagli_menuler_id')
                    ->orderBy('menuSira')
                    ->get();

                $view->with(compact('menuler'));
            }
        });

        View::composer('components.etkinlik-modal', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                $isletmeler = IsletmeYetkili::select('isletmeler_id')
                    ->with(['isletmeBilgileri' => function ($query) {
                        $query->select('isletmeler_id', 'baslik');
                    }])
                    ->where('kullanicilar_id', $user->kullanicilar_id)
                    ->get();

                $etkinlikTurleri = EtkinlikTur::select('etkinlik_turleri_id', 'baslik')->get();
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
    }
}
