<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameAPIController extends Controller
{
    //
    public function index () {
        // Response function allows us to send response
        return response(content: Game::all(), 200)
        ->header('Content-Type', 'application/json');
    }

    public function show($id) {
        return response(content: Game::find($id), 200)
        ->header('Content-Type', 'application/json');
    }

    public function store(Request $request) {
        $game = new Game;
        $game->name = $request->name;
        $game->complexity = $request->complexity;
        $game->save();
        return response(content: $game, 201)
        ->header('Content-Type', 'application/json');
    }

    public function update(Request $request, $id) {
        $game = Game::find($id);
        $game->name = $request->name;
        $game->complexity = $request->complexity;
        $game->save();
        return response(content: $game, 200)
        ->header('Content-Type', 'application/json');
    }

    public function destroy($id) {
        $game = Game::find($id);
        $game->delete();
        return response(content: null, 204);
    }

    public function search($name) {
        return response(content: Game::where('name', 'like', '%'.$name.'%')->get(), 200)
        ->header('Content-Type', 'application/json');
    }

    public function searchComplexity($complexity) {
        return response(content: Game::where('complexity', 'like', '%'.$complexity.'%')->get(), 200)
        ->header('Content-Type', 'application/json');
    }

     
}
