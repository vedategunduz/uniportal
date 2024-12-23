<?php

namespace App\Http\Controllers;

use App\Models\MenuRolIliski;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $menuler = MenuRolIliski::with('menu')->where('roller_id', Auth::user()->roller_id)->get();
        return view('dashboard', compact('menuler'));
    }
}
