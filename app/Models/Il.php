<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Il extends Model
{
    /** @use HasFactory<\Database\Factories\IlFactory> */
    use HasFactory, IslemYapanTrait;

    protected $table = "iller";

    protected $primaryKey = "iller_id";

    protected $fillabel = [
        'baslik',
    ];
}
