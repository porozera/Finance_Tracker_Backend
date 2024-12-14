<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoriesController::class);
Route::apiResource('transactions', TransactionsController::class);
    


