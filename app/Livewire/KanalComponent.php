<?php

namespace App\Livewire;

use App\Models\MesajKanal;
use App\Models\MesajKanalKatilimci;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KanalComponent extends Component
{
    public $kanallar;

    public function mount()
    {
        $this->kanallar = MesajKanal::whereHas('katilimcilar', function ($query) {
            $query->where('kullanicilar_id', Auth::id())->where('aktiflik', 1);
        })->get()->toArray();
    }

    #[On('echo:mesaj-kanallari,KanalOlusturuldu')]
    public function addChannel($kanal)
    {
        $kontrol = MesajKanalKatilimci::where('mesaj_kanallari_id', $kanal['kanal']['mesaj_kanallari_id'])->where('kullanicilar_id', Auth::id())->exists();

        if ($kontrol) {
            array_push($this->kanallar, $kanal['kanal']);
        }
    }

    public function render()
    {
        return view('livewire.kanal-component');
    }
}
