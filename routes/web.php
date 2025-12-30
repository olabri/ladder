<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LadderController;
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

Route::patch('dashboard/users/{user}', [DashboardController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.users.update');

Route::post('dashboard/games', [DashboardController::class, 'storeGame'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.games.store');

Route::patch('dashboard/games/{game}', [DashboardController::class, 'updateGame'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.games.update');

Route::delete('dashboard/games/{game}', [DashboardController::class, 'destroyGame'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.games.destroy');

Route::post('dashboard/gameplays', [DashboardController::class, 'storeGamePlay'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.gameplays.store');

Route::patch('dashboard/gameplays/{gameplay}', [DashboardController::class, 'updateGamePlay'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.gameplays.update');

Route::delete('dashboard/gameplays/{gameplay}', [DashboardController::class, 'destroyGamePlay'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.gameplays.destroy');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('games', [LadderController::class, 'index'])
    ->name('games');

Route::get('game/{game:id}', function (Game $game) {
     return Game::show($game->id)->with('users', User::index());
    })->name('game');

Route::view('players', 'players', ["players"=>User::all()->toArray()])
    ->name('index');

Route::view('plays', 'plays', ["plays"=>GamePlay::index()])
  ->name('index');


require __DIR__.'/auth.php';
