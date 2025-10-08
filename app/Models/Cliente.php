<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Laravel usa 'id' como clave primaria por defecto
    protected $fillable = ['cedula', 'nombre', 'apellido'];
    
    // Un cliente puede tener muchos pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);  // Usa cliente_id por convención
    }
}
