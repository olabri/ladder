<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamePlay extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'date_played',
        'game_id',
        'location',
        
    ];

    public function index () {
        return GamePlay::all()->toArray();
    }
}
