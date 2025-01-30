<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// rutas para products
Route::get('/v1/products', [ProductController::class,'index']);
Route::post('/v1/products', [ProductController::class, 'store']);
Route::get('/v1/products/{productId}', [ProductController::class,'productById']);
Route::patch('/v1/products/{productId}', [ProductController::class,'update']);

Route::get('/v1/products/{productId}/comments', [CommentController::class, 'indexByProduct']);
Route::post('/v1/products/{productId}/comments', [CommentController::class, 'storeForProduct']);

// rutas para comments

Route::get('/v1/comments', [CommentController::class,'index']);
Route::post('/v1/comments', [CommentController::class,'store']);
Route::get('/v1/comments/{commentId}', [CommentController::class,'show']);
