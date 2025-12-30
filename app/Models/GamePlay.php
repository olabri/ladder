<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Game;
use App\Models\User;

class GamePlay extends Model
{
    /** @use HasFactory<\Database\Factories\GamePlayFactory> */
    use HasFactory;
    protected $primaryKey = 'id';

    public const LOCATION_FOLK = 'FOLK';

    protected $fillable = [
        'date_played',
        'game_id',
        'location',
        'results'
    ];

    protected $casts = [
        'results' => 'array',
        'date_played' => 'date',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function primaryPlayer(): ?User
    {
        $player = $this->results[0]['user_id'] ?? null;
        return $player ? User::find($player) : null;
    }

    public static function index(): array
    {
        return GamePlay::with('game')->orderByDesc('date_played')->get()->map(function (GamePlay $play) {
            return [
                'id' => $play->id,
                'date_played' => $play->date_played->toDateString(),
                'game_id' => $play->game_id,
                'game_name' => $play->game?->name,
                'location' => $play->location,
                'results' => $play->results,
            ];
        })->toArray();
    }
}
