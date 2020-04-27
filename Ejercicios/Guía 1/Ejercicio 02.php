<?php

    echo "Aplicación No 2 (Mostrar fecha y estación)<br>
        Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
        distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
        año es. Utilizar una estructura selectiva múltiple.<br><br>";

    //$fecha = date();

    echo "Fecha de hoy:<br>";
    echo date("l") . " " . date("d") . " de " . date("F") . " de " . date("Y") . "<br>";
    echo date('j') . "/" . date('n') . "/" . date('Y') . "<br>";
    echo date('d') . "/" . date('m') . "/" . date("y") . "<br><br>";

    echo "Hora<br>";
    echo date('h') . ":" . date('i') . ":" . date('s') . " " . date('a') . "<br>";
    echo "Timezone " . date('T') . date('O');
    echo "Hora formateada por date: " . date('r') . "<br><br>";

    echo "Estación: ";
    $mes = (int)date('n');
    $dia = (int)date('j');
    if ($dia<21) {
        switch ($mes) {
            case 1:
            case 2:
            case 3:
                echo "Verano";
                break;
            case 4:
            case 5:
            case 6:
                echo "Otoño";
                break;
            case 7:
            case 8:
            case 9:
                echo "Invierno";
                break;
            case 10:
            case 11:
            case 12:
                echo "Primavera";
                break;
        }
    } else {
        switch ($mes) {
            case 12:
            case 1:
            case 2:
                echo "Verano";
                break;
            case 3:
            case 4:
            case 5:
                echo "Otoño";
                break;
            case 6:
            case 7:
            case 8:
                echo "Invierno";
                break;
            case 9:
            case 10:
            case 11:
                echo "Primavera";
                break;
        }
    }

?>