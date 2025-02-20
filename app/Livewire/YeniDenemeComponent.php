<?php

namespace App\Livewire;

use App\Models\Mesaj;
use App\Models\MesajKanal;
use App\Models\MesajKanalKatilimci;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class YeniDenemeComponent extends Component
{
    public $kanallar;
    public $mesajSayisi = 15;

    public function mount()
    {
        $this->kanallar = MesajKanal::query()
            ->whereHas('katilimcilar', function ($query) {
                $query->where('kullanicilar_id', Auth::id());
            })
            ->with([
                'mesajlar' => function ($query) {
                    $query->with(['kullanici', 'isletme', 'unvan', 'alinti.kullanici', 'detay'])
                        ->whereExists(function ($sub) {
                            $sub->select(DB::raw(1))
                                ->from('mesaj_kanal_katilimcilari as mk')
                                ->whereRaw('mk.mesaj_kanallari_id = mesajlar.mesaj_kanallari_id')
                                ->where('mk.kullanicilar_id', Auth::id())
                                ->whereRaw('mesajlar.created_at between mk.created_at and IFNULL(mk.left_at, NOW())')
                                ->take($this->mesajSayisi);
                        })
                        ->orderBy('mesajlar_id', 'desc');
                },
            ])
            ->orderByDesc(
                Mesaj::select('created_at')
                    ->whereColumn('mesaj_kanallari_id', 'mesaj_kanallari.mesaj_kanallari_id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
            )
            ->get();

        foreach ($this->kanallar as $kanal) {
            $kanal->mesajlar = $kanal->mesajlar->reverse();
        }
    }

    #[On('echo:mesaj-kanallari,MesajOlusturuldu')]
    public function messageCreated($kanalId) {
        
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
        return view('livewire.yeni-deneme-component');
    }
}
