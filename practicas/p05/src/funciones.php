<?php
    function Multiplo_de_5y7($num){
        $num = $_GET['numero'];
            if ($num%5==0 && $num%7==0)
            {
                echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
            }
            else
            {
                echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
            }
    }

    function generarSecuencia(){
        $matriz = [];
        $iteraciones = 0;
        $totalNumeros = 0;

        do {
            $iteraciones++;
            $fila = [rand(1, 999), rand(1, 999), rand(1, 999)];
            $totalNumeros += 3;
            $matriz[] = $fila;
        } while (!($fila[0] % 2 != 0 && $fila[1] % 2 == 0 && $fila[2] % 2 != 0));
        
        // Mostrar la matriz
        foreach ($matriz as $fila) {
            echo implode(", ", $fila) . "<br>"; //Une los elementos de una matriz en una cadena
        }
        echo '<br>';
        echo "\n$totalNumeros números obtenidos en $iteraciones iteraciones\n";
    }

    function numeroE_While($num) {
        if(!is_numeric($num) || $num == 0) {
            return "Por favor, proporciona un número válido.";
        }
        $num = intval($num);
        $numeroA = 0;
        while (true) {
            $numeroA = rand(1, 100);
            if ($numeroA % $num == 0) {
                break;
            }
        }
        return "El primer múltiplo encontrado aleatoriamente de $num es: $numeroA";
    }

    function numeroE_DoWhile($num) {
        if (!is_numeric($num) || $num == 0) {
            return "Por favor, proporciona un número válido.";
        }
        $num = intval($num);
        $numeroB = 0;
        do {
            $numeroB = rand(1, 100);
        } while ($numeroB % $num !== 0);
        return "El primer múltiplo encontrado aleatoriamente de $num es: $numeroB";
    }

    function arreglo_Indice(){
        $arreglo = array();
        for ($i = 97; $i <= 122; $i++) {
            $arreglo[$i] = chr($i); // Convertir código ASCII en letra
        }
        return $arreglo;
    }

    function tabla($arreglo){
        echo "<table>";
        echo "<tr><th>Indice(ASCII)</th> <th>Letra</th></tr>";
        foreach ($arreglo as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
    }

    function validar_Edad_Sexo($edad, $sexo) {
        if ($sexo === "femenino" && $edad >= 18 && $edad <= 35) {
            return "Bienvenido, usted está en el rango de edad permitido.";
        } else {
            return "Lo sentimos, no cumple con los requisitos necesarios.";
        }
    }
    


?>

