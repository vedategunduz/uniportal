<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsletmeTur extends Model
{
    use HasFactory;

    protected $table = "isletme_turleri";

    protected $primaryKey = "isletme_turleri_id";

    protected $fillabel = [
        'baslik',
    ];
}
