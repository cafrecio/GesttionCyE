<?php

use App\Http\Controllers\LocalidadeController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\ZonaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return view('welcome'); // Esta es la ruta por defecto de Laravel
});

Route::resource('provincias', ProvinciaController::class);
Route::resource('zonas', ZonaController::class);
Route::resource('localidades', LocalidadeController::class);