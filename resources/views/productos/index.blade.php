<!DOCTYPE html>
<html>
<head>
    <title>Lista de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 8px 12px; margin: 2px; text-decoration: none; border-radius: 4px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .stock-bajo { background-color: #ffebee; }
        .stock-alto { background-color: #e8f5e8; }
    </style>
</head>
<body>
    <h1>Lista de Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('productos.create') }}" class="btn btn-success">Crear/Agregar Producto</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr class="{{ $producto->stock < 5 ? 'stock-bajo' : ($producto->stock > 20 ? 'stock-alto' : '') }}">
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->stock }}</td>
                <td>
                    @if($producto->stock == 0)
                        <span style="color: red;">Sin Stock</span>
                    @elseif($producto->stock < 5)
                        <span style="color: orange;">Stock Bajo</span>
                    @else
                        <span style="color: green;">Disponible</span>
                    @endif
                </td>
                <td>{{ $producto->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No hay productos registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="{{ route('clientes.index') }}" class="btn btn-primary">Ver Clientes</a>
        <a href="{{ route('pedidos.index') }}" class="btn btn-primary">Ver Pedidos</a>
    </div>
</body>
</html>