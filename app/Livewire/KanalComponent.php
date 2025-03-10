<?php

namespace App\Livewire;

use App\Models\Mesaj;
use App\Models\MesajKanal;
use App\Models\MesajKanalKatilimci;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KanalComponent extends Component
{
    public $kanallar;


    #[On('echo:mesaj-kanallari,KanalSilindi')]
    public function mount()
    {
        $this->kanallar = MesajKanal::with('etkinlik')->whereHas('katilimcilar', function ($query) {
            $query->where('kullanicilar_id', Auth::id())->whereNull('deleted_at');
        })
            ->orderByDesc(
                Mesaj::select('created_at')
                    ->whereColumn('mesaj_kanallari_id', 'mesaj_kanallari.mesaj_kanallari_id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
            )
            ->get()
            ->toArray();
    }

    #[On('echo:mesaj-kanallari,KanalOlusturuldu')]
    public function addChannel($kanal)
    {
        $kontrol = MesajKanalKatilimci::where('mesaj_kanallari_id', $kanal['kanal']['mesaj_kanallari_id'])->where('kullanicilar_id', Auth::id())->exists();

        if ($kontrol) {
            array_push($this->kanallar, $kanal['kanal']);
        }
    }

    #[On('echo:mesaj-kanallari,KanalGuncellendi')]
    public function updateChannel($kanal)
    {
        $index = array_search(
            $kanal['kanal']['mesaj_kanallari_id'],
            array_column($this->kanallar, 'mesaj_kanallari_id')
        );

        if ($index !== false) {
            $this->kanallar[$index] = $kanal['kanal'];
            $this->kanallar = array_values($this->kanallar);
        }
    }

    public function render()
    {
        return view('livewire.kanal-component');
    }
}
