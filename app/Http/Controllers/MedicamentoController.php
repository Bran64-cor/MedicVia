<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Categoria;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener todas las categorías para el filtro del toolbar
        $categorias = Categoria::all();

        // 2. Query base con relación a categoría
        $query = Medicamento::with('categoria');

        // 3. Aplicar filtros si existen en la URL
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        $medicamentos = $query->get();

        // 4. Calcular estadísticas para las Stat Cards
        $stats = [
            'total' => $medicamentos->count(),
            'vigentes' => $medicamentos->where('estado', 'Vigente')->count(),
            'proximos' => $medicamentos->where('estado', 'Próximo a caducar')->count(),
            'caducados' => $medicamentos->where('estado', 'Caducado')->count(),
        ];

        return view('medicamentos.index', compact('medicamentos', 'categorias', 'stats'));
    }
}