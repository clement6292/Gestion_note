<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route pour le tableau de bord, maintenant avec le contrôleur
Route::get('/dashboard', [NoteController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour la gestion des notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create'); // Route pour le formulaire de création
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{id}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::post('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::get('/create-note', [NoteController::class, 'create'])->name('create-note');
    Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
    
    // Route pour afficher la corbeille
    Route::get('/notes/trash', [NoteController::class, 'trash'])->name('notes.trash');

    // Route pour restaurer une note
    Route::post('/notes/{id}/restore', [NoteController::class, 'restore'])->name('notes.restore');
});  


Route::get('/categories', [NoteController::class, 'getCategories']);




require __DIR__.'/auth.php';