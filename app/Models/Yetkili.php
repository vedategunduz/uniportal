<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsletmeYetkilileri extends Model
{
    protected $table = 'isletme_yetkilileri';

    protected $primaryKey = 'isletme_yetkilileri_id';

    protected $fillable = [
        'kullanicilar_id',
        'isletmeler_id',
        'islem_yapan_id',
    ];

    public function isletmeBilgileri()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }
}
