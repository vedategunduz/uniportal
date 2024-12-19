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
        'kamular_id',
        'baslik',
        'email',
        'telefon',
        'adres',
        'website_url',
        'x_url',
        'instagram_url',
        'linkedin_url',
        'diger_url',
        'aktiflik',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
