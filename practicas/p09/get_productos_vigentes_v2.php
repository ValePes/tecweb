<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>LISTA DE PRODUCTOS VIGENTES</h3>
    <br/>

<?php
$data = array();

@$link = new mysqli('localhost', 'root', 'Lepuchis22', 'marketzone');
if ($link->connect_errno) {
    die('Falló la conexión: '.$link->connect_error.'<br/>');
}

if ($result = $link->query("SELECT * FROM productos WHERE eliminado = 0")) {
    $row = $result->fetch_all(MYSQLI_ASSOC);
    foreach($row as $num => $registro) {
        foreach($registro as $key => $value) {
            $data[$num][$key] = utf8_encode($value);
        }
    }
    $result->free();
}
$link->close();
?>

<?php if (!empty($data)) : ?>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Precio</th>
            <th scope="col">Unidades</th>
            <th scope="col">Detalles</th>
            <th scope="col">Imagen</th>
            <th scope="col">Editar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $producto) : ?>
        <tr>
            <td><?= $producto['id'] ?></td>
            <td><?= $producto['nombre'] ?></td>
            <td><?= $producto['marca'] ?></td>
            <td><?= $producto['modelo'] ?></td>
            <td>$<?= $producto['precio'] ?></td>
            <td><?= $producto['unidades'] ?></td>
            <td><?= $producto['detalles'] ?></td>
            <td><img src="<?= $producto['imagen'] ?>" width="100" height="100"></td>
            <td>
            <a href="formulario_productos_v2.php?id=<?= $producto['id'] ?>&nombre=<?= urlencode($producto['nombre']) ?>&marca=<?= urlencode($producto['marca']) ?>&modelo=<?= urlencode($producto['modelo']) ?>&precio=<?= $producto['precio'] ?>&unidades=<?= $producto['unidades'] ?>&detalles=<?= urlencode($producto['detalles']) ?>&imagen=<?= urlencode($producto['imagen']) ?>">Editar</a>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <?php else : ?>
        <script>alert('Error no se encontraron productos eliminados');</script>
    <?php endif; ?>

</body>
</html>