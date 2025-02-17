<?php

namespace App\Livewire;

use App\Models\MesajKanal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KanalComponent extends Component
{
    public $kanallar;

    public function mount()
    {
        $this->kanallar = MesajKanal::whereHas('katilimcilar', function ($query) {
            $query->where('kullanicilar_id', Auth::id());
        })->get()->toArray();
    }

    #[On('echo:mesaj-kanallari,KanalOlusturuldu')]
    public function addChannel($kanal)
    {
        array_push($this->kanallar, $kanal['kanal']);
    }

    public function render()
    {
        return view('livewire.kanal-component');
    }
}
