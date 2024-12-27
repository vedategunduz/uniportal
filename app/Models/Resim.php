<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resim extends Model
{
    /** @use HasFactory<\Database\Factories\ResimFactory> */
    use HasFactory;

    protected $table = 'resimler';

    protected $primaryKey = 'resimler_id';

    protected $fillable = [
        'etkinlikler_id',
        'hizmetler_id',
        'resimyolu',
        'islem_yapan_id',
    ];
}
