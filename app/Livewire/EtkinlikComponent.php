<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Etkinlik;
use Illuminate\Support\Facades\Auth;

class EtkinlikComponent extends Component
{
    public $etkinlikler;
    public $count = 0;
    public $loadSize = 4;
    public $today;
    public $global = 0;
    public $totalEtkinlik;

    public function mount()
    {
        $this->today = Carbon::today();

        $this->totalEtkinlik = Etkinlik::where('etkinlik_turleri_id', '<=', 2)
            ->when(!Auth::check(), function ($query) {
                return $query->where('katilimTipi', 'genel');
            })
            ->count();
        // Önce gelecek etkinlikleri al

        $gelecekEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
            ->where('etkinlik_turleri_id', '<=', 2)
            ->where(function ($query) {
                $query->where('etkinlikBaslamaTarihi', '>=', $this->today)
                    ->orWhere('etkinlikBitisTarihi', '>=', $this->today);
            })
            ->when(!Auth::check(), function ($query) {
                return $query->where('katilimTipi', 'genel');
            })
            ->orderBy('etkinlikBaslamaTarihi', 'asc')
            ->skip(0)
            ->take($this->loadSize)
            ->get();

        // Eğer gelecek etkinlikler azsa, eksik kısmı geçmiş etkinliklerle doldur
        $eksikSayisi = $this->loadSize - $gelecekEtkinlikler->count();

        if ($eksikSayisi > 0) {
            $gecmisEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
                ->where('etkinlik_turleri_id', '<=', 2)
                ->where(function ($query) {
                    $query->where('etkinlikBaslamaTarihi', '<', $this->today)
                        ->where('etkinlikBitisTarihi', '<', $this->today);
                }) // Sadece geçmiş etkinlikleri al
                ->when(!Auth::check(), function ($query) {
                    return $query->where('katilimTipi', 'genel');
                })
                ->orderBy('etkinlikBaslamaTarihi', 'desc') // En son olanlar önce gelsin
                ->take($eksikSayisi)
                ->get();

            $this->global = $gecmisEtkinlikler->count();
            $gelecekEtkinlikler = $gelecekEtkinlikler->merge($gecmisEtkinlikler);
        }

        $this->etkinlikler = $gelecekEtkinlikler;
    }

    public function loadMore()
    {
        $this->count++;
        // Önce gelecek etkinlikleri al
        $yeniEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
            ->where('etkinlik_turleri_id', '<=', 2)
            ->where(function ($query) {
                $query->where('etkinlikBaslamaTarihi', '>=', $this->today)
                    ->orWhere('etkinlikBitisTarihi', '>=', $this->today);
            })
            ->when(!Auth::check(), function ($query) {
                return $query->where('katilimTipi', 'genel');
            })
            ->orderBy('etkinlikBaslamaTarihi', 'asc')
            ->skip($this->count * $this->loadSize)
            ->take($this->loadSize)
            ->get();

        // Eğer gelecek etkinlikler bittiyse, geçmiş etkinlikleri çekmeye başla
        if ($yeniEtkinlikler->count() < $this->loadSize) {
            $eksikSayisi = $this->loadSize - $yeniEtkinlikler->count();

            $gecmisEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
                ->where('etkinlik_turleri_id', '<=', 2)
                ->where(function ($query) {
                    $query->where('etkinlikBaslamaTarihi', '<', $this->today)
                        ->where('etkinlikBitisTarihi', '<', $this->today);
                }) // Sadece geçmiş etkinlikleri al
                ->when(!Auth::check(), function ($query) {
                    return $query->where('katilimTipi', 'genel');
                })
                ->orderBy('etkinlikBaslamaTarihi', 'desc') // En son olanlar önce gelsin
                ->skip($this->global) // Daha önce yüklenenleri atla
                // ->skip(3) // Daha önce yüklenenleri atla
                ->take($eksikSayisi)
                ->get();

            $this->global += $gecmisEtkinlikler->count();

            $yeniEtkinlikler = $yeniEtkinlikler->merge($gecmisEtkinlikler);
        }

        // Yeni etkinlikleri mevcut listeye ekle
        $this->etkinlikler = $this->etkinlikler->merge($yeniEtkinlikler);
    }

    public function render()
    {
        return view('livewire.etkinlik-component');
    }
}
