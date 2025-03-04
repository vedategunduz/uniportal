<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class Dosya extends Model
{
    use IslemYapanTrait;

    protected $table = 'dosyalar';

    protected $primaryKey = 'dosyalar_id';

    protected $fillable = ['dosya_adi', 'dosya_yolu'];
}
