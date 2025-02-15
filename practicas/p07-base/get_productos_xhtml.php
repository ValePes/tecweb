<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>LISTA DE PRODUCTOS</h3>
    <br/>

    <?php
    $data = array();

	if(isset($_GET['tope']))
    {
		$tope = intval($_GET['tope']); /** Se usa intval para asegurarse de que solo se pase un número entero. */
    }
    else
    {
        die('Parámetro "tope" no detectado...');
    }

	if (!empty($tope))
	{
		/** SE CREA EL OBJETO DE CONEXION */
		@$link = new mysqli('localhost', 'root', 'Lepuchis22', 'marketzone');
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

		/** comprobar la conexión */
		if ($link->connect_errno) 
		{
			die('Falló la conexión: '.$link->connect_error.'<br/>');
			//exit();
		}

		/** Crear una tabla que no devuelve un conjunto de resultados */
		if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= $tope") ) 
		{
            /** Se extraen las tuplas obtenidas de la consulta */
			$row = $result->fetch_all(MYSQLI_ASSOC);

            /** Se crea un arreglo con la estructura deseada */
            foreach($row as $num => $registro) {            // Se recorren tuplas
                foreach($registro as $key => $value) {      // Se recorren campos
                    $data[$num][$key] = utf8_encode($value);
                }
            }

			/** útil para liberar memoria asociada a un resultado con demasiada información */
			$result->free();
		}
        else
        {
            alert('Ingresa un número entero');
        }

		$link->close();
	}
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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $producto) : ?>
            <tr>
                <td><?= $producto['id'] ?></td>
                <td><?= ($producto['nombre']) ?></td>
                <td><?= ($producto['marca']) ?></td>
                <td><?= ($producto['modelo']) ?></td>
                <td>$<?= ($producto['precio']) ?></td>
                <td><?= $producto['unidades'] ?></td>
                <td><?= ($producto['detalles']) ?></td>
                <td><img src="<?= ($producto['imagen']) ?>" width="100" height="100"></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else : ?>
        <script>alert('No hay productos con ese tope, por favor ingresa otro');</script>
    <?php endif; ?>

</body>
</html>
