<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resim extends Model
{
    /** @use HasFactory<\Database\Factories\ResimFactory> */
    use HasFactory, IslemYapanTrait;

    protected $table = 'resimler';

    protected $primaryKey = 'resimler_id';

    protected $fillable = [
        'etkinlikler_id',
        'resimYolu',
    ];
}
