<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Models\Game;
use App\Models\User;


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('games', 'game', ["games"=>Game::all()->toArray()])
    ->name('index');

Route::get('game/{game:id}', function (Game $game) {
     return Game::show($game->id);
    })->name('game');

Route::view('players', 'players', ["players"=>User::all()->toArray()])
    ->name('index');


require __DIR__.'/auth.php';
