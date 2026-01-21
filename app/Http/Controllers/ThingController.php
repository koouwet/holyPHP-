<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThingController extends Controller
{
    public function index()
    {
        $things = Thing::with(['master'])->where('master_id', Auth::id())->orderBy('name')->get();

        return view('things.index', compact('things'));
    }

    public function create()
    {
        return view('things.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wrnt' => 'nullable|date',
        ]);

        $data['master_id'] = Auth::id();

        Thing::create($data);

        return redirect()->route('things.index')->with('status', 'Вещь создана');
    }

    public function show(Thing $thing)
    {
        $this->authorizeOwner($thing);

        $thing->load(['usages.user', 'usages.place']);

        return view('things.show', compact('thing'));
    }

    public function edit(Thing $thing)
    {
        $this->authorizeOwner($thing);

        return view('things.edit', compact('thing'));
    }

    public function update(Request $request, Thing $thing)
    {
        $this->authorizeOwner($thing);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wrnt' => 'nullable|date',
        ]);

        $thing->update($data);

        return redirect()->route('things.index')->with('status', 'Вещь обновлена');
    }

    public function destroy(Thing $thing)
    {
        $this->authorizeOwner($thing);

        $thing->delete();

        return redirect()->route('things.index')->with('status', 'Вещь удалена');
    }

    private function authorizeOwner(Thing $thing): void
    {
        if ($thing->master_id !== Auth::id()) {
            abort(403);
        }
    }
}