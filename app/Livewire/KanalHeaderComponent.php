<?php

namespace App\Livewire;

use App\Models\Kullanici;
use App\Models\Mesaj;
use App\Models\MesajKanal;
use App\Models\MesajKanalKatilimci;
use App\Models\MesajKullaniciGoruntuleme;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KanalHeaderComponent extends Component
{
    public $kanalId;
    public $kanal;
    public $sonMesaj;
    public $count = 0;

    public function mount($kanalId)
    {
        $this->kanalId = $kanalId;

        $this->kanal = MesajKanal::find($this->kanalId);

        if (!Auth::user()->aktifKanal($this->kanalId)) {
            $this->sonMesaj['durum'] = "null";
            $this->sonMesaj['mesaj'] = "Artık bu kanalda değilsiniz.";

            return;
        }

        $eklenmeTarihi = MesajKanalKatilimci::where('kullanicilar_id', Auth::id())
            ->where('mesaj_kanallari_id', $this->kanalId)
            ->latest()
            ->first()->created_at;

        $this->sonMesaj = Mesaj::where('mesaj_kanallari_id', $this->kanalId)->where('created_at', '>=', $eklenmeTarihi)->latest()->first();

        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->where('mesaj_kanallari_id', $this->kanalId)->count();

        if (!empty($this->sonMesaj))
            $this->sonMesaj = $this->sonMesaj->toArray();
    }

    #[On('echo:mesaj-kanal.{kanalId},MesajOlusturuldu')]
    public function sonMesaj($mesaj)
    {
        if (!Auth::user()->aktifKanal($this->kanalId)) {
            $this->sonMesaj['durum'] = "null";
            $this->sonMesaj['mesaj'] = "Artık bu kanalda değilsiniz.";

            return;
        }

        $this->sonMesaj = $mesaj['mesaj'];
        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->where('mesaj_kanallari_id', $this->kanalId)->count();
    }

    #[On('echo:mesaj-kanal.{kanalId},MesajSilindi')]
    public function sonMesajSil($mesaj)
    {
        if ($this->sonMesaj['mesajlar_id'] == $mesaj['mesaj']['mesajlar_id'])
            $this->sonMesaj = $mesaj['mesaj'];
    }

    public function render()
    {
        return view('livewire.kanal-header-component');
    }
}
