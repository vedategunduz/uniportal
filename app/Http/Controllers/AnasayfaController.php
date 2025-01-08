<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AnasayfaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('main.index');
    }
}
