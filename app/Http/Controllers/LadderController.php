<?php

namespace App\Http\Controllers;

use App\Models\GamePlay;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class LadderController extends Controller
{
    public function index(): View
    {
        $gameplays = GamePlay::with('game')->orderByDesc('date_played')->get();

        $points = [];
        foreach ($gameplays as $play) {
            foreach ($play->results ?? [] as $result) {
                $userId = $result['user_id'] ?? null;
                if (!$userId) {
                    continue;
                }
                $points[$userId] = ($points[$userId] ?? 0) + ($result['points'] ?? 0);
            }
        }

        $users = User::whereIn('id', array_keys($points))->get()->keyBy('id');

        $rankings = collect($points)
            ->map(fn (int $score, int $userId) => [
                'user' => $users->get($userId),
                'points' => $score,
            ])
            ->filter(fn (array $entry) => $entry['user'] !== null)
            ->sortByDesc('points')
            ->values();

        return view('games', [
            'rankings' => $rankings,
            'gameplays' => $gameplays,
            'users' => $users,
        ]);
    }
}
