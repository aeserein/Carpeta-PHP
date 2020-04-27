<?php

    echo "Aplicación No 1 (Sumar números)<br>
        Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no supere a 1000.<br>
        Mostrar los números sumados y al finalizar el proceso indicar cuantos números se sumaron.<br><br>";

    $contador = 1;
    $resultado = 0;

    while ($resultado + $contador<=1000) {
        $resultado += $contador;
        echo "$resultado ";
        $contador++;
    }

    echo "<br><br>Se sumó ". --$contador . " veces";

?>