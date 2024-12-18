<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index () {
        // Response function allows us to send response
        return response(content: User::all())
        ->header('Content-Type', 'application/json');
    }
    
    public function show($id){
        return response(User::findOrFail($id), 200)
        ->header('Content-Type', 'application/json');
    }

    
}
