<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'date_registered',
        'complexity',
        'game_time',
    ];
}
