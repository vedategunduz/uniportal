<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EmojiTip extends Model
{
    use IslemYapanTrait;

    protected $table = 'emoji_tipleri';

    protected $primaryKey = 'emoji_tipleri_id';

    protected $fillable = [
        'baslik',
        'url',
        'grup_id',
        'aktiflik'
    ];
}
