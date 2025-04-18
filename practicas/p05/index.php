<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        require_once __DIR__ .'/src/funciones.php';
        if(isset($_GET['numero']))
        {
            Multiplo_de_5y7($_GET['numero']);
        }
    ?>

    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una secuencia compuesta por: impar, par, impar</p>
    <?php
        require_once __DIR__ .'/src/funciones.php';
         generarSecuencia();    
    ?>
    
    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente, pero que además sea múltiplo de un número dado.</p>
    <?php
        require_once __DIR__ .'/src/funciones.php';
        if (isset($_GET['numero'])) 
        {
            echo numeroE_While($_GET['numero']);
        }
    ?>
    <h3>Crear una variante de este script utilizando el ciclo do-while.</h3>
    <?php
        require_once __DIR__ .'/src/funciones.php';
        if (isset($_GET['numero'])) 
        {
            echo numeroE_DoWhile($_GET['numero']);
        }
    ?>

    <h2>Ejercicio 4</h2>
    <p>4. Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’ a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner el valor en cada índice.</p>
    <?php
        require_once __DIR__ .'/src/funciones.php';
        $arreglo=arreglo_Indice();
        tabla($arreglo);
    ?>

    <h2>Ejercicio 5</h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de bienvenida apropiado.En caso contrario, deberá devolverse otro mensaje indicando el error.</p>
        <h3>Ingrese sus datos</h3>
        <form action="http://localhost/tecweb/practicas/p05/index.php" method="POST">
        <label for="edad">Edad:</label>
        <input type="number" name="edad" required min="1"><br>

        <label for="sexo">Sexo:</label>
        <select name="sexo" required>
            <option value="">Seleccione...</option>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select><br>
        <br>
        <button type="submit">Enviar</button>
    </form>
    <?php
        require_once __DIR__ .'/src/funciones.php';
        // Verificar si se enviaron los datos por POST
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edad"]) && isset($_POST["sexo"])) {
            $edad = intval($_POST["edad"]);
            $sexo = strtolower($_POST["sexo"]);    
            echo "<br><strong>Edad ingresada:</strong> $edad";
            echo "<br><strong>Sexo ingresado:</strong> $sexo";
    
            $mensaje = validar_Edad_Sexo($edad, $sexo);
        } else {
            $mensaje = "No se han enviado datos. Por favor, complete el formulario.";
        }
    ?>
    <h3>Resultado de Validación</h3>
    <p class="mensaje"><?php echo $mensaje; ?></p>

    <h2>Ejercicio 6</h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de una ciudad.</p>
    <h3>Consultar Información de Vehículos</h3>
        <form action="http://localhost/tecweb/practicas/p05/index.php" method="POST">
            <label for="matricula">Ingrese Matrícula (o "todos" para ver todos los registros):</label>
            <input type="text" name="matricula" required>
            <button type="submit">Consultar</button>
        </form>
        <br>
        <h3>Resultados de la búsqueda:</h3>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $matricula = $_POST["matricula"] ?? "";
                if ($matricula == "todos") {
                    echo "<pre>";
                    print_r($parqueVehicular);
                    echo "</pre>";
                } elseif (isset($parqueVehicular[$matricula])) {
                    echo "<br><strong>Matricula: </strong> $matricula";
                    echo "<pre>";
                    print_r($parqueVehicular[$matricula]);
                    echo "</pre>";
                } else {
                    echo "<p>Matricula no encontrada.</p>";
                }
            }
        ?>


    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>

</body>
</html>