<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        Session::put('roller_id', 1);

        $menuler = Menu::whereHas('MenuRolIliskiBaglantisi', function ($query) {
            $query->where('roller_id', Session::get('roller_id'));
        })->get();

        return view('menu', compact('menuler'));
    }
}
