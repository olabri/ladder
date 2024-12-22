<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\GameController;

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
        $game= Game::get()->where('id', $id)[0]->toArray();

        $game['gameplays']=GamePlay::get()->where('game_id', $id);

       

        return view('game', ['game'=>$game]);

    }

}
