<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kullanici extends Model
{
    /** @use HasFactory<\Database\Factories\KullaniciFactory> */
    use HasFactory;
    protected $table = 'kullanicilar';

    protected $primaryKey = 'kullanicilar_id';

    protected $fillable = [
        'roller_id',
        'ad'
    ];

    public $timestamps = true;
}
