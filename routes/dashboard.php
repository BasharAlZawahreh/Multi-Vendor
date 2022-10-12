<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;



Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    return [
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'),

        Route::put('categories/{id}/restore', [CategoriesController::class, 'restoreTrashed'])->name('cat.restore'),
        Route::delete('categories/{id}/hard_delete', [CategoriesController::class, 'hardDelete'])->name('cat.hard_delete'),
        Route::resource('categories', CategoriesController::class)->where([
            'category' => '[0-9]+'
        ]),
            Route::get('categories/trashed', [CategoriesController::class, 'trsashed'])->name('cat.trashed'),
    ];
});

    // ->middleware(['auth', 'verified'])
