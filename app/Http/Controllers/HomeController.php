<?php

namespace App\Http\Controllers;

use App\Models\Place;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
