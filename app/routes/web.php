<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\MeditationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminFormationController;
use App\Http\Controllers\Admin\AdminMeditationController;
use App\Http\Controllers\Admin\AdminArticleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Home');
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

    Route::resource('services', AdminServiceController::class);
    Route::resource('formations', AdminFormationController::class);
    Route::resource('meditations', AdminMeditationController::class);
    Route::resource('articles', AdminArticleController::class);
});

require __DIR__.'/auth.php';
