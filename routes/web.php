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