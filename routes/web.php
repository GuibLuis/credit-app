<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;

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
    return view('index');
});
Route::get('/historico', function () {
    return view('history');
});

Route::post('/offers', [ConsultaController::class, 'getOffers']);
Route::post('/store-consult', [ConsultaController::class, 'store']);