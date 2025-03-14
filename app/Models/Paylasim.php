<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Paylasim extends Model
{
    use IslemYapanTrait;

    protected $table = 'paylasimlar';

    protected $primaryKey = 'paylasimlar_id';

    protected $fillable = [
        'kullanicilar_id',
        'aciklama',
        'yorumDurumu',
        'kapakFotoUrl',
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function begeniler()
    {
        return $this->hasMany(PaylasimBegeni::class, 'paylasimlar_id', 'paylasimlar_id');
    }

    public function begenToggle() {
        $begeni = $this->begeniler()->where('kullanicilar_id', Auth::id())->first();
        $kullanici = $this->kullanici;

        if ($begeni) {
            Auth::user()->puanKullan(-1);
            $kullanici->puanKullan(-1);

            $begeni->delete();
        } else {
            Auth::user()->puanKullan(1);
            $kullanici->puanKullan(1);

            $this->begeniler()->create([
                'kullanicilar_id' => Auth::id()
            ]);
        }
    }

    public function yorumlar()
    {
        return $this->hasMany(PaylasimYorum::class, 'paylasimlar_id', 'paylasimlar_id');
    }
}
