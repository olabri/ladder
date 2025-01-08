<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Complexity;


class GamePlay extends Model
{
    /** @use HasFactory<\Database\Factories\GamePlayFactory> */
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'date_played',
        'game_id',
        'location',
        'results'
    ];

    protected $casts = [
        'results' => 'array'
    ];
        

    public static function index () {
        $ladder=$user=[];
        foreach (GamePlay::all()->toArray() as $play) {
            $game = Game::find($play['game_id']);
            $play['game'] = $game->name;
            $play['complexity'] = $game->complexity;
            $play['complexity_pretty'] = Complexity::get($game->complexity);
            foreach ($play['results'] as $key => $player) {
                if (!isset($user[$player])) {
                    $user[$player] = User::find($player);
                    $ladder[$player] = 0;
                }
                
                $play['xresults'][$key]['user_id'] = $user[$player]->id;
                $play['xresults'][$key]['user_name'] = $user[$player]->name;
                $play['xresults'][$key]['points'] = Complexity::points($key, $game->complexity) ?? 0;

                $ladder[$player]+=$play['xresults'][$key]['points'];
            }
            $play['results']=$play['xresults'];
            unset($play['xresults']);

            $plays[] = $play;
        }

        $plays['ladder'] = $ladder;

        return $plays;
    }

    public function update (array $attributes=[], array $options=[] ) {
        //dd ($attributes);
        //model::update();
        if (!isset($attributes['id'])) {
            return null;
        }
        $id = $attributes['id'];
        $gamePlay = GamePlay::find($id);
        if (isset($attributes['date_played'])) {
            $gamePlay->date_played = $attributes['date_played'];
        }
        if (isset($attributes['game_id'])) {
            $gamePlay->game_id = $attributes['game_id'];
        }
        if (isset($attributes['location'])) {
            $gamePlay->location = $attributes['location'];
        }

        if (isset($attributes['results'])) {
            $gamePlay->results = $attributes['results'];
        }
        
        return $gamePlay->save();
        
    }
}
