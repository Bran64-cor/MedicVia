<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'id_usuario';
    
    protected $fillable = ['nombre', 'correo', 'password'];
    protected $hidden = ['password'];

    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_usuario_registro');
    }
}
?>