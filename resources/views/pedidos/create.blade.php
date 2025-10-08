<!DOCTYPE html>
<html>
<head>
    <title>Realizar Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select, input[type="number"] { width: 320px; padding: 8px; border: 1px solid #ddd; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .note { color: #6c757d; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>Realizar Pedido</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Cliente:</label>
            <select name="cliente_id" required>
                <option value="">Seleccione cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->cedula }} - {{ $cliente->nombre }} {{ $cliente->apellido }}
                    </option>
                @endforeach
            </select>
            @if($clientes->isEmpty())
                <div class="note">No hay clientes registrados. <a href="{{ route('clientes.create') }}">Crear uno aquí</a></div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Producto:</label>
            <select name="producto_id" required>
                <option value="">Seleccione producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }} (Stock disponible: {{ $producto->stock }})
                    </option>
                @endforeach
            </select>
            @if($productos->isEmpty())
                <div class="note">No hay productos con stock disponible. <a href="{{ route('productos.create') }}">Agregar productos aquí</a></div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Cantidad a comprar:</label>
            <input type="number" name="cantidad" value="{{ old('cantidad') }}" min="1" required>
        </div>
        
        <button type="submit" @if($clientes->isEmpty() || $productos->isEmpty()) disabled @endif>
            Realizar Pedido
        </button>
        <a href="{{ route('pedidos.index') }}">
            <button type="button" style="background: #6c757d;">Cancelar</button>
        </a>
    </form>
</body>
</html>