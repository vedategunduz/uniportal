<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EtkinlikModal extends Component
{
    public $baslik;
    public $isletmeler;
    public $kategoriler;
    public $aciklama;
    public $basvuruTarih;
    public $basvuruBitisTarih;
    public $baslamaTarih;
    public $bitisTarih;
    public $kontenjan;
    public $sehir;
    public $yorumDurum;
    public $sosyalMedyaDurum;
    public $kapakResim;
    public $digerResimler;

    public function __construct(
        // $baslik = "",
        // $isletmeler = "",
        // $kategoriler,
        // $aciklama = null,
        // $basvuruTarih,
        // $basvuruBitisTarih,
        // $baslamaTarih,
        // $bitisTarih,
        // $kontenjan,
        // $sehir,
        // $yorumDurum,
        // $sosyalMedyaDurum,
        // $kapakResim = null,
        // $digerResimler = []
    ) {
        // $this->baslik = $baslik;
        // $this->isletmeler = $isletmeler;
        // $this->kategoriler = $kategoriler;
        // $this->aciklama = $aciklama;
        // $this->basvuruTarih = $basvuruTarih;
        // $this->basvuruBitisTarih = $basvuruBitisTarih;
        // $this->baslamaTarih = $baslamaTarih;
        // $this->bitisTarih = $bitisTarih;
        // $this->kontenjan = $kontenjan;
        // $this->sehir = $sehir;
        // $this->yorumDurum = $yorumDurum;
        // $this->sosyalMedyaDurum = $sosyalMedyaDurum;
        // $this->kapakResim = $kapakResim;
        // $this->digerResimler = $digerResimler;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.etkinlik-modal');
    }
}
