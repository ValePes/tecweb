<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Practica 04</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
    //php
    $_myvar;
    $_7var;
    //myvar;        invalida
    $myvar;
    $var7;
    $_element1;
    //$house*5;     invalida 

    echo '<h3> Explicación:</h3>';
    echo '<ul>';
        echo '<li><em>$_myvar:</em> comienza con $ seguido de un guion bajo</i>';
        echo '<li><em>$_7var:</em> comienza con $ seguido de un guion bajo, lo cual es correcto </i>';
        echo '<li><em>myvar:</em>  todas las variables deben comenzar con $</i>';
        echo '<li><em>$myvar:</em> comienza con $ y sigue con un letra</i>';
        echo '<li><em>$var7:</em> comienza con $ y sigue con un letra</i>';
        echo '<li><em>$_element1:</em> comienza con $ seguido de un guion bajo, lo cual es correcto</i>';
        echo '<li><em>$house*5:</em> los nombres de variables solo pueden contener letras, números y guion bajo, pero no otros símbolos</i>';
    echo '</ul>';
    ?>

    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <ul>
        <li>$a = “ManejadorSQL”</li>
        <li>$b = 'MySQL’</li>
        <li>$c = &$a</li>
    </ul>
    <?php
        $a = "ManejadorSQL";
        $b = 'MySQL';  
        $c = &$a; 
        //Mostramos el contenido de cada variable
        echo '<p>Contendio de cada variable: </p>';
        echo '<ul>';
            echo "$a";
            echo '<br>';
            echo "$b";
            echo '<br>';
            echo "$c"; 
        echo '</ul>';

        echo '<p>Agrega al código actual las siguientes asignaciones: </p>';
        echo '<ul>';
            echo '<li>$a = “PHP server”</li>';
            echo '<li>$b = &$a</li>';
        echo '</ul>';
        //Agregamos las asignaciones
        $a = "PHP server";
        $b = &$a;
        //mostramos el contenido
        echo '<p> Vuelve a mostrar el contenido </p>';
        echo '<ul>';
            echo "$a";
            echo '<br>';
            echo "$b";
        echo '</ul>';

        echo '<p>Describe y muestra en la página obtenida qué ocurrió en el segundo bloque de asignaciones:</p>';
        echo '<ol>';
            echo '<li>Se declara la variable "$a= PHP server"</li>';
            echo '<li>Se declara la variable "$b= &$a", pero con una asignación por referencia (&$a) lo que significa que tambien alamcena "PHP server"</li>';
        echo '</ol>'
    ?>

    
</body>
</html>