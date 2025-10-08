<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'stock'];
    
    // Un producto puede estar en muchos pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
    
    // Método para aumentar stock
    public function aumentarStock($cantidad)
    {
        $this->increment('stock', $cantidad);
        return $this;
    }
    
    // Método para reducir stock
    public function reducirStock($cantidad)
    {
        if ($this->stock >= $cantidad) {
            $this->decrement('stock', $cantidad);
            return true;
        }
        return false; // No hay suficiente stock
    }
    
    // Verificar si hay stock disponible
    public function tieneStock($cantidad)
    {
        return $this->stock >= $cantidad;
    }
}
