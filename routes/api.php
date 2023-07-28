<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("user")->group(function() {
    Route::post("register", [UserController::class, 'register'])->name('user.register');
    Route::post("login", [UserController::class, 'login'])->name('user.login');

    Route::middleware('auth:sanctum')->
    get("", [UserController::class, 'getProfile'])->name('user.get.myprofile');
    
    Route::middleware('auth:sanctum')->
    get("{userName}", [UserController::class, 'getUserProfile'])->name('user.get');
});

Route::prefix("character")->group(function() {
    Route::middleware('auth:sanctum')->
    get("", [CharacterController::class, 'getCharacters'])->name('characters.get');
    Route::get("{id}", [CharacterController::class, 'getCharacter'])->name('character.get');

    Route::middleware('auth:sanctum')
    ->post("", [CharacterController::class, 'createCharacter'])->name('character.create');
});

Route::prefix("post")->group(function() {
    Route::get("", [PostController::class, 'getPosts'])->name('posts.get');
    Route::get("{id}", [PostController::class, 'getPost'])->name('post.get');

    Route::middleware('auth:sanctum')
    ->post("", [PostController::class, 'createPost'])->name('post.create');
});

Route::prefix("file")->group(function() {
    Route::get('{id}', [FileController::class, 'getFileUrl'])->name('file.geturl');

    Route::middleware('auth:sanctum')
    ->post("upload", [FileController::class, 'uploadFile'])->name('file.upload');
});
