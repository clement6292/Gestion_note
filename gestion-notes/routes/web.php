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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour la gestion des notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create'); // Route pour le formulaire de création
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{id}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::get('/create-note', [NoteController::class, 'create'])->name('create-note');
   Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
});
Route::get('/categories', [NoteController::class, 'getCategories']);
// Cette route pourrait être retirée si vous n'en avez pas besoin

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/create-note', function () {
//         return Inertia::render('CreateNote');
//     })->name('notes.create'); // Retirer cette route si la précédente est gardée
// });



require __DIR__.'/auth.php';