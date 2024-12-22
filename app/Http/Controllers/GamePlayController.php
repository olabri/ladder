<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GamePlay;


class GamePlayController extends Controller
{
    //
    public function index () {
        // Response function allows us to send response
        return response(content: GamePlay::all(), 200)
        ->header('Content-Type', 'application/json');
    }

    public function show () {
        // Response function allows us to send response
        return response(content: GamePlay::all(), 200)
        ->header('Content-Type', 'application/json');
    }
}
