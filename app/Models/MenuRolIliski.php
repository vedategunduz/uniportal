<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRolIliski extends Model
{
    /** @use HasFactory<\Database\Factories\MenuRolIliskiFactory> */
    use HasFactory;
    protected $table = 'menu_rol_iliskileri';

    protected $primaryKey = 'menu_rol_iliskileri_id';

    protected $fillable = [
        'baslik',
        'roller_id',
        'menuler_id',
    ];

    public $timestamps = true;
}
