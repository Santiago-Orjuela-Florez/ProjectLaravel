<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <main>
        <h1>Lista de Productos</h1>
        <a href="/producto/crear">Crear Nuevo Producto</a>
        <br>
        
        <ul>
            @foreach($productos as $producto)
                <li>{{ $producto->nombre }} - ${{ $producto->precio }}</li>
            @endforeach
        </ul>
</body>
</html>