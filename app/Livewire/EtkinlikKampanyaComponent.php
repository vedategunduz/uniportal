<?php

namespace App\Livewire;

use App\Models\Etkinlik;
use Carbon\Carbon;
use Livewire\Component;

class EtkinlikKampanyaComponent extends Component
{
    public $etkinlikler;
    public $count = 0;
    public $loadSize = 5;
    public $today;
    public $global = 0;
    public $totalEtkinlik;

    public function mount()
    {
        $this->today = Carbon::today();

        $this->totalEtkinlik = Etkinlik::whereHas('tur', function ($query) {
            $query->where('tip', 4);
        })->count();

        // Önce gelecek etkinlikleri al
        $gelecekEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
            ->whereHas('tur', function ($query) {
                $query->where('tip', 4);
            })
            ->where(function ($query) {
                $query->where('etkinlikBaslamaTarihi', '>=', $this->today)
                    ->orWhere('etkinlikBitisTarihi', '>=', $this->today);
            })
            ->orderBy('etkinlikBaslamaTarihi', 'asc')
            ->skip(0)
            ->take($this->loadSize)
            ->get();

        // Eğer gelecek etkinlikler azsa, eksik kısmı geçmiş etkinliklerle doldur
        $eksikSayisi = $this->loadSize - $gelecekEtkinlikler->count();

        if ($eksikSayisi > 0) {
            $gecmisEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
                ->whereHas('tur', function ($query) {
                    $query->where('tip', 4);
                })
                ->where(function ($query) {
                    $query->where('etkinlikBaslamaTarihi', '<', $this->today)
                        ->where('etkinlikBitisTarihi', '<', $this->today);
                }) // Sadece geçmiş etkinlikleri al
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
            ->whereHas('tur', function ($query) {
                $query->where('tip', 4);
            })
            ->where(function ($query) {
                $query->where('etkinlikBaslamaTarihi', '>=', $this->today)
                    ->orWhere('etkinlikBitisTarihi', '>=', $this->today);
            })
            ->orderBy('etkinlikBaslamaTarihi', 'asc')
            ->skip($this->count * $this->loadSize)
            ->take($this->loadSize)
            ->get();

        // Eğer gelecek etkinlikler bittiyse, geçmiş etkinlikleri çekmeye başla
        if ($yeniEtkinlikler->count() < $this->loadSize) {
            $eksikSayisi = $this->loadSize - $yeniEtkinlikler->count();

            $gecmisEtkinlikler = Etkinlik::with(['tur', 'isletme', 'begeni', 'yorum'])
                ->whereHas('tur', function ($query) {
                    $query->where('tip', 4);
                })
                ->where(function ($query) {
                    $query->where('etkinlikBaslamaTarihi', '<', $this->today)
                        ->where('etkinlikBitisTarihi', '<', $this->today);
                }) // Sadece geçmiş etkinlikleri al
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
        return view('livewire.etkinlik-kampanya-component');
    }
}
