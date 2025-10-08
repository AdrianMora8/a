<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'producto'])->latest()->get();
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);
        
        $producto = Producto::find($request->producto_id);
        
        // Verificar stock disponible
        if (!$producto->tieneStock($request->cantidad)) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Stock insuficiente. Solo hay {$producto->stock} unidades de {$producto->nombre}");
        }
        
        // Crear el pedido
        $pedido = Pedido::create([
            'cliente_id' => $request->cliente_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad
        ]);
        
        // Reducir stock del producto
        $stockAnterior = $producto->stock;
        $producto->reducirStock($request->cantidad);
        
        return redirect()->route('pedidos.index')
            ->with('success', "Pedido creado. Stock actualizado: {$producto->nombre} ({$stockAnterior} - {$request->cantidad} = {$producto->stock})");
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();
        return view('pedidos.edit', compact('pedido', 'clientes', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);
        
        $pedido->update($request->all());
        
        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido eliminado exitosamente');
    }
}
