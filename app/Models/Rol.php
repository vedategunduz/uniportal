<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    /** @use HasFactory<\Database\Factories\RolFactory> */
    use HasFactory;
    protected $table = 'roller';

    protected $primaryKey = 'roller_id';

    protected $fillable = [
        'tur'
    ];

    public $timestamps = true;
}
