<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EtkinlikModal extends Component
{
    public $modalBaslik;
    public $etkinlikBaslik;
    public $isletme;
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
    public $postUrl;

    public function __construct(
        $modalBaslik = "",
        $etkinlikBaslik = "",
        $isletme = "",
        $kategoriler = "",
        $aciklama = "",
        $basvuruTarih = "",
        $basvuruBitisTarih = "",
        $baslamaTarih = "",
        $bitisTarih = "",
        $kontenjan = "",
        $sehir = "",
        $yorumDurum = "",
        $sosyalMedyaDurum = "",
        $kapakResim = "",
        $digerResimler = [],
        $postUrl,
    ) {
        $this->modalBaslik = $modalBaslik;
        $this->etkinlikBaslik = $etkinlikBaslik;
        $this->isletme = $isletme;
        $this->kategoriler = $kategoriler;
        $this->aciklama = $aciklama;
        $this->basvuruTarih = $basvuruTarih;
        $this->basvuruBitisTarih = $basvuruBitisTarih;
        $this->baslamaTarih = $baslamaTarih;
        $this->bitisTarih = $bitisTarih;
        $this->kontenjan = $kontenjan;
        $this->sehir = $sehir;
        $this->yorumDurum = $yorumDurum;
        $this->sosyalMedyaDurum = $sosyalMedyaDurum;
        $this->kapakResim = $kapakResim;
        $this->digerResimler = $digerResimler;
        $this->postUrl = $postUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.etkinlik-modal');
    }
}
