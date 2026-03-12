<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ListingsApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/listings/city',[ListingsApiController::class,'index']);