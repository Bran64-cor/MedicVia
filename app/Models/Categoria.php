<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'Categorias';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = ['nombre_categoria', 'descripcion'];

    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_categoria');
    }
}
?>