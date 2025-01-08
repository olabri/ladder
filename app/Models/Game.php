<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;
    protected $table = 'game';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'complexity',
        
    ];

    public function index () {
        return Game::all()->toArray();
    }


    public static function show ($id) {
    
        if (is_array($game = Game::find($id)->toArray())) {
            $game['gameplays'] = GamePlay::get()->where('game_id', $id)->toArray();
        } else {
            throw new \Exception('Game not found');
        }  
        return view('game', ['game'=>$game]);

    }

}
