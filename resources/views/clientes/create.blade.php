<!DOCTYPE html>
<html>
<head>
    <title>Crear Cliente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 300px; padding: 8px; border: 1px solid #ddd; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <h1>Crear Cliente</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Cédula:</label>
            <input type="text" name="cedula" value="{{ old('cedula') }}" required>
        </div>
        
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        
        <div class="form-group">
            <label>Apellido:</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required>
        </div>
        
        <button type="submit">Crear Cliente</button>
        <a href="{{ route('clientes.index') }}">
            <button type="button" style="background: #6c757d;">Cancelar</button>
        </a>
    </form>
</body>
</html>