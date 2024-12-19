<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamu extends Model
{
    use HasFactory;

    protected $table = 'kamular';

    protected $primaryKey = 'kamular_id';

    protected $fillable = [
        'referans_kodu',
        'iller_id',
        'baslik',
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
