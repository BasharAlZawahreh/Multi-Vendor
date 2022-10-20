<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ProductsController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('webhook', function(){
    logger(request()->all());
})->name('user');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/add-to-wishlist', [HomeController::class, 'addToWishlist'])->name('products.add-to-wishlist');
});

Route::get('/products', [ProductsController::class, 'index'])->name('front.products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('front.products.show');

Route::resource('cart', CartController::class);

Route::post('/paypal/webhook',function(){
    return 'webhook called';
});


require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
