<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaHizmet extends Model
{
    use HasFactory;

    protected $table = 'firma_hizmetleri';

    protected $primaryKey = 'firma_hizmetleri_id';

    protected $fillable = [
        'hizmet_turleri_id',
        'firmalar_id',
        'aciklama',
    ];

    public $timestamps = true;
}
