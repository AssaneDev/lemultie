<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->where('is_published', true)
            ->where('type', 'article')
            ->latest('published_at')
            ->get();

        return Inertia::render('Blog/Index', compact('articles'));
    }

    public function conferences()
    {
        $conferences = Article::with('author')
            ->where('is_published', true)
            ->where('type', 'conference')
            ->latest('published_at')
            ->get();

        return Inertia::render('Conferences/Index', compact('conferences'));
    }

    public function show(string $slug)
    {
        $article = Article::with('author')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return Inertia::render('Blog/Show', compact('article'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
