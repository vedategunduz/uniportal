<?php

namespace App\Livewire;

use App\Models\Mesaj;
use App\Models\MesajKanal;
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

        $this->sonMesaj = Mesaj::where('mesaj_kanallari_id', $this->kanalId)->latest()->first();
        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->where('mesaj_kanallari_id', $this->kanalId)->count();

        if (!empty($this->sonMesaj))
            $this->sonMesaj = $this->sonMesaj->toArray();
    }

    #[On('echo-private:mesaj-kanal.{kanalId},MesajOlusturuldu')]
    public function sonMesaj($mesaj)
    {
        if ($mesaj['mesaj']['kullanicilar_id'] !== Auth::id())
            $this->count++;

        $this->sonMesaj = $mesaj['mesaj'];
        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->where('mesaj_kanallari_id', $this->kanalId)->count();
    }

    public function render()
    {
        return view('livewire.kanal-header-component');
    }
}
