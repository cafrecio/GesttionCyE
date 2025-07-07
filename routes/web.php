<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClienteController,
    ContactoController,
    SucursaleController,
    ProvinciaController,
    LocalidadeController,
    ZonaController,
    TransporteController,
    TransporteSucursaleController,
    TipoContactoController
};

/*
|--------------------------------------------------------------------------
| RUTAS DE CLIENTES
|--------------------------------------------------------------------------
*/
Route::get   ('clientes',                         [ClienteController::class,'index'])->name('clientes.index');        // LISTAR
Route::post  ('clientes/sync',                    [ClienteController::class,'sync'])->name('clientes.sync');          // SINCRONIZAR ERP
Route::post  ('clientes/{cliente}/toggle-retira', [ClienteController::class,'toggleRetira'])->name('clientes.toggleRetira'); // TOGGLE RETIRA

// Agrupamos las rutas “hijas” de contactos y sucursales para no repetir “clientes/{cliente}” cada vez
Route::prefix('clientes/{cliente}')->group(function(){
    // CONTACTOS (STORE, UPDATE, DESTROY)
    Route::post   ('contactos',           [ContactoController::class,'store'])->name('clientes.contactos.store');
    Route::put    ('contactos/{contacto}',[ContactoController::class,'update'])->name('clientes.contactos.update');
    Route::delete ('contactos/{contacto}',[ContactoController::class,'destroy'])->name('clientes.contactos.destroy');

    // SUCURSALES DE CLIENTE (STORE, UPDATE, DESTROY, TOGGLE)
    Route::post   ('sucursales',                  [SucursaleController::class,'store'])->name('clientes.sucursales.store');
    Route::put    ('sucursales/{sucursale}',      [SucursaleController::class,'update'])->name('clientes.sucursales.update');
    Route::delete ('sucursales/{sucursale}',      [SucursaleController::class,'destroy'])->name('clientes.sucursales.destroy');
    Route::post   ('sucursales/{sucursale}/toggle',[SucursaleController::class,'toggle'])->name('clientes.sucursales.toggle');
});

/*
|--------------------------------------------------------------------------
| CATÁLOGOS BÁSICOS
|--------------------------------------------------------------------------
*/
Route::resource('provincias',  ProvinciaController::class)->except(['show']);
Route::resource('localidades', LocalidadeController::class)->except(['show']);
Route::resource('zonas',       ZonaController::class)->except(['show']);

/*
| AJAX DEPENDIENTES (no llenan página, sólo devuelven JSON para selects)
*/
Route::get('ajax/localidades/{provincia_id}',       [LocalidadeController::class,'getByProvincia'])
     ->name('ajax.localidades.byProvincia');

Route::get('ajax/zona-por-localidad/{localidad_id}',[ZonaController::class,     'getByLocalidad'])
     ->name('ajax.zona.byLocalidad');

/*
|--------------------------------------------------------------------------
| TRANSPORTES y SUSCURSALES DE TRANSPORTE
|--------------------------------------------------------------------------
*/
Route::resource('transportes', TransporteController::class)
     ->except(['show','destroy']);  // no hay “show” ni “destroy” (se desactiva con toggle)

Route::post('transportes/{transporte}/toggle',
            [TransporteController::class,'toggle'])
     ->name('transportes.toggle');

Route::resource('transporte-sucursales', TransporteSucursaleController::class)
     ->except(['show']);            // cuarto CRUD con resource

Route::get('ajax/transporte-sucursales/{transporte_id}',
            [TransporteSucursaleController::class,'getByTransporte'])
     ->name('ajax.transporteSucursales.byTransporte');

/*
|--------------------------------------------------------------------------
| TIPO DE CONTACTO
|--------------------------------------------------------------------------
*/
Route::resource('tipo-contactos', TipoContactoController::class)
     ->except(['show']);

