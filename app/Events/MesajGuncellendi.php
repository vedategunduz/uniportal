<?php

namespace App\Events;

use App\Models\Mesaj;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MesajGuncellendi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
        return new Channel("mesaj-kanal.{$this->mesaj['mesaj_kanallari_id']}");
    }
}
