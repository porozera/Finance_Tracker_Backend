<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoriesController::class);
Route::apiResource('transactions', TransactionsController::class);
Route::apiResource('users', UsersController::class);



