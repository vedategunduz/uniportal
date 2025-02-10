<?php

namespace App\Events;

use App\Models\Mesaj;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;

class MesajOlusturuldu
{
    public $mesaj;
    /**
     * Create a new event instance.
     */
    public function __construct(Mesaj $mesaj)
    {
        $this->mesaj = $mesaj->toArray();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel("mesaj-kanal.{$this->mesaj['mesaj_kanallari_id']}");
    }
}
