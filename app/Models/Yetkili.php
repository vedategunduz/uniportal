<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Yetkili extends Model
{
    protected $table = 'yetkililer';

    protected $primaryKey = 'yetkililer_id';

    protected $fillable = [
        'kullanicilar_id',
        'kamular_id',
        'firmalar_id',
        'islem_yapan_id',
    ];

    public function YetkiliOlduguKamular()
    {
        return $this->belongsTo(Kamu::class, 'kamular_id', 'kamular_id');
    }

    public static function Deneme()
    {
        return DB::table('yetkililer')->join('kamular', 'kamular.kamular_id', '=', 'yetkililer.kamular_id')->select('kamular.*')->get();
    }
}
