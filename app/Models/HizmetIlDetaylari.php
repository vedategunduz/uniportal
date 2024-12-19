<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HizmetIlDetaylari extends Model
{
    use HasFactory;
    protected $table = 'hizmet_il_detaylari';

    protected $primaryKey = 'hizmet_il_detaylari_id';

    protected $fillable = [
        'firma_hizmetleri_id',
        'kamu_hizmetleri_id',
        'iller_id',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
