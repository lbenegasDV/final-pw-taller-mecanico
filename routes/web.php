<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MecanicoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\OrdenRepuestoController;
use App\Http\Controllers\HistorialTrabajoController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil (rutas que trae Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes (admin + recepcionista según middleware/controlador)
    Route::resource('clientes', ClienteController::class);

    // Vehículos (admin + recepcionista)
    Route::resource('vehiculos', VehiculoController::class);

        // Repuestos (solo admin)
    Route::resource('repuestos', RepuestoController::class);

    // Órdenes (admin + recepcionista)
    // El parameters() asegura que el route model binding use {orden} y encaje con Orden $orden
    Route::resource('ordenes', OrdenController::class)
        ->parameters(['ordenes' => 'orden']);

    // Mis órdenes (vista para mecánico)
    Route::get('mis-ordenes', [OrdenController::class, 'misOrdenes'])
        ->name('ordenes.mis-ordenes');

        // Mecánicos (solo admin)
    Route::resource('mecanicos', MecanicoController::class);

        // Repuestos utilizados en orden
    Route::post('ordenes/{orden}/repuestos', [OrdenRepuestoController::class, 'store'])
        ->name('ordenes.repuestos.store');
    Route::put('ordenes/{orden}/repuestos/{ordenRepuesto}', [OrdenRepuestoController::class, 'update'])
        ->name('ordenes.repuestos.update');
    Route::delete('ordenes/{orden}/repuestos/{ordenRepuesto}', [OrdenRepuestoController::class, 'destroy'])
        ->name('ordenes.repuestos.destroy');

    // Historial de trabajo
    Route::post('ordenes/{orden}/historial', [HistorialTrabajoController::class, 'store'])
        ->name('ordenes.historial.store');
    Route::put('ordenes/{orden}/historial/{historial}', [HistorialTrabajoController::class, 'update'])
        ->name('ordenes.historial.update');
    Route::delete('ordenes/{orden}/historial/{historial}', [HistorialTrabajoController::class, 'destroy'])
        ->name('ordenes.historial.destroy');

});

require __DIR__ . '/auth.php';
