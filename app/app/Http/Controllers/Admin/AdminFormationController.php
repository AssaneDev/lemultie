<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminFormationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Formations/Index', [
            'formations' => Formation::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Formations/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|unique:formations,slug',
            'description'    => 'required|string',
            'content'        => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'level'          => 'required|in:debutant,intermediaire,avance',
            'duration_hours' => 'nullable|integer|min:0',
            'max_students'   => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
            'is_premium'     => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        Formation::create($data);

        return redirect()->route('admin.formations.index')->with('success', 'Formation créée.');
    }

    public function show(Formation $formation) {}

    public function edit(Formation $formation)
    {
        return Inertia::render('Admin/Formations/Form', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|unique:formations,slug,' . $formation->id,
            'description'    => 'required|string',
            'content'        => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'level'          => 'required|in:debutant,intermediaire,avance',
            'duration_hours' => 'nullable|integer|min:0',
            'max_students'   => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
            'is_premium'     => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $formation->update($data);

        return redirect()->route('admin.formations.index')->with('success', 'Formation mise à jour.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();

        return redirect()->route('admin.formations.index')->with('success', 'Formation supprimée.');
    }
}
