<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menuler = Menu::all();
        return view('menu', compact('menuler'));
    }
}
