<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = 'menuler';

    protected $primaryKey = 'menuler_id';

    protected $fillable = [
        'bagli_menuler_id',
        'menuAd',
        'menuLink',
        'menuIcon',
        'menuAciklama',
        'menuSira',
    ];

    public function altMenuler() {
        return $this->hasMany(Menu::class, 'bagli_menuler_id');
    }

    public function MenuRolDetayi() {
        return $this->hasMany(MenuRolIliski::class, 'menuler_id', 'menuler_id');
    }
}
