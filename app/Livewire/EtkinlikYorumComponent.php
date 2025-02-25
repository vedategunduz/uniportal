<?php

namespace App\Livewire;

use Livewire\Component;

class EtkinlikYorumComponent extends Component
{
    public $yorumlar;

    public function mount($yorumlar)
    {
        $this->yorumlar = $yorumlar;
    }

    public function render()
    {
        return view('livewire.etkinlik-yorum-component');
    }
}
