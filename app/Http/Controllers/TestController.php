<?php

namespace App\Http\Controllers;

use App\Models\Kamu;

class TestController extends Controller
{
    public function index()
    {
        $kamular = Kamu::all();
        return View('test', ['kamular' => $kamular]);
    }

    public function test($id)
    {
        return view('deneme', ['id' => decrypt($id)]);
    }
}
