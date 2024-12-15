<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamePlay extends Model
{
    //

    protected $fillable = [
        'date_played',
        'game_id',
        'location',
        
    ];
}
