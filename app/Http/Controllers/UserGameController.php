<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGame;

class UserGameController extends Controller
{
    public function index () {
        // Response function allows us to send response
        return response(content: UserGame::all(), status: 200)
        ->header('Content-Type', 'application/json');
    }
    
    public function show($id){
        return response(UserGame::findOrFail($id), 200)
        ->header('Content-Type', 'application/json');
    }
}
