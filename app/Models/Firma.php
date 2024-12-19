<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    use HasFactory;

    protected $table = 'firmalar';

    protected $primaryKey = 'firmalar_id';

    protected $fillable = [
        'referans_uuid',
        'baslik',
        'email',
        'telefon',
        'adres',
        'website',
    ];

    public $timestamps = true;
}
