<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
        

    public function index () {
        return GamePlay::all()->toArray();
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
        $gamePlay->save();
        return $gamePlay;
        
    }
}
