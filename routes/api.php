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
});

Route::prefix("post")->group(function() {
    Route::get("", [PostController::class, 'getPosts'])->name('posts.get');
    Route::get("{id}", [PostController::class, 'getPost'])->name('post.get');

    Route::middleware('auth:sanctum')->post("", [PostController::class, 'createPost'])->name('post.create');
});

Route::middleware('auth:sanctum')
->group(function() {
    Route::prefix("file")->group(function() {
        Route::post("upload", [FileController::class, 'uploadFile'])->name('file.upload');
    });

    Route::prefix("character")->group(function() {
        Route::post("", [CharacterController::class, 'createCharacter'])->name('character.create');
        Route::get("", [CharacterController::class, 'getCharacters'])->name('characters.get');
        Route::get("{id}", [CharacterController::class, 'getCharacter'])->name('character.get');
    });
});
