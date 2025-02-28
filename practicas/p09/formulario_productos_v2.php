<?php
// Conectar a la base de datos
@$link = new mysqli('localhost', 'root', 'Lepuchis22', 'marketzone');

// Verificar conexión
if ($link->connect_errno) {
    die('Error de conexión: ' . $link->connect_error);
}

// Obtener datos del producto a editar
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$producto = [];
if ($id > 0) {
    $result = $link->query("SELECT * FROM productos WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    }
    $result->free();
}
$link->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        label, input, textarea, select {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Editar Producto</h2>
    <form action="update_producto.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $producto['id'] ?? '' ?>">
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="form-nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>" required>
        
        <label for="marca">Marca:</label>
        <select name="marca" id="form-marca" required>
            <option value="">Seleccionar</option>
            <?php $marcas = ["Samsung", "Apple", "Alba", "Espasa", "Lenovo", "Dell", "Omega", "Fossil", "Oster"];
            foreach ($marcas as $marca) {
                $selected = ($producto['marca'] ?? '') === $marca ? 'selected' : '';
                echo "<option value='$marca' $selected>$marca</option>";
            }
            ?>
        </select>
        
        <label for="modelo">Modelo:</label>
        <input type="text" id="form-modelo" name="modelo" value="<?= htmlspecialchars($producto['modelo'] ?? '') ?>" required>
        
        <label for="precio">Precio:</label>
        <input type="number" id="form-precio" name="precio" value="<?= $producto['precio'] ?? '' ?>" step="0.01" required>
        
        <label for="detalles">Detalles:</label>
        <textarea id="form-detalles" name="detalles" rows="5"><?= htmlspecialchars($producto['detalles'] ?? '') ?></textarea>
        
        <label for="unidades">Unidades:</label>
        <input type="number" id="form-unidades" name="unidades" value="<?= $producto['unidades'] ?? '' ?>" required>
        
        <label for="imagen">Imagen del Producto:</label>
        <input type="file" id="form-imagen" name="imagen">
        <input type="hidden" name="imagen_actual" value="<?= $producto['imagen'] ?? '' ?>"><input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($producto['imagen']) ?>">
        <img src="<?= $producto['imagen'] ?? 'img/imagen.png' ?>" width="100" height="100" alt="Imagen del producto">
        
        <button type="submit">Actualizar producto</button>
        <button type="reset">Restablecer</button>
    </form>
    <br>
    <a href="get_productos_xhtml_v2.php">Ver los productos por tope</a> |
    <a href="get_productos_vigentes_v2.php">Ver productos vigentes</a>

    <!-- Script de Validación -->
  <script src="./validacion_formulario.js"></script>
</body>
</html>

