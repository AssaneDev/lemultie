<?php

namespace App\Http\Controllers;

use App\Models\Meditation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MeditationController extends Controller
{
    public function index(Request $request)
    {
        $query = Meditation::where('is_active', true);

        if ($request->theme) {
            $query->where('theme', $request->theme);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $meditations = $query->latest()->get();
        $themes = Meditation::distinct()->pluck('theme');

        return Inertia::render('Meditations/Index', compact('meditations', 'themes'));
    }

    public function show(string $slug)
    {
        $meditation = Meditation::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $meditation->increment('listen_count');

        return Inertia::render('Meditations/Show', compact('meditation'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
