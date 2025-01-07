<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class IsletmeBirim extends Model
{
    use IslemYapanTrait;

    protected $table = "isletme_birimleri";

    protected $primaryKey = "isletme_birimleri_id";

    protected $fillabel = [
        'isletmeler_id',
        'birim_tipleri_id',
        'baslik',
    ];

    public function isletmeBirimPersonelBul($id)
    {
        $birimPersonelleri = KullaniciBirimUnvan::with('kullanici', 'unvan')
            ->where('isletme_birimleri_id', $id)
            ->get()
            ->sortBy(function ($item) {
                return $item->unvan->unvanSira;
            });

        return $birimPersonelleri;
    }
}
