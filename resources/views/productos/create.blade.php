<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
</head>
<body>
    <h1>Crear Nuevo Producto</h1>
    <form action="/productos" method="POST">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto">
        <br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required placeholder="Precio del producto">
        <br>
        <button type="submit">Guardar Producto</button>
    </form>
        
</body>
</html>