<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaylasimYorum extends Model
{
    use IslemYapanTrait;

    protected $table = 'paylasim_yorumlari';
    protected $primaryKey = 'paylasim_yorumlari_id';

    protected $fillable = [
        'kullanicilar_id',
        'paylasim_id',
        'yanitlanan_paylasim_yorum_id',
        'yorum',
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function paylasim()
    {
        return $this->belongsTo(Paylasim::class, 'paylasim_id', 'paylasim_id');
    }

    public function yanitlar()
    {
        return $this->hasMany(PaylasimYorum::class, 'yanitlanan_paylasim_yorum_id', 'paylasim_yorumlari_id');
    }

    public function begeniler() {
        return $this->hasMany(PaylasimYorumBegeni::class, 'paylasim_yorumlari_id', 'paylasim_yorumlari_id');
    }

    public function begenToggle()
    {
        $begeni = $this->begeniler()->where('kullanicilar_id', Auth::id())->first();

        if ($begeni) {
            $begeni->delete();
        } else {
            $this->begeniler()->create([
                'kullanicilar_id' => Auth::id(),
            ]);
        }
    }
}
