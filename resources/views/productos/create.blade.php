<!DOCTYPE html>
<html>
<head>
    <title>Crear/Agregar Stock Producto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 300px; padding: 8px; border: 1px solid #ddd; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .note { color: #6c757d; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>Crear/Agregar Stock de Producto</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
            <div class="note">Si el producto ya existe, se sumará al stock existente</div>
        </div>
        
        <div class="form-group">
            <label>Cantidad a agregar:</label>
            <input type="number" name="stock" value="{{ old('stock') }}" min="1" required>
        </div>
        
        <button type="submit">Crear/Agregar Stock</button>
        <a href="{{ route('productos.index') }}">
            <button type="button" style="background: #6c757d;">Cancelar</button>
        </a>
    </form>
</body>
</html>