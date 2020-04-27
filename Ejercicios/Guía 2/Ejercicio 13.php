<?php

    echo "Aplicación No 13 (Invertir palabra)<br>
        Crear una función que reciba como parámetro un string (\$palabra) y un entero (\$max).<br>
        La función validará que la cantidad de caracteres que tiene \$palabra no supere a \$max y además<br>
        deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:<br>
        “Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:<br>
        1 si la palabra pertenece a algún elemento del listado. 0 en caso contrario.<br><br>";

    $palabra = $_GET["palabra"];
    $max = $_GET["max"];;
    $pertenece = 0;

    echo "Palabra: $palabra - Max: $max<br><br>";

    $pertenece = verSiSupera($palabra, $max);
    if ($pertenece == 1)
        echo "Pertenece a las palabras válidas";
    else
        echo "No pertenece a las palabras válidas";

    /////////////////////////////////////////////////////////////////////////////////////////

    function verSiSupera($palabra, $max) {
        if (strlen($palabra) <=  $max)
            echo "La palabra no supera el número máximo de letras<br>";
        else
            echo "La palabra supera el número máximo de letras<br>";

        if (strcasecmp($palabra, "Recuperatorio") == 0 ||
            strcasecmp($palabra, "Parcial") == 0 ||
            strcasecmp($palabra, "Programación") == 0)
            return 1;
        else
            return 0;
    }

?>