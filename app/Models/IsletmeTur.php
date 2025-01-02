<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsletmeTur extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = "isletme_turleri";

    protected $primaryKey = "isletme_turleri_id";

    protected $fillabel = [
        'baslik',
    ];
}
