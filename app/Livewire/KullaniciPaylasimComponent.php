<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class KullaniciPaylasimComponent extends Component
{
    public $kullanici;
    public $paylasimlar;
    public $total;
    public $limit = 12;

    public function mount($kullanici)
    {
        $this->kullanici = $kullanici;
        $this->total = $kullanici->paylasimlar()->where('aktiflik', 1)->count();
        $this->paylasimlar = $kullanici->paylasimlar()->where('aktiflik', 1)->take($this->limit)->get();
    }

    #[On('paylasimEklendi')]
    public function inserted($paylasim_id)
    {
        $paylasim_id = decrypt($paylasim_id);
        $paylasim = $this->kullanici->paylasimlar()->where('paylasimlar_id', $paylasim_id)->first();
        $this->paylasimlar->prepend($paylasim);
        $this->total++;
        // $this->paylasimlar = $this->kullanici->paylasimlar()->where('aktiflik', 1)->take($this->limit)->get();
    }

    #[On('paylasimSilindi')]
    public function deleted($paylasim_id)
    {
        $this->total--;

        $paylasim_id = decrypt($paylasim_id);
        $this->paylasimlar = $this->paylasimlar->reject(function ($paylasim) use ($paylasim_id) {
            return $paylasim['paylasimlar_id'] === $paylasim_id;
        });
    }

    public function loadMore()
    {
        $this->limit += 8;
        $this->mount($this->kullanici);
    }

    public function render()
    {
        return view('livewire.kullanici-paylasim-component');
    }
}
