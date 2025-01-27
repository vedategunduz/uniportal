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

    /**
     * Alt menüleri (children) getiren ilişki.
     * bagli_menuler_id => parent (üst) menünün ID’sini tutar.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'bagli_menuler_id', 'menuler_id')
            ->with('children')->orderBy('menuSira', 'asc');
        // Burada ->with('children') ekleyerek, çok seviyeli iç içe menülerde
        // altın da altını otomatik olarak çekebiliriz (recursive eager loading).
    }

    /**
     * Üst menüyü (parent) getiren ilişki.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'bagli_menuler_id', 'menuler_id');
    }

    public function altMenuler()
    {
        return $this->hasMany(Menu::class, 'bagli_menuler_id')->orderBy('menuSira', 'asc');
    }

    public function MenuRolDetayi()
    {
        return $this->hasMany(MenuRolIliski::class, 'menuler_id', 'menuler_id');
    }
}
