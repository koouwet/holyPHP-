<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class PlaceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Place::class);
        $places = Place::orderBy('name')->get();

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

        return redirect()->route('places.index')->with('status', 'Место обновлено');
    }

    public function destroy(Place $place)
    {
        Gate::authorize('admin');
        $this->authorize('delete', $place);
        $place->delete();

        return redirect()->route('places.index')->with('status', 'Место удалено');
    }
}
