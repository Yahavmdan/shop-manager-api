<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
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

//public routes

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::post('/check-token',[UserController::class, 'checkToken']);
Route::post('/send-forgot-password-email',[UserController::class, 'sendResetPasswordEmail']);
Route::put('reset-password', [UserController::class, 'resetPassword']);
//Route::get('/products/search/{name}', [ProductController::class, 'sort']);

//protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/post-profile-image', [FileController::class, 'store']);
    Route::post('/reset-password-form',[UserController::class, 'resetPasswordForm']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/search/{name}', [UserController::class, 'search']);


});
