<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Models\Game;
use App\Models\GamePlay;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')
    ->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('dashboard/users', [DashboardController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.users.store');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('games', 'games', ["games"=>Game::all()->toArray()])
    ->name('index');

Route::get('game/{game:id}', function (Game $game) {
     return Game::show($game->id)->with('users', User::index());
    })->name('game');

Route::view('players', 'players', ["players"=>User::all()->toArray()])
    ->name('index');

Route::view('plays', 'plays', ["plays"=>GamePlay::index()])
  ->name('index');


require __DIR__.'/auth.php';
