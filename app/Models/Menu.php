<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menuler';

    protected $primaryKey = 'menuler_id';

    protected $fillable = [
        'menu_adi',
        'menu_link',
        'menu_icon',
        'menu_aciklama',
        'menu_sira',
        'bagli_menuler_id',
    ];

    public $timestamps = true;
}
