<?php

use App\Http\Controllers\MedicamentoController;
use Illuminate\Support\Facades\Route;

// Pantalla de bienvenida
Route::get('/', function () {
    return view('bienvenido');
});


// Pantalla principal del inventario
Route::get('/inventario', [MedicamentoController::class, 'index'])->name('medicamentos.index');

// Ruta para exportar (opcional)
Route::get('/exportar-medicamentos', [MedicamentoController::class, 'exportCSV'])->name('medicamentos.export');

Route::get('/medicamentos/crear', [MedicamentoController::class, 'create'])->name('medicamentos.create');
Route::post('/medicamentos', [MedicamentoController::class, 'store'])->name('medicamentos.store');

Route::get('/medicamentos',            [MedicamentoController::class, 'index'])  ->name('medicamentos.index');
Route::post('/medicamentos',           [MedicamentoController::class, 'store'])  ->name('medicamentos.store');
Route::put('/medicamentos/{id}',       [MedicamentoController::class, 'update']) ->name('medicamentos.update');
Route::delete('/medicamentos/{id}',    [MedicamentoController::class, 'destroy'])->name('medicamentos.destroy');