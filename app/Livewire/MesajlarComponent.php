<?php

namespace App\Livewire;

use App\Models\EmojiTip;
use App\Models\Mesaj;
use App\Models\MesajKanalKatilimci;
use App\Models\MesajKullaniciGoruntuleme;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MesajlarComponent extends Component
{
    public $mesajlar;
    public $mesajSayisi = 10;
    public $kanalId;
    public $count = 0;
    public $emojiler;

    // #[On('echo:mesaj-kanal.{kanalId},MesajGuncellendi')]
    public function mount($kanalId)
    {
        $this->emojiler = EmojiTip::where('grup_id', 1)->get();

        $this->kanalId = $kanalId;

        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->count();

        if ($this->count > 5)
            $this->mesajSayisi = $this->count;

        $membershipPeriods = MesajKanalKatilimci::where('kullanicilar_id', Auth::id())
            ->where('mesaj_kanallari_id', $this->kanalId)
            ->get();

        $this->mesajlar = Mesaj::with(['kullanici', 'isletme', 'unvan', 'alinti.kullanici', 'detay.kullanici', 'detay.emoji'])
            ->where('mesaj_kanallari_id', $this->kanalId)
            ->where(function ($query) use ($membershipPeriods) {
                // Her üyelik dönemi için "created_at" tarihinin, o döneme denk gelip gelmediğini kontrol ediyoruz.
                foreach ($membershipPeriods as $period) {
                    // Eğer kullanıcı halen gruptaysa, left_at değeri null olacağından, şu anki zaman ile kıyaslayabilirsiniz.
                    $leftTime = $period->left_at ?? now();
                    $query->orWhereBetween('created_at', [$period->created_at, $leftTime]);
                }
            })
            ->orderBy('mesajlar_id', 'desc')
            ->take($this->mesajSayisi)
            ->get()
            ->toArray();

        $this->mesajlar = array_reverse($this->mesajlar);

        // dump($this->mesajlar);
    }

    public function dahaFazlaMesaj()
    {
        $this->mesajSayisi += 5;

        $this->mount($this->kanalId);
    }

    #[On('echo:mesaj-kanal.{kanalId},MesajOlusturuldu')]
    public function messageCreated($message)
    {
        if (!Auth::user()->aktifKanal($this->kanalId))
            return;

        $yeniMesaj = $message['mesaj'];
        array_push($this->mesajlar, $yeniMesaj);

        $this->dispatch('refreshMessageCount');
    }

    #[On('echo:mesaj-kanal.{kanalId},MesajSilindi')]
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

    #[On('echo:mesaj-kanal.{kanalId},MesajGuncellendi')]
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
