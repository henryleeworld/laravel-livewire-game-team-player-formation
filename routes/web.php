<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameWinnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('games', GameController::class);
    Route::get('games/{game}/winners', [GameWinnerController::class, 'edit'])->name('games.winners');
    Route::post('games/{game}/winners', [GameWinnerController::class, 'update'])->name('game.winners.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('teams', TeamController::class);
});

require __DIR__.'/auth.php';
