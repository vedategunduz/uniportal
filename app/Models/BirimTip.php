<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirimTip extends Model
{
    use HasFactory;

    protected $table = 'birim_tipleri';

    protected $primaryKey = 'birim_tipleri_id';

    protected $fillable = [
        'baslik',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
