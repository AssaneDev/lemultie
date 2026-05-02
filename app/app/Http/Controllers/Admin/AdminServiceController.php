<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Services/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:services,slug',
            'description' => 'required|string',
            'content'     => 'nullable|string',
            'category'    => 'required|in:copywriting,voix_off,percussion,conte,meditation,formation,conference',
            'price'       => 'nullable|numeric|min:0',
            'is_active'   => 'boolean',
            'is_premium'  => 'boolean',
            'order'       => 'integer',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service créé.');
    }

    public function show(Service $service) {}

    public function edit(Service $service)
    {
        return Inertia::render('Admin/Services/Form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:services,slug,' . $service->id,
            'description' => 'required|string',
            'content'     => 'nullable|string',
            'category'    => 'required|in:copywriting,voix_off,percussion,conte,meditation,formation,conference',
            'price'       => 'nullable|numeric|min:0',
            'is_active'   => 'boolean',
            'is_premium'  => 'boolean',
            'order'       => 'integer',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service mis à jour.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service supprimé.');
    }
}
