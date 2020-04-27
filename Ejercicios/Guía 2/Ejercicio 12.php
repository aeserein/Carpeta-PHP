<?php

    echo "Aplicación No 12 (Invertir palabra)<br>
        Realizar el desarrollo de una función que reciba un Array de caracteres<br>
        y que invierta el orden de las letras del Array.<br>
        Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.<br><br>";

    $string = $_GET["string"];
    
    echo $string . " - ";

    $string = darVuelta($string);
    echo $string;

    /////////////////////////////////////////////////////////////////////////////////////////

    function darVuelta($string) {
        $len = strlen($string);
        $stringDadoVuelta = "";
        for ($f=$len; $f>0; $f--) {
            $stringDadoVuelta .= $string[$f-1];
        }
        return $stringDadoVuelta;
    }
?>