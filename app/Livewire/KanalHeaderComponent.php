<?php

namespace App\Livewire;

use App\Models\MesajKanal;
use Livewire\Component;

class KanalHeaderComponent extends Component
{
    public $kanalId;
    public $kanal;
    public function mount($kanalId)
    {
        $this->kanalId = $kanalId;
        $this->kanal = MesajKanal::find($this->kanalId);
    }

    public function render()
    {
        return view('livewire.kanal-header-component');
    }
}
