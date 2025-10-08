<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|unique:clientes,cedula|max:20',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255'
        ]);
        
        Cliente::create($request->all());
        
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'cedula' => 'required|string|unique:clientes,cedula,' . $cliente->id . '|max:20',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255'
        ]);
        
        $cliente->update($request->all());
        
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar si tiene pedidos antes de eliminar (RESTRICT en acción)
        if ($cliente->pedidos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el cliente porque tiene pedidos asociados');
        }
        
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente');
    }
}
