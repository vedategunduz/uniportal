<?php

use App\Models\MesajKanalKatilimci;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('mesaj-kanal.{kanalId}', function ($user, $kanalId) {
    return MesajKanalKatilimci::where('mesaj_kanallari_id', $kanalId)
        ->where('kullanicilar_id', $user->kullanicilar_id)
        ->exists();
});
