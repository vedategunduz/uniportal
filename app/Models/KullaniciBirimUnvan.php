<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class KullaniciBirimUnvan extends Model
{
    use IslemYapanTrait;

    protected $table = 'kullanici_birim_unvan_iliskileri';

    protected $primaryKey = 'kullanici_birim_unvan_iliskileri_id';

    protected $fillable = [
        'kullanicilar_id',
        'isletme_birimleri_id',
        'unvanlar_id',
    ];

    public function kullanici(){
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function unvan() {
        return $this->belongsTo(Unvan::class, 'unvanlar_id', 'unvanlar_id');
    }
}
