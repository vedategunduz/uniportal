<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait IslemYapanTrait
{
    protected static function bootIslemYapanTrait()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->islem_yapan_id = Auth::user()->kullanicilar_id;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->islem_yapan_id = Auth::user()->kullanicilar_id;
            }
        });
    }
}
