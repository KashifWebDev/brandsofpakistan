<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('blog-categories', BlogCategoryController::class);
Route::apiResource('blogs', BlogController::class);
