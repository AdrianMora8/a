<!DOCTYPE html>
<html>
<head>
    <title>Historial de Pedidos</title>
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
    </style>
</head>
<body>
    <h1>Historial de Pedidos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('pedidos.create') }}" class="btn btn-success">Realizar Nuevo Pedido</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <strong>{{ $pedido->cliente->cedula }}</strong><br>
                    {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}
                </td>
                <td>{{ $pedido->producto->nombre }}</td>
                <td>{{ $pedido->cantidad }}</td>
                <td>{{ $pedido->total ? '$' . number_format($pedido->total, 2) : 'N/A' }}</td>
                <td>
                    <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar este pedido?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No hay pedidos registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="{{ route('clientes.index') }}" class="btn btn-primary">Ver Clientes</a>
        <a href="{{ route('productos.index') }}" class="btn btn-primary">Ver Productos</a>
    </div>

    @if($pedidos->count() > 0)
        <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 5px;">
            <h3>Resumen:</h3>
            <p><strong>Total de pedidos:</strong> {{ $pedidos->count() }}</p>
            <p><strong>Últimos pedidos:</strong> {{ $pedidos->take(5)->count() }} mostrados</p>
        </div>
    @endif
</body>
</html>