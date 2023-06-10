<?php

use App\Http\Controllers\Auth\V1\LoginController;
use App\Http\Controllers\Auth\V1\LogoutController;
use App\Http\Controllers\Auth\V1\RegisterController;
use App\Http\Controllers\Post\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function(){
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/myposts', [PostController::class, 'myPosts']);
    Route::post('/createpost', [PostController::class, 'store']);
    Route::get('/post/{post}', [PostController::class, 'show']);
    Route::put('/updatepost/{post}', [PostController::class, 'update']);
    Route::delete('/deletepost/{post}', [PostController::class, 'delete']);
    Route::post('/logout', [LogoutController::class, 'logouts']);
});
