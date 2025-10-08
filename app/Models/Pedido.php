<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['cliente_id', 'producto_id', 'cantidad', 'total'];
    
    // Un pedido pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);  // Usa cliente_id automáticamente
    }
    
    // Un pedido pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);  // Usa producto_id automáticamente
    }
}
