<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'islem_yapan_id',
    ];

    public function rol(): BelongsTo {
        return $this->belongsTo(Rol::class, 'roller_id', 'roller_id');
    }

    public function menu(): BelongsTo {
        return $this->belongsTo(Menu::class, 'menuler_id', 'menuler_id');
    }
}
