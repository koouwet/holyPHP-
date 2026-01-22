<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThingController extends Controller
{
    public function index()
    {
        // по умолчанию показываем общий список (All things)
        return $this->listAll();
    }

    // -------- Фильтры списка вещей --------

    // общий список всех вещей
    public function listAll()
    {
        $things = Thing::with(['master'])
            ->orderBy('name')
            ->get();

        return view('things.index', [
            'title' => 'Все вещи',
            'things' => $things,
        ]);
    }

    // мои вещи (я хозяин)
    public function listMy()
    {
        $things = Thing::with(['master'])
            ->where('master_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('things.index', [
            'title' => 'Мои вещи',
            'things' => $things,
        ]);
    }

    // вещи, которые находятся в местах с флагом repair = true
    public function listRepair()
    {
        $things = Thing::with(['master'])
            ->whereHas('usage.place', fn ($q) => $q->where('repair', true))
            ->orderBy('name')
            ->get();

        return view('things.index', [
            'title' => 'Вещи в ремонте / мойке',
            'things' => $things,
        ]);
    }

    // вещи, которые находятся в местах с флагом work = true
    public function listWork()
    {
        $things = Thing::with(['master'])
            ->whereHas('usage.place', fn ($q) => $q->where('work', true))
            ->orderBy('name')
            ->get();

        return view('things.index', [
            'title' => 'Вещи в работе',
            'things' => $things,
        ]);
    }

    // мои вещи, которые используются другими пользователями
    public function listUsed()
    {
        $things = Thing::with(['master'])
            ->where('master_id', Auth::id())
            ->whereHas('usage', fn ($q) => $q->where('user_id', '!=', Auth::id()))
            ->orderBy('name')
            ->get();

        return view('things.index', [
            'title' => 'Мои вещи, используемые другими',
            'things' => $things,
        ]);
    }

    // -------- Обычный CRUD --------

    public function create()
    {
        $this->authorize('create', Thing::class);
        return view('things.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Thing::class);

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
        $this->authorize('view', $thing);
        // просмотр доступен всем авторизованным
        $thing->load(['usage.user', 'usage.place']);

        return view('things.show', compact('thing'));
    }

    public function edit(Thing $thing)
    {
        $this->authorize('update', $thing);

        return view('things.edit', compact('thing'));
    }

    public function update(Request $request, Thing $thing)
    {
        $this->authorize('update', $thing);

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
        $this->authorize('delete', $thing);

        $thing->delete();

        return redirect()->route('things.index')->with('status', 'Вещь удалена');
    }

}

