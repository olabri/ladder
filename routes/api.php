<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/user', function (Request $request) {
    return $request->user($id);
})->middleware('auth:sanctum');


Route::get('/users', function (Request $request) {
    return $request->users();
})->middleware('auth:sanctum');

//Route::get('/api/users', [UserController::class, 'index']);
//Route::get('/api/user/{id}', [UserController::class, 'show', $id]);

