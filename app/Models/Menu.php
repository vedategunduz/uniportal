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
        'islem_yapan_id',
    ];

    public function anaMenuler() {
        return $this->belongsTo(Menu::class, 'bagli_menuler_id');
    }

    public function altMenuler() {
        return $this->hasMany(Menu::class, 'bagli_menuler_id');
    }

    public function MenuRolIliskiBaglantisi() {
        return $this->hasMany(MenuRolIliski::class, 'menuler_id', 'menuler_id');
    }
}
