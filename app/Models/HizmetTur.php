<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HizmetTur extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = 'hizmet_turleri';

    protected $primaryKey = 'hizmet_turleri_id';

    protected $fillable = [
        'bagli_hizmet_turleri_id',
        'baslik',
        'derinlik',
    ];
}
