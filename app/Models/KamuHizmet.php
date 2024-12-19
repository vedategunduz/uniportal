<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamuHizmet extends Model
{
    /** @use HasFactory<\Database\Factories\KamuHizmetFactory> */
    use HasFactory;

    protected $table = 'kamu_hizmetleri';

    protected $primaryKey = 'kamu_hizmetleri_id';

    protected $fillable = [
        'hizmet_turleri_id',
        'kamular_id',
        'islem_yapan_id',
    ];

    public $timestamps = true;
}
