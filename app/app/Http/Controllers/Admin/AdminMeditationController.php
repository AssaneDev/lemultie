<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meditation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminMeditationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Meditations/Index', [
            'meditations' => Meditation::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Meditations/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|unique:meditations,slug',
            'description'      => 'nullable|string',
            'type'             => 'required|in:audio,video,both',
            'theme'            => 'required|in:relaxation,sommeil,concentration,energie,guerison,autre',
            'duration_seconds' => 'nullable|integer|min:0',
            'is_active'        => 'boolean',
            'is_premium'       => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        Meditation::create($data);

        return redirect()->route('admin.meditations.index')->with('success', 'Méditation créée.');
    }

    public function show(Meditation $meditation) {}

    public function edit(Meditation $meditation)
    {
        return Inertia::render('Admin/Meditations/Form', compact('meditation'));
    }

    public function update(Request $request, Meditation $meditation)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|unique:meditations,slug,' . $meditation->id,
            'description'      => 'nullable|string',
            'type'             => 'required|in:audio,video,both',
            'theme'            => 'required|in:relaxation,sommeil,concentration,energie,guerison,autre',
            'duration_seconds' => 'nullable|integer|min:0',
            'is_active'        => 'boolean',
            'is_premium'       => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $meditation->update($data);

        return redirect()->route('admin.meditations.index')->with('success', 'Méditation mise à jour.');
    }

    public function destroy(Meditation $meditation)
    {
        $meditation->delete();

        return redirect()->route('admin.meditations.index')->with('success', 'Méditation supprimée.');
    }
}
