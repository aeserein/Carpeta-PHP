<?php

    echo "Aplicación No 10 (Arrays de Arrays)<br>
        Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado<br>
        que contengan como elementos tres Arrays del punto anterior cada uno.<br>
        Crear, cargar y mostrar los Arrays de Arrays.<br><br>";

    $lapicera1 = array(
        "Color" => "CELESTE Y BLANCO",
        "Marca" => "Menem",
        "Trazo" => "Dolarizado",
        "Precio" => "Un peso un dolar"
    );

    $lapicera2 = array(
        "Color" => "Verde",
        "Marca" => "Ford",
        "Trazo" => "Derecho y humano",
        "Precio" => "$6348"
    );

    $lapicera3 = array(
        "Color" => "Rojo comunista",
        "Marca" => "Матушка Россия",
        "Trazo" => "No tiene tinta",
        "Precio" => "Fuera de stock"
    );

    $arrayIndexadoDeLapiceras = array(
        $lapicera1, $lapicera2, $lapicera3
    );

    $arrayAsociativoDeLapiceras = array(
        "Lapicera 1" => $lapicera1,
        "Lapicera 2" => $lapicera2,
        "Lapicera 3" => $lapicera3
    );

    echo "Imprimo array indexado<br>";
    foreach ($arrayIndexadoDeLapiceras as $a) {
        imprimirLapicera($a);
    }

    echo "Imprimo array asociativo<br>";
    foreach ($arrayAsociativoDeLapiceras as $a) {
        echo key($arrayAsociativoDeLapiceras) . ":<br>";
        imprimirLapicera($a);
        next($arrayAsociativoDeLapiceras);
    }

    /////////////////////////////////////////////////////////////////////////////////////////

    function imprimirLapicera($lapicera) {
        foreach ($lapicera as $l) {
            echo key($lapicera) . ": " . $l . "<br>";
            next($lapicera);
        }
        echo "<br>";
    }
?>