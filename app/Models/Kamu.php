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
        'referans_uuid',
        'baslik',
    ];

    public $timestamps = true;
}
