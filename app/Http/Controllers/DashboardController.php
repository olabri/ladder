<?php

namespace App\Http\Controllers;

use App\Models\Complexity;
use App\Models\Game;
use App\Models\GamePlay;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user && $user->isAdmin(), 403);

        $users = User::orderByDesc('created_at')->get();
        $games = Game::orderBy('name')->get();
        $gameplays = GamePlay::with('game')->orderByDesc('date_played')->get();
        $players = User::orderBy('name')->get();

        return view('dashboard', [
            'users' => $users,
            'totalUsers' => $users->count(),
            'adminCount' => $users->where('is_admin', true)->count(),
            'gameAdminCount' => $users->where('is_game_admin', true)->count(),
            'games' => $games,
            'gameplays' => $gameplays,
            'players' => $players,
            'complexityLevels' => Complexity::level,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user && $user->isAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'is_admin' => ['sometimes', 'boolean'],
            'is_game_admin' => ['sometimes', 'boolean'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $request->boolean('is_admin'),
            'is_game_admin' => $request->boolean('is_game_admin'),
        ]);

        return back()->with('status', 'Ny bruker er opprettet.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $admin = $request->user();

        abort_unless($admin && $admin->isAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'is_admin' => ['sometimes', 'boolean'],
            'is_game_admin' => ['sometimes', 'boolean'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_admin' => $request->boolean('is_admin'),
            'is_game_admin' => $request->boolean('is_game_admin'),
        ]);

        return back()->with('status', 'Brukerprofil oppdatert.');
    }

    public function storeGame(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $validated = $request->validate([
            'game_name' => ['required', 'string', 'max:255'],
            'game_complexity' => ['required', 'string', 'max:255'],
        ]);

        Game::create([
            'name' => $validated['game_name'],
            'complexity' => $validated['game_complexity'],
        ]);

        return back()->with('status', 'Spill lagt til.');
    }

    public function updateGame(Request $request, Game $game): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $validated = $request->validate([
            'game_name' => ['required', 'string', 'max:255'],
            'game_complexity' => ['required', 'string', 'max:255'],
        ]);

        $game->update([
            'name' => $validated['game_name'],
            'complexity' => $validated['game_complexity'],
        ]);

        return back()->with('status', 'Spill oppdatert.');
    }

    public function destroyGame(Request $request, Game $game): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);
        $game->delete();

        return back()->with('status', 'Spill slettet.');
    }

    public function storeGamePlay(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $validated = $request->validate([
            'gameplay_game_id' => ['required', 'integer', 'exists:game,id'],
            'gameplay_players' => ['required', 'array', 'min:1'],
            'gameplay_players.*' => ['nullable', 'integer', 'exists:users,id'],
            'gameplay_date_played' => ['required', 'date'],
            'gameplay_location' => ['nullable', 'string', 'max:255'],
        ]);

        $game = Game::findOrFail($validated['gameplay_game_id']);
        $players = array_filter($validated['gameplay_players']);

        GamePlay::create([
            'game_id' => $game->id,
            'date_played' => $validated['gameplay_date_played'],
            'location' => $validated['gameplay_location'] ?? GamePlay::LOCATION_FOLK,
            'results' => $this->buildGameplayResults($players, $game),
        ]);

        return back()->with('status', 'Gameplay registrert.');
    }

    public function updateGamePlay(Request $request, GamePlay $gameplay): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $validated = $request->validate([
            'gameplay_game_id' => ['required', 'integer', 'exists:game,id'],
            'gameplay_players' => ['required', 'array', 'min:1'],
            'gameplay_players.*' => ['nullable', 'integer', 'exists:users,id'],
            'gameplay_date_played' => ['required', 'date'],
            'gameplay_location' => ['nullable', 'string', 'max:255'],
        ]);

        $game = Game::findOrFail($validated['gameplay_game_id']);
        $players = array_filter($validated['gameplay_players']);

        $gameplay->update([
            'game_id' => $game->id,
            'date_played' => $validated['gameplay_date_played'],
            'location' => $validated['gameplay_location'] ?? $gameplay->location,
            'results' => $this->buildGameplayResults($players, $game),
        ]);

        return back()->with('status', 'Gameplay oppdatert.');
    }

    public function destroyGamePlay(Request $request, GamePlay $gameplay): RedirectResponse
    {
        $request->user()->isAdmin() ?? abort(403);

        $gameplay->delete();

        return back()->with('status', 'Gameplay slettet.');
    }

    private function buildGameplayResults(array $playerIds, Game $game): array
    {
        $results = [];
        $level = (int) $game->complexity;

        foreach (array_values($playerIds) as $index => $playerId) {
            $place = $index + 1;
            $results[] = [
                'user_id' => (int) $playerId,
                'points' => Complexity::points($place, $level) ?? 0,
            ];
        }

        return $results;
    }
}
