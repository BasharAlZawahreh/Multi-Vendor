<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;



Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    return [
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'),
        Route::resource('categories', CategoriesController::class),
    ];
});

    // ->middleware(['auth', 'verified'])
