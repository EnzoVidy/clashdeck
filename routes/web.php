<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- 1. Routes Publiques ---
Route::get('/', [DeckController::class, 'index'])->name('home');
Route::get('/cards', [CardController::class, 'index'])->name('cards.index');

Route::get('/user/{user}', [DeckController::class, 'publicProfile'])->name('profile.public');

// --- 2. Routes Authentifiées ---
Route::middleware(['auth'])->group(function () {
    Route::get('/my-decks', [DeckController::class, 'myDecks'])->name('decks.my');
    Route::get('/decks/create', [DeckController::class, 'create'])->name('decks.create');
    Route::post('/decks', [DeckController::class, 'store'])->name('decks.store');
    Route::get('/decks/{deck}/edit', [DeckController::class, 'edit'])->name('decks.edit');
    Route::patch('/decks/{deck}', [DeckController::class, 'update'])->name('decks.update');
    Route::delete('/decks/{deck}', [DeckController::class, 'destroy'])->name('decks.destroy');

    Route::post('/decks/{deck}/vote', [VoteController::class, 'store'])->name('votes.store');

    Route::get('/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
    Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::patch('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 3. Route Wildcard ---
Route::get('/decks/{deck}', [DeckController::class, 'show'])->name('decks.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';