<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function getMenuler()
    {
        return Menu::whereHas('MenuRolDetayi', function ($query) {
            $query->where('roller_id', Auth::user()->roller_id);
        })
            ->with('altMenuler')
            ->whereNull('bagli_menuler_id')
            ->orderBy('menuSira')
            ->get();
    }

    protected function uploadImage() {
        
    }
}
