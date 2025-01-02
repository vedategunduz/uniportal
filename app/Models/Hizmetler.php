<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hizmetler extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = 'hizmetler';

    protected $primaryKey = 'hizmetler_id';

    protected $fillable = [
        'hizmet_turleri_id',
        'isletmeler_id',
        'baslik',
    ];
}
