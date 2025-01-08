<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IsletmeYetkili extends Model
{
    use IslemYapanTrait;

    protected $table = 'isletme_yetkilileri';

    protected $primaryKey = 'isletme_yetkilileri_id';

    protected $fillable = [
        'kullanicilar_id',
        'isletmeler_id',
    ];

    public function isletmeBilgileri()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public static function isletmeKullanicilariGetir()
    {
        return IsletmeYetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)->pluck('isletmeler_id');
    }
}
