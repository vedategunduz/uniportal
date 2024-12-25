<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function yetkiliOlduguKamular()
    {
        return $this->belongsTo(Kamu::class, 'kamular_id', 'kamular_id');
    }
}
