<?php

    echo "Aplicación No 9 (Arrays asociativos)<br>
        Realizar las líneas de código necesarias para generar un Array asociativo \$lapicera,<br>
        que contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’.<br>
        Crear, cargar y mostrar tres lapiceras.<br><br>";

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

    foreach ($lapicera1 as $l) {
        echo key($lapicera1) . ": " . $l . "<br>";
        next($lapicera1);
    }
    echo "<br>";

    foreach ($lapicera2 as $l) {
        echo key($lapicera2) . ": " . $l . "<br>";
        next($lapicera2);
    }
    echo "<br>";

    foreach ($lapicera3 as $l) {
        echo key($lapicera3) . ": " . $l . "<br>";
        next($lapicera3);
    }
?>