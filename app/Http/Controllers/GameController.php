<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    //
    public function index () {
        // Response function allows us to send response
        return response(content: Game::all(), 200)
        ->header('Content-Type', 'application/json');
    }
}
