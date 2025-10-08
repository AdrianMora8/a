<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'stock' => 'required|integer|min:1'
        ]);
        
        // Buscar si ya existe un producto con ese nombre
        $producto = Producto::where('nombre', $request->nombre)->first();
        
        if ($producto) {
            // Si existe, aumentar stock
            $stockAnterior = $producto->stock;
            $producto->aumentarStock($request->stock);
            
            return redirect()->route('productos.index')
                ->with('success', "Stock actualizado: {$producto->nombre} ({$stockAnterior} + {$request->stock} = {$producto->stock})");
        } else {
            // Si no existe, crear nuevo producto
            $producto = Producto::create([
                'nombre' => $request->nombre,
                'stock' => $request->stock
            ]);
            
            return redirect()->route('productos.index')
                ->with('success', "Producto creado: {$producto->nombre} con stock inicial de {$producto->stock}");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'stock' => 'required|integer|min:0'
        ]);
        
        $producto->update($request->all());
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Verificar si tiene pedidos antes de eliminar (RESTRICT en acción)
        if ($producto->pedidos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el producto porque tiene pedidos asociados');
        }
        
        $producto->delete();
        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
