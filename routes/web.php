<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Home\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::post('/webhook',function(){
    logger(request()->all());
});


require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
