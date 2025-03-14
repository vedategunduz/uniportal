<?php

namespace App\Livewire;

use App\Models\Paylasim;
use Livewire\Component;

class KullaniciPaylasimYorumComponent extends Component
{
    public $paylasim;
    public $paylasim_id;
    public $total;
    public $yorumlar;
    public $threshold = 10;
    public $perPage = 8;

    public function mount($paylasimid)
    {
        $this->paylasim_id = $paylasimid;

        $paylasim_id = decrypt($this->paylasim_id);

        $this->paylasim = Paylasim::find($paylasim_id);

        $this->yorumlar = $this->paylasim->yorumlar()
            ->whereNull('yanitlanan_paylasim_yorum_id')
            // ->orderByRaw("CASE WHEN begeni_count >= ? THEN 0 ELSE 1 END", [$this->threshold])
            // // Ardından beğeni sayısına göre (yüksekten düşüğe) sıralar.
            // ->orderByDesc('begeni_count')
            // Son olarak, eklenme tarihine göre (en yeniler önce) sıralar.
            ->orderByDesc('created_at')
            ->where('aktiflik', 1)
            ->take($this->perPage)
            ->get();

        $this->total = $this->paylasim->yorumlar()
            ->whereNull('yanitlanan_paylasim_yorum_id')
            ->count();
    }

    public function render()
    {
        return view('livewire.kullanici-paylasim-yorum-component');
    }
}
