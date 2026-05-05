<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'youtube_url'      => 'nullable|url',
            'audio_file'       => 'nullable|file|mimes:mp3,ogg,wav,m4a|max:102400',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('audio_file')) {
            $data['audio_file'] = $request->file('audio_file')->store('meditations/audio', 'public');
        } else {
            unset($data['audio_file']);
        }

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
            'youtube_url'      => 'nullable|url',
            'audio_file'       => 'nullable|file|mimes:mp3,ogg,wav,m4a|max:102400',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('audio_file')) {
            if ($meditation->audio_file) {
                Storage::disk('public')->delete($meditation->audio_file);
            }
            $data['audio_file'] = $request->file('audio_file')->store('meditations/audio', 'public');
        } else {
            unset($data['audio_file']);
        }

        $meditation->update($data);

        return redirect()->route('admin.meditations.index')->with('success', 'Méditation mise à jour.');
    }

    public function destroy(Meditation $meditation)
    {
        if ($meditation->audio_file) {
            Storage::disk('public')->delete($meditation->audio_file);
        }

        $meditation->delete();

        return redirect()->route('admin.meditations.index')->with('success', 'Méditation supprimée.');
    }
}
