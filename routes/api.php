<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SavingGoalsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\NotificationsController;

Route::apiResource('categories', CategoriesController::class);
Route::apiResource('transactions', TransactionsController::class);
Route::apiResource('users', UsersController::class);


    Route::apiResource('categories', CategoriesController::class);
    Route::apiResource('saving-goals', SavingGoalsController::class);
    Route::apiResource('notifications', NotificationsController::class);
    Route::apiResource('budgets', BudgetsController::class);



    //notification alrd readed
    Route::patch('notifications/{id}/read', [NotificationsController::class, 'markAsRead']);



