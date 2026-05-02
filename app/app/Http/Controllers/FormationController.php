<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::where('is_active', true)->get();

        return Inertia::render('Formations/Index', compact('formations'));
    }

    public function show(string $slug)
    {
        $formation = Formation::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return Inertia::render('Formations/Show', compact('formation'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
