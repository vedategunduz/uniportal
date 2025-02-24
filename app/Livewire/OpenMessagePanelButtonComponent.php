<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\MesajKullaniciGoruntuleme;

class OpenMessagePanelButtonComponent extends Component
{
    public $count;
    public $kanalId;

    public function mount($kanalId = null)
    {
        $this->kanalId = $kanalId;
        $this->refreshCount();
    }

    public function refreshCount()
    {
        $this->count = MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())->count();
    }

    public function getListeners()
    {
        return [
            'refreshMessageCount' => 'refreshCount',
        ];
    }

    public function render()
    {
        return view('livewire.open-message-panel-button-component');
    }
}
