<?php

    echo "Aplicación No 14 (Par e impar)<br>
        Crear una función llamada esPar que reciba un valor entero como parámetro<br>
        y devuelva TRUE si este número es par ó FALSE si es impar.<br>
        Reutilizando el código anterior, crear la función esImpar.<br><br>";

    $numero = $_GET["numero"];

    echo "Número $numero - ";
    if (espar($numero))
        echo "Es par<br>";
    else
        echo "Es impar<br>";

    if (esImpar($numero))
        echo "Es impar";
    else
        echo "Es par";

    /////////////////////////////////////////////////////////////////////////////////////////

    function esPar($n) {
        return ($n%2==0);
    }

    function esImpar($n) {
        return !esPar($n);
    }

?>