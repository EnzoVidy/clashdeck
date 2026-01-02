<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- Partie Publique (Visiteur) ---
Route::get('/', [DeckController::class, 'index'])->name('home');
Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
Route::get('/decks/{deck}', [DeckController::class, 'show'])->name('decks.show');

// --- Partie Membre (Connecté) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/my-decks', [DeckController::class, 'myDecks'])->name('decks.my');
    Route::get('/decks/create', [DeckController::class, 'create'])->name('decks.create');
    Route::post('/decks', [DeckController::class, 'store'])->name('decks.store');
    Route::get('/decks/{deck}/edit', [DeckController::class, 'edit'])->name('decks.edit');
    Route::patch('/decks/{deck}', [DeckController::class, 'update'])->name('decks.update');
    Route::delete('/decks/{deck}', [DeckController::class, 'destroy'])->name('decks.destroy');
    Route::post('/decks/{deck}/vote', [VoteController::class, 'store']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
