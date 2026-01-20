<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;

class ThingController extends Controller
{
    public function index()
    {
        $things = Thing::all();

        return view('things.index', [
            'things' => $things,
        ]);
    }

    public function create()
    {
        return view('things.create');
    }

    public function store(Request $request)
    {
        Thing::create([
        'name' => $request->name,
        'description' => $request->description,
        'wrnt' => $request->wrnt,
        'master_id' => auth()->id(),
        ]);

        return redirect('/things');
    }

}


