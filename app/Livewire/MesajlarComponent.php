<?php

namespace App\Livewire;

use App\Models\Mesaj;
use App\Models\MesajKullaniciGoruntuleme;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MesajlarComponent extends Component
{
    public $mesajlar;
    public $mesajSayisi = 5;
    public $kanalId;
    public $count = 0;

    #[On('echo-private:mesaj-kanal.{kanalId},MesajGuncellendi')]
    public function mount($kanalId)
    {
        $this->kanalId = $kanalId;

        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->count();

        if ($this->count > 5)
            $this->mesajSayisi = $this->count;

        $this->mesajlar = Mesaj::with(['kullanici', 'alinti.kullanici'])->where('mesaj_kanallari_id', $this->kanalId)
            ->orderBy('mesajlar_id', 'desc')
            ->take($this->mesajSayisi)
            ->get()->toArray();

        $this->mesajlar = array_reverse($this->mesajlar);
    }

    public function dahaFazlaMesaj()
    {
        $this->mesajSayisi += 5;

        $this->mount($this->kanalId);
    }

    #[On('echo-private:mesaj-kanal.{kanalId},MesajOlusturuldu')]
    public function messageCreated($message)
    {
        $yeniMesaj = $message['mesaj'];
        array_push($this->mesajlar, $yeniMesaj);
    }

    #[On('echo-private:mesaj-kanal.{kanalId},MesajSilindi')]
    public function messageDeleted($message)
    {
        $silinenMesaj = $message['mesaj'];

        $this->mesajlar = array_map(function ($mesaj) use ($silinenMesaj) {
            if ($mesaj['mesajlar_id'] == $silinenMesaj['mesajlar_id']) {
                $mesaj = $silinenMesaj;
            }
            return $mesaj;
        }, $this->mesajlar);
    }

    #[On('echo-private:mesaj-kanal.{kanalId},MesajGuncellendi')]
    public function messageUpdated($message)
    {
        $guncellenenMesaj = $message['mesaj'];

        $this->mesajlar = array_map(function ($mesaj) use ($guncellenenMesaj) {
            if ($mesaj['mesajlar_id'] == $guncellenenMesaj['mesajlar_id']) {
                $mesaj = $guncellenenMesaj;
            }
            return $mesaj;
        }, $this->mesajlar);
    }

    public function render()
    {
        return view('livewire.mesajlar-component');
    }
}
