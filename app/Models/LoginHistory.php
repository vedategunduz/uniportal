<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $table = 'login_histories';

    protected $fillable = [
        'kullanicilar_id',
        'login_at',
        'logout_at',
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'platform',
        'successful'
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }
}
