<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicamento extends Model
{
    protected $table = 'Medicamentos';
    public $timestamps = false; // Tu SQL no tiene created_at/updated_at

    protected $fillable = [
        'nombre', 'cantidad', 'fecha_caducidad', 
        'estado', 'accion_recomendada', 'id_categoria', 'id_usuario_registro'
    ];

    protected $casts = [
        'fecha_caducidad' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro');
    }
}
?>