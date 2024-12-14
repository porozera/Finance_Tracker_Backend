<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SavingGoalsController;
use App\Http\Controllers\TransactionsController;



    Route::apiResource('categories', CategoriesController::class);
    Route::apiResource('saving-goals', SavingGoalsController::class);



