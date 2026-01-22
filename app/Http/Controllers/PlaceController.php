<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;



class PlaceController extends Controller
{
    public function index()
    {
        $places = Cache::remember('places.all', 600, function () {
        return Place::orderBy('name')->get();
    });

        return view('places.index', compact('places'));
    }

    public function create()
    {
        Gate::authorize('admin');
        $this->authorize('create', Place::class);
        return view('places.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');
        $this->authorize('create', Place::class);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repair' => 'nullable|boolean',
            'work' => 'nullable|boolean',
        ]);

        $data['repair'] = (bool) ($data['repair'] ?? false);
        $data['work'] = (bool) ($data['work'] ?? false);

        Place::create($data);

        Cache::forget('places.all');

        return redirect()->route('places.index')->with('status', 'Место создано');
    }

    public function edit(Place $place)
    {
        Gate::authorize('admin');
        $this->authorize('update', $place);
        return view('places.edit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        Gate::authorize('admin');
        $this->authorize('update', $place);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repair' => 'nullable|boolean',
            'work' => 'nullable|boolean',
        ]);

        $data['repair'] = (bool) ($data['repair'] ?? false);
        $data['work'] = (bool) ($data['work'] ?? false);

        $place->update($data);

        Cache::forget('places.all');

        return redirect()->route('places.index')->with('status', 'Место обновлено');
    }

    public function destroy(Place $place)
    {
        Gate::authorize('admin');
        $this->authorize('delete', $place);
        $place->delete();

        Cache::forget('places.all');

        return redirect()->route('places.index')->with('status', 'Место удалено');
    }
}
