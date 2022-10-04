<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TorodController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/webhook',function(){
    logger(request()->all());
});

Route::get('/torods_cities',[TorodController::class,'index']);

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
