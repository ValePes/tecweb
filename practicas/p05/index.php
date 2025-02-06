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