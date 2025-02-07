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
            return "Bienvenida, usted está en el rango de edad permitido.";
        } else {
            return "Lo sentimos, no cumple con los requisitos necesarios.";
        }
    }

    $parqueVehicular = [
        "ABC1234" => [
            "Auto" => [
                "marca" => "HONDA",
                "modelo" => 2020,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Alfonzo Esparza",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            ]
        ],
        "XYZ5678" => [
            "Auto" => [
                "marca" => "MAZDA",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Ma. del Consuelo Molina",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "97 oriente"
            ]
        ],
        "LMN4321" => [
        "Auto" => [
            "marca" => "TOYOTA",
            "modelo" => 2021,
            "tipo" => "hatchback"
        ],
        "Propietario" => [
            "nombre" => "Carlos Ramírez",
            "ciudad" => "Guadalajara, Jal.",
            "direccion" => "Av. Vallarta 123"
        ]
        ],
        "DEF9876" => [
            "Auto" => [
                "marca" => "NISSAN",
                "modelo" => 2018,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Ana López",
                "ciudad" => "Monterrey, NL.",
                "direccion" => "Calle Reforma 456"
            ]
        ],
        "GHI2468" => [
            "Auto" => [
                "marca" => "FORD",
                "modelo" => 2022,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Javier Gómez",
                "ciudad" => "Querétaro, Qro.",
                "direccion" => "Blvd. Bernardo Quintana 789"
            ]
        ],
        "JKL1357" => [
            "Auto" => [
                "marca" => "CHEVROLET",
                "modelo" => 2020,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Luis Torres",
                "ciudad" => "León, Gto.",
                "direccion" => "Calle Hidalgo 321"
            ]
        ],
        "MNO8642" => [
            "Auto" => [
                "marca" => "BMW",
                "modelo" => 2023,
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Mariana Sánchez",
                "ciudad" => "CDMX",
                "direccion" => "Colonia Roma Norte"
            ]
        ],
        "PQR5793" => [
            "Auto" => [
                "marca" => "MERCEDES",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Fernando Aguilar",
                "ciudad" => "Mérida, Yuc.",
                "direccion" => "Av. Montejo 567"
            ]
        ],
        "STU8024" => [
            "Auto" => [
                "marca" => "AUDI",
                "modelo" => 2021,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Andrea Navarro",
                "ciudad" => "Tijuana, BC.",
                "direccion" => "Zona Río 890"
            ]
        ],
        "VWX3142" => [
            "Auto" => [
                "marca" => "KIA",
                "modelo" => 2020,
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Ricardo Pérez",
                "ciudad" => "San Luis Potosí, SLP.",
                "direccion" => "Centro Histórico"
            ]
        ],
        "YZA2716" => [
            "Auto" => [
                "marca" => "VOLKSWAGEN",
                "modelo" => 2018,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Gabriela Ruiz",
                "ciudad" => "Toluca, Edo. Méx.",
                "direccion" => "Colonia Centro"
            ]
        ]
    ];
    
?>

