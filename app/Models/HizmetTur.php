<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HizmetTur extends Model
{
    use HasFactory;

    protected $table = 'hizmet_turleri';

    protected $primaryKey = 'hizmet_turleri_id';

    protected $fillabel = [
        'baslik',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
