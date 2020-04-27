<?php

    echo "Aplicación No 6 (Carga aleatoria)<br>
        Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número<br>
        (utilizar la función rand). Mediante una estructura condicional,<br>
        determinar si el promedio de los números son mayores, menores o iguales que 6.<br>
        Mostrar un mensaje por pantalla informando el resultado.<br><br>";
    
    $array = array(
        0 => rand(0, 12),
        1 => rand(0, 12),
        2 => rand(0, 12),
        3 => rand(0, 12),
        4 => rand(0, 12)
    );
    $promedio = 0; $acumulador = 0;

    foreach ($array as $f) {
        $acumulador += $f;
    }

    $promedio = $acumulador / count($array);

    echo "Números: ";
    foreach ($array as $f) {
        echo "$f ";
    }
    echo "<br>Promedio: $promedio<br>";

    if ($promedio > 6) {
        echo "Promedio mayor a 6";
    } elseif ($promedio == 6) {
        echo "Promedio 6";
    } else {
        echo "Promedio menor a 6";
    }
?>