<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Place;
use App\Models\Usage;
use Illuminate\Support\Facades\Cache;
use App\Models\ThingArchive;



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
        $things = Cache::remember('things.all', 600, function () {
            return Thing::with(['master'])
                ->orderBy('name')
                ->get();
        });

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

        Cache::forget('things.all');

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

        Cache::forget('things.all');

        return redirect()->route('things.index')->with('status', 'Вещь обновлена');
    }

    public function destroy(Thing $thing)
{
    $this->authorize('delete', $thing);

    // определяем последнего пользователя и место
    $usage = $thing->usage;

    ThingArchive::create([
        'name' => $thing->name,
        'description' => $thing->description,
        'owner_name' => $thing->master?->name ?? '—',
        'last_user_name' => $usage?->user?->name,
        'place_name' => $usage?->place?->name,
        'restored' => false,
    ]);

    $thing->delete();

    Cache::forget('things.all');

    return redirect()
        ->route('things.index')
        ->with('status', 'Вещь удалена и помещена в архив');
}


    public function transferForm(Thing $thing)
    {
        $this->authorize('transfer', $thing);

        return view('things.transfer', [
            'thing' => $thing,
            'users' => User::orderBy('name')->get(),
            'places' => Place::orderBy('name')->get(),
        ]);
    }

    public function transfer(Request $request, Thing $thing)
    {
        $this->authorize('transfer', $thing);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
        ]);

        // если вещь уже была выдана — перезаписываем
        Usage::updateOrCreate(
            ['thing_id' => $thing->id],
            [
                'user_id' => $data['user_id'],
                'place_id' => $data['place_id'],
            ]
        );

        return redirect()
            ->route('things.show', $thing)
            ->with('status', 'Вещь передана пользователю');
    }

    public function archive()
{
    $archives = \App\Models\ThingArchive::orderBy('created_at', 'desc')->get();

    return view('things.archive', compact('archives'));
}

public function restoreFromArchive($id)
{
    $archive = \App\Models\ThingArchive::findOrFail($id);

    if ($archive->restored) {
        return back()->with('status', 'Вещь уже восстановлена');
    }

    $thing = Thing::create([
        'name' => $archive->name,
        'description' => $archive->description,
        'master_id' => Auth::id(), // хозяин = кто восстановил
    ]);

    $archive->update([
        'restored' => true,
    ]);

    Cache::forget('things.all');

    return redirect()
        ->route('things.archive')
        ->with('status', 'Вещь восстановлена из архива');
}



}

