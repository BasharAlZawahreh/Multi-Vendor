<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    return [
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'),

        Route::resource('categories', CategoriesController::class)->where([
            'category' => '[0-9]+'
        ]),
        Route::delete('categories/{id}/hard_delete', [CategoriesController::class, 'hardDelete'])->name('cat.hard_delete'),
        Route::put('categories/{id}/restore', [CategoriesController::class, 'restoreTrashed'])->name('cat.restore'),
        Route::resource('products', ProductController::class),
        Route::get('categories/trashed', [CategoriesController::class, 'trsashed'])->name('cat.trashed'),

        Route::get('profile/edit', [ProfileController::class,'edit'])->name('profiles.edit'),
        Route::put('profile', [ProfileController::class,'update'])->name('profiles.update'),
    ];
});

    // ->middleware(['auth', 'verified'])
