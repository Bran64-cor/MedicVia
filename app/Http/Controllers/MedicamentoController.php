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
    public function create()
{
    $categorias = Categoria::all();
    return view('medicamentos.create', compact('categorias'));
}

public function store(Request $request)
{
    $request->validate([
        'nombre'             => 'required|string|max:255',
        'cantidad'           => 'required|integer|min:0',
        'fecha_caducidad'    => 'required|date',
        'id_categoria'       => 'required|exists:categorias,id_categoria',
        'accion_recomendada' => 'nullable|string|max:500',
    ]);

    // Calcular estado automáticamente
    $fecha = \Carbon\Carbon::parse($request->fecha_caducidad);
    $hoy   = \Carbon\Carbon::today();

    if ($fecha->lt($hoy)) {
        $estado = 'Caducado';
    } elseif ($fecha->diffInDays($hoy) <= 30) {
        $estado = 'Próximo a caducar';
    } else {
        $estado = 'Vigente';
    }

    Medicamento::create([
        'nombre'             => $request->nombre,
        'cantidad'           => $request->cantidad,
        'fecha_caducidad'    => $request->fecha_caducidad,
        'estado'             => $estado,
        'accion_recomendada' => $request->accion_recomendada,
        'id_categoria'       => $request->id_categoria,
        'id_usuario_registro'=> auth()->id() ?? 1,
    ]);

    return redirect()->route('medicamentos.index')
                     ->with('success', 'Medicamento registrado correctamente.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nombre'             => 'required|string|max:255',
        'cantidad'           => 'required|integer|min:0',
        'fecha_caducidad'    => 'required|date',
        'id_categoria'       => 'required|exists:categorias,id_categoria',
        'accion_recomendada' => 'nullable|string|max:500',
    ]);
 
    $medicamento = Medicamento::findOrFail($id);
 
    // Recalcular estado automáticamente
    $fecha = \Carbon\Carbon::parse($request->fecha_caducidad);
    $hoy   = \Carbon\Carbon::today();
 
    if ($fecha->lt($hoy)) {
        $estado = 'Caducado';
    } elseif ($fecha->diffInDays($hoy) <= 30) {
        $estado = 'Próximo a caducar';
    } else {
        $estado = 'Vigente';
    }
 
    $medicamento->update([
        'nombre'             => $request->nombre,
        'cantidad'           => $request->cantidad,
        'fecha_caducidad'    => $request->fecha_caducidad,
        'estado'             => $estado,
        'accion_recomendada' => $request->accion_recomendada,
        'id_categoria'       => $request->id_categoria,
    ]);
 
    return redirect()->route('medicamentos.index')
                     ->with('success', 'Medicamento actualizado correctamente.');
}
 
public function destroy($id)
{
    $medicamento = Medicamento::findOrFail($id);
    $nombre      = $medicamento->nombre;
    $medicamento->delete();
 
    return redirect()->route('medicamentos.index')
                     ->with('deleted', "\"$nombre\" fue eliminado del inventario.");
}
}