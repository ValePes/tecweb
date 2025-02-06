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

    /*function numeroE_DoWhile($num) {
        if (!is_numeric($num) || $num == 0) {
            return "Por favor, proporciona un número válido.";
        }
        $num = intval($num);
        $numeroB = 0;
        do {
            $numeroB = rand(1, 100);
        } while ($numeroB % $num !== 0);
        return "El primer múltiplo encontrado aleatoriamente de $num es: $numeroB";
    }*/
?>

