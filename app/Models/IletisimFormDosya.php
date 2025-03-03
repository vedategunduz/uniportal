<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class IletisimFormDosya extends Model
{
    use IslemYapanTrait;

    protected $table = 'iletisim_form_dosya';

    protected $fillable = [
        'iletisim_form_id',
        'dosya_adi',
        'dosya_yolu',
    ];

    public function form()
    {
        return $this->belongsTo(IletisimForm::class, 'iletisim_form_id', 'iletisim_form_id');
    }
}
