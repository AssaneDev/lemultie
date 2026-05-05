<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\MeditationController;
use App\Http\Controllers\ArticleController;
use App\Models\Formation;
use App\Models\Meditation;
use App\Models\Article;
use App\Models\Service;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminFormationController;
use App\Http\Controllers\Admin\AdminMeditationController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AiWriterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Home', [
        'services'    => Service::where('is_active', true)->orderBy('order')->get(['id', 'title', 'slug', 'description', 'category', 'is_premium']),
        'meditations' => Meditation::where('is_active', true)->latest()->take(3)->get(['id', 'title', 'slug', 'theme', 'duration_seconds', 'type', 'youtube_url', 'audio_file', 'is_premium']),
        'formations'  => Formation::where('is_active', true)->latest()->take(3)->get(['id', 'title', 'slug', 'description', 'price', 'level', 'duration_hours', 'is_premium']),
        'articles'    => Article::where('is_published', true)->latest()->take(3)->get(['id', 'title', 'slug', 'excerpt', 'published_at', 'type']),
    ]);
})->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
Route::get('/formations/{slug}', [FormationController::class, 'show'])->name('formations.show');

Route::get('/meditations', [MeditationController::class, 'index'])->name('meditations.index');
Route::get('/meditations/{slug}', [MeditationController::class, 'show'])->name('meditations.show');

Route::get('/blog', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/blog/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/conferences', [ArticleController::class, 'conferences'])->name('conferences.index');

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/espace-membre', function () {
        return Inertia::render('Member/Index');
    })->name('member.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::post('/ai/generate', [AiWriterController::class, 'generate'])->name('ai.generate');
    Route::get('/ai/tones', [AiWriterController::class, 'tones'])->name('ai.tones');

    Route::resource('services', AdminServiceController::class);
    Route::resource('formations', AdminFormationController::class);
    Route::resource('meditations', AdminMeditationController::class);
    Route::resource('articles', AdminArticleController::class);
});

require __DIR__.'/auth.php';
