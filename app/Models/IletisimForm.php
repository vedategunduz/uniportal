<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class IletisimForm extends Model
{
    use IslemYapanTrait;

    protected $table = "iletisim_form";

    protected $primaryKey = "iletisim_form_id";

    protected $fillable = [
        'konu',
        'ad',
        'soyad',
        'email',
        'mesaj',
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'platform',
    ];

    public function dosyalar()
    {
        return $this->hasMany(IletisimFormDosya::class, 'iletisim_form_id', 'iletisim_form_id');
    }
}
