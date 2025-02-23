<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Registro Completado</title>
		<style type="text/css">
			body {margin: 20px; 
			background-color:rgb(155, 220, 223);
			font-family: Verdana, Helvetica, sans-serif;
			font-size: 90%;}
			h1 {color:rgb(0, 72, 88);
			border-bottom: 1px solid rgb(0, 54, 88);}
			h2 {font-size: 1.2em;
			color: #4A0048;}
		</style>
        <script>
			function mostrarError(mensaje) {
				alert(mensaje);
			}
		</script>
	</head>
	<body>

  
<?php
        $nombre = $_POST['nombre'];
        $marca  = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $detalles = $_POST['detalles'];
        $unidades = $_POST['unidades'];
        $imagen = "img/default.png"; // Imagen por defecto

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = "img/" . basename($_FILES['imagen']['name']);
                move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);
            }

        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', 'Lepuchis22', 'marketzone');

        /** comprobar la conexión */
        if ($link->connect_errno) {
            die('<p>Falló la conexión: ' . $link->connect_error . '</p>');
        }

        /** Verificar si el producto ya existe */
        $sql_check = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND marca = '{$marca}' AND modelo = '{$modelo}'";
        $result = $link->query($sql_check);
        
        if ($result->num_rows > 0) {
            echo '<p>El producto ya esta registrado en la base de datos, por favor verifique los datos.</p>';
        }
        else
        {
            //consulta que no usa los column names.
            //$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";

            //consulta que usa los column names.
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";
        }

        /** Crear una tabla que devuelve un conjunto de resultados */
        
        if ( isset($sql) && $link->query($sql)) 
        { 
            echo "<h2>Producto registrado con éxito</h2>" .$link->insert_id;
            echo "<p>Nombre: $nombre</p>";
            echo "<p>Marca: $marca</p>";
            echo "<p>Modelo: $modelo</p>";
            echo "<p>Precio: $$precio</p>";
            echo "<p>Detalles: $detalles</p>";
            echo "<p>Unidades: $unidades</p>";
            echo "<p><img src='$imagen' width='200'></p>";
        }
        else
        {
            echo "<script>mostrarError('Error al registrar el producto. Por favor, inténtelo de nuevo.');</script>";
}
    
?>
</body>
</html>
