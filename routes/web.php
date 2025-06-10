<?php

use Illuminate\Support\Facades\Route;

// Traemos los controladores
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\LocalidadeController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\TransporteController;
use App\Http\Controllers\TipoContactoController;
use App\Http\Controllers\TransporteSucursaleController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\SucursaleController;

/*
|--------------------------------------------------------------------------
| RUTAS WEB DEL SISTEMA
|--------------------------------------------------------------------------
| Las rutas vinculan una dirección de internet interna (URL) con un controlador
| y una función específica. Cada línea indica: "cuando pase esto, hacé esto".
*/

// =================== CLIENTES ===================
Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::post('clientes/{cliente}/toggle-retira', [ClienteController::class, 'toggleRetira'])->name('clientes.toggleRetira');
Route::post('clientes/sync', [ClienteController::class, 'sync'])->name('clientes.sync');

// =================== CONTACTOS (solo desde clientes) ===================
Route::prefix('clientes/{cliente}')->group(function () {
    Route::post('contactos', [ContactoController::class, 'store'])->name('clientes.contactos.store');
    Route::put('contactos/{contacto}', [ContactoController::class, 'update'])->name('clientes.contactos.update');
    Route::delete('contactos/{contacto}', [ContactoController::class, 'destroy'])->name('clientes.contactos.destroy');
});

// =================== PROVINCIAS ===================
Route::resource('provincias', ProvinciaController::class)->except(['show']);

// =================== LOCALIDADES ===================
Route::resource('localidades', LocalidadeController::class)->except(['show']);

/* AJAX - LOCALIDADES POR PROVINCIA
 * Sirve para que, por ejemplo, al seleccionar una provincia, traiga solo las localidades de esa provincia.
 * La ruta es llamada con JS (AJAX), no desde un formulario clásico.
 */
Route::get('ajax/localidades/{provincia_id}', [LocalidadeController::class, 'getByProvincia'])->name('ajax.localidades.byProvincia');

// =================== ZONAS ===================
Route::resource('zonas', ZonaController::class)->except(['show']);

/* AJAX - ZONA POR LOCALIDAD
 * Cuando seleccionás una localidad, esta ruta devuelve la zona automáticamente
 * para usarlo en los formularios (no editable manualmente, se elige sola).
 */
Route::get('ajax/zona-por-localidad/{localidad_id}', [ZonaController::class, 'getByLocalidad'])->name('ajax.zona.byLocalidad');

// =================== TRANSPORTES ===================
/*
 * Los transportes no se borran, sólo se inactivan con un toggle.
 */
Route::resource('transportes', TransporteController::class)->except(['show', 'destroy']); // no hay destroy, sólo toggle

// Toggle para activo/inactivo en transportes
Route::post('transportes/{transporte}/toggle', [TransporteController::class, 'toggle'])->name('transportes.toggle');

// =================== TRANSPORTE SUCURSALES ===================
/*
 * ABM para las sucursales de transporte (lugares donde se retira/entrega mercadería por transporte)
 */
Route::resource('transporte-sucursales', TransporteSucursaleController::class)->except(['show']);

/* AJAX - SUCURSALES DE TRANSPORTE POR TRANSPORTE
 * Sirve para cargar las sucursales solo del transporte elegido (usado en select dependiente).
 */
Route::get('ajax/transporte-sucursales/{transporte_id}', [TransporteSucursaleController::class, 'getByTransporte'])->name('ajax.transporteSucursales.byTransporte');

// =================== TIPO DE CONTACTO ===================
Route::resource('tipo-contactos', TipoContactoController::class)->except(['show']);
// Sucursales por cliente (solo dentro de clientes)
Route::post('clientes/{cliente}/sucursales', [SucursaleController::class, 'store'])->name('clientes.sucursales.store');
Route::put('clientes/{cliente}/sucursales/{sucursale}', [SucursaleController::class, 'update'])->name('clientes.sucursales.update');
Route::delete('clientes/{cliente}/sucursales/{sucursale}', [SucursaleController::class, 'destroy'])->name('clientes.sucursales.destroy');
Route::get('/ajax/localidades/{provincia}', function($provinciaId){
    return \App\Models\Localidade::where('provincia_id', $provinciaId)->orderBy('nombre')->get(['id','nombre']);
});
