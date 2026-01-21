<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use App\Models\Thing;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsageController extends Controller
{
    public function index()
    {
        $usages = Usage::with(['thing', 'place', 'user'])
            ->whereHas('thing', fn ($q) => $q->where('master_id', Auth::id()))
            ->orderByDesc('created_at')
            ->get();

        return view('usages.index', compact('usages'));
    }

    public function create()
    {
        $things = Thing::where('master_id', Auth::id())->orderBy('name')->get();
        $places = Place::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('usages.create', compact('things', 'places', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'thing_id' => 'required|exists:things,id',
            'place_id' => 'required|exists:places,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
        ]);

        // владелец может делиться только своими вещами
        Thing::where('id', $data['thing_id'])
            ->where('master_id', Auth::id())
            ->firstOrFail();

        Usage::create($data);

        return redirect()->route('usages.index')->with('status', 'Выдача сохранена');
    }

    public function edit(Usage $usage)
    {
        $this->authorizeOwner($usage);

        $things = Thing::where('master_id', Auth::id())->orderBy('name')->get();
        $places = Place::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('usages.edit', compact('usage', 'things', 'places', 'users'));
    }

    public function update(Request $request, Usage $usage)
    {
        $this->authorizeOwner($usage);

        $data = $request->validate([
            'thing_id' => 'required|exists:things,id',
            'place_id' => 'required|exists:places,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
        ]);

        Thing::where('id', $data['thing_id'])
            ->where('master_id', Auth::id())
            ->firstOrFail();

        $usage->update($data);

        return redirect()->route('usages.index')->with('status', 'Выдача обновлена');
    }

    public function destroy(Usage $usage)
    {
        $this->authorizeOwner($usage);

        $usage->delete();

        return redirect()->route('usages.index')->with('status', 'Запись удалена');
    }

    private function authorizeOwner(Usage $usage): void
    {
        if ($usage->thing->master_id !== Auth::id()) {
            abort(403);
        }
    }
}
