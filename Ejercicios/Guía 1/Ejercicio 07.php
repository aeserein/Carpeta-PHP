<?php

    echo "Aplicación No 7 (Mostrar impares)<br>
        Generar una aplicación que permita cargar los primeros 10 números impares en un Array.<br>
        Luego imprimir (utilizando la estructura for) cada uno en una línea distinta<br>
        (recordar que el salto de línea en HTML es la etiqueta \<br>).<br>
        Repetir la impresión de los números utilizando las estructuras while y foreach<br><br>";
    
    $array = array();
    $c = 1;
    $index = 0;

    while (count($array)<10) {
        if ($c % 2 == 1) {
            array_push($array, $c);
            $index++;
        }
        $c++;
    }

    echo "Imprimo con for:<br>";
    for ($f = 0; $f<count($array); $f++) {
        echo "$array[$f]<br>";
    }

    echo "Imprimo con while:<br>";
    $c = 0;
    while ($c < count($array)) {
        echo "$array[$c]<br>";
        $c++;
    }

    echo "Imprimo con foreach:<br>";
    foreach ($array as $f) {
        echo "$f<br>";
    }
?>