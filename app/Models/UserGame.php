<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    
    
    //
    protected $fillable = [
        'date',  
        'user_id',
        'game_id',
        'position',
    ];
}
