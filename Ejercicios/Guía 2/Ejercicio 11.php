<?php

    echo "Aplicación No 11 (Potencias de números)<br>
        Mostrar por pantalla las primeras 4 potencias de los números del uno 1 al 4<br>
        (hacer una función que las calcule invocando la función pow).<br><br>";

    for ($f=1; $f<=4; $f++) {
        
        echo "Número $f:<br>";

        for ($i=1; $i<=4; $i++) {

            echo "$f^$i = " . calcularPotencia($f, $i) . "<br>";
        }
        echo "<br>";
    }

    /////////////////////////////////////////////////////////////////////////////////////////

    function calcularPotencia($base, $exponente) {
        return pow($base, $exponente);
    }
?>