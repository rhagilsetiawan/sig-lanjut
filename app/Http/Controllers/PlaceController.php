<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    public function index(Place $place)
    {
        return view('places.index');
    }


    public function create()
    {
        return view('places.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'address' => 'required|min:10',
            'description' => 'required|min:10',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        $place = new Place;
        if ($request->hasFile('image')) {
            $place->image = $request->image->store('public/places');
        }

        $place->name = $request->input('name');
        $place->address = $request->input('address');
        $place->description = $request->input('description');
        $place->latitude = $request->input('latitude');
        $place->longitude = $request->input('longitude');
        $place->save();
        if ($place) {
            var_dump('yes');
            // notify()->success('Place has been created');
            return redirect()->route('places.index');
        } else {
            var_dump('no');
            // notify()->error('Place not been created');
            return redirect()->route('places.index');
        }
    }


    public function show(Place $place)
    {
        return view('places.detail', [
            'place' => $place,
        ]);
    }


    public function edit(Place $place)
    {   
        return view('places.edit', [
            'place' => $place,
        ]);
    }


    public function update(Request $request, Place $place)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'address' => 'required|min:10',
            'description' => 'required|min:10',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        if ($request->hasFile('image')) {

            // Hapus file image pada folder public/places
            Storage::delete($place->image);
            $path = $request->image->store('public/places');

            $place->update([
                'image' => $path,
            ]);
        }

        $place->update([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        var_dump($place);

        // Notifikasi info
        // notify()->info('Ini adalah pesan informasi!', 'Informasi');

        // Notifikasi sukses
        // notify()->success('Operasi berhasil diselesaikan!', 'Sukses');
        return redirect()->back();
    }

    public function destroy(Place $place)
    {
        $place->delete();
        // notify()->warning('Place has been deleted');
        return redirect()->route('places.index');
    }
}
