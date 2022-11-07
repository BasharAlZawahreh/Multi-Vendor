<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;

Route::prefix('dashboard')->middleware(['auth.role:admin,super_admin'])->group(function () {
    return [
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'),

        Route::resource('categories', CategoriesController::class)->where([
            'category' => '[0-9]+'
        ]),
        Route::delete('categories/{id}/hard_delete', [CategoriesController::class, 'hardDelete'])->name('cat.hard_delete'),
        Route::put('categories/{id}/restore', [CategoriesController::class, 'restoreTrashed'])->name('cat.restore'),

        Route::get('products/import', [ImportProductsController::class, 'create'])->name('products.import'),
        Route::post('products/import', [ImportProductsController::class, 'store'])->name('products.import'),

        Route::resource('products', ProductController::class)->where([
            'product' => '[0-9]+'
        ]),
        Route::get('categories/trashed', [CategoriesController::class, 'trsashed'])->name('cat.trashed'),

        Route::get('profile/edit', [ProfileController::class,'edit'])->name('profiles.edit'),
        Route::put('profile', [ProfileController::class,'update'])->name('profiles.update'),

        Route::resource('/roles', RolesController::class)

    ];
});

    // ->middleware(['auth', 'verified'])
