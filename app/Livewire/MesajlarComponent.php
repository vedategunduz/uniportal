<?php

namespace App\Livewire;

use App\Models\Mesaj;
use Livewire\Attributes\On;
use Livewire\Component;

class MesajlarComponent extends Component
{
    public $mesajlar;
    public $mesajSayisi = 5;
    public $kanalId;

    public function mount($kanalId)
    {
        $this->kanalId = $kanalId;

        $this->mesajlar = Mesaj::with('kullanici')->where('mesaj_kanallari_id', $this->kanalId)
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
        dd($message);
        $newMessage = $message['message'];
        dd($newMessage, $this->mesajlar);
        array_push($this->mesajlar, $newMessage);
    }

    public function render()
    {
        return view('livewire.mesajlar-component');
    }
}
