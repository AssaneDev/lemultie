<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminArticleController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Articles/Index', [
            'articles' => Article::with('author')->latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Articles/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|unique:articles,slug',
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'type'         => 'required|in:article,conference',
            'is_published' => 'boolean',
            'is_premium'   => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['user_id'] = Auth::id();
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article créé.');
    }

    public function show(Article $article) {}

    public function edit(Article $article)
    {
        return Inertia::render('Admin/Articles/Form', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|unique:articles,slug,' . $article->id,
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'type'         => 'required|in:article,conference',
            'is_published' => 'boolean',
            'is_premium'   => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        if ($data['is_published'] && !$article->published_at) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article supprimé.');
    }
}
