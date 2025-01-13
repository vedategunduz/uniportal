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

    public static function birimPersoneller(string $birimler_id,  int $id)
    {
        $birimPersonelleri   = KullaniciBirimUnvan::where('isletme_birimleri_id', decrypt($birimler_id))->pluck('kullanicilar_id');
        $isletmePersonelleri = IsletmeYetkili::whereNotIn('kullanicilar_id', $birimPersonelleri)->where('isletmeler_id', $id)->pluck('kullanicilar_id');

        return $isletmePersonelleri;
    }

    public function isletmeBilgileri()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    /**
     * @return array => kullanıcının yetkili olduğu işletmeleri döndürür.
     */
    public static function aitOldugumIsletmeleriGetir()
    {
        return IsletmeYetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)->pluck('isletmeler_id');
    }
}
