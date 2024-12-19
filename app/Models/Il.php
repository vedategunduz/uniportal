<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Il extends Model
{
    /** @use HasFactory<\Database\Factories\IlFactory> */
    use HasFactory;

    protected $table = "iller";

    protected $primaryKey = "iller_id";

    protected $fillabel = [
        'baslik',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
