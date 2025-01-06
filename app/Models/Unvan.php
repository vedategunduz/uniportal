<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class Unvan extends Model
{
    use IslemYapanTrait;

    protected $table = 'unvanlar';

    protected $primaryKey = 'unvanlar_id';

    protected $fillable = [
        'isletme_turleri_id',
        'baslik',
        'unvanSira',
    ];
}
