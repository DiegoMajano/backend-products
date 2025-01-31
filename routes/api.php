<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/v1/products', [ProductController::class, 'store']);
    Route::patch('/v1/products/{productId}', [ProductController::class,'update']);
    Route::delete('/v1/products/{productId}', [ProductController::class, 'destroy']);

    Route::post('/v1/products/{productId}/comments', [CommentController::class, 'storeForProduct']);
    Route::post('/v1/comments', [CommentController::class,'store']);

    Route::post('/v1/logout',[AuthController::class, 'logout']);


});

// rutas para products
Route::get('/v1/products', [ProductController::class,'index']);
Route::get('/v1/products/{productId}', [ProductController::class,'productById']);

Route::get('/v1/products/{productId}/comments', [CommentController::class, 'indexByProduct']);



// rutas para comments

Route::get('/v1/comments', [CommentController::class,'index']);
Route::get('/v1/comments/{commentId}', [CommentController::class,'show']);

// rutas para user

Route::post('/v1/user/login', [AuthController::class,'login']);

Route::get('/token', function(){
    return response()->json(['mensaje'=>'Necesitas un token'], 401);
})->name('login');

Route::post('/v1/user/register', [AuthController::class, 'register']);
