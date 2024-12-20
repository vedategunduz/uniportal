<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtkinlikTur extends Model
{
    protected $table = 'etkinlik_turleri';

    protected $primaryKey = 'etkinlik_turleri_id';

    protected $fillable = [
        'tur',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
