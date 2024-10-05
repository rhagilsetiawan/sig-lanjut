<?php

namespace App\Http\Controllers;

use App\Models\Place;

class MapController extends Controller
{
    public function index()
    {
        $places = Place::all();
        return view('map', compact('places'));
    }
}
