<?php

    echo "Realizar un programa que en base al valor numérico de una variable \$num,<br>
        pueda mostrarse por pantalla el nombre del número que tenga dentro escrito con palabras,<br>
        para los números entre el 20 y el 60.<br>
        Por ejemplo, si \$num = 43 debe mostrarse por pantalla “cuarenta y tres”.<br><br>";

    $num = $_GET["num"];
    $numeroConvertido = "";

    strval($num);

    echo "NUMERO " . $num[0] . " " . $num[1] . "<br><br>";

    switch ($num[0]) {
        case "2" :
            $numeroConvertido .= "Veint";
            echo "NUMERO CONVERTIDO " . $numeroConvertido . "<br>";
            $numeroConvertido = veintialgo($num[1], $numeroConvertido);
            echo "NUMERO CONVERTIDO " . $numeroConvertido . "<br><br>";
            break;
        case "3" :
            $numeroConvertido .= "Treinta";
            $numeroConvertido = treintaCuarenta($num[1], $numeroConvertido);
            break;
        case "4" :
            $numeroConvertido .= "Cuarenta";
            $numeroConvertido = treintaCuarenta($num[1], $numeroConvertido);
            break;
        default :
            $numeroConvertido = "Número fuera de rango";
    }

    echo "$num - $numeroConvertido";

    function veintialgo($num, $numeroConvertido) {
        switch ($num) {
            case "0" :
                $numeroConvertido .= "e";
                break;
            case "1" :
                $numeroConvertido .= "iuno";
                break;
            case "2" :
                $numeroConvertido .= "idos";
                break;
            case "3" :
                $numeroConvertido .= "itres";
                break;
            case "4" :
                $numeroConvertido .= "icuatro";
                break;
            case "5" :
                $numeroConvertido .= "icinco";
                break;
            case "6" :
                $numeroConvertido .= "iseis";
                break;
            case "7" :
                $numeroConvertido .= "isiete";
                break;
            case "8" :
                $numeroConvertido .= "iocho";
                break;
            case "9" :
                $numeroConvertido .= "inueve";
                break;
        }
        return $numeroConvertido;
    }

    function treintaCuarenta($num, $numeroConvertido) {
        switch ($num) {
            case "0" :
                $numeroConvertido .= "";
                break;
            case "1" :
                $numeroConvertido .= " y uno";
                break;
            case "2" :
                $numeroConvertido .= " y dos";
                break;
            case "3" :
                $numeroConvertido .= " y tres";
                break;
            case "4" :
                $numeroConvertido .= " y cuatro";
                break;
            case "5" :
                $numeroConvertido .= " y cinco";
                break;
            case "6" :
                $numeroConvertido .= " y seis";
                break;
            case "7" :
                $numeroConvertido .= " y siete";
                break;
            case "8" :
                $numeroConvertido .= " y ocho";
                break;
            case "9" :
                $numeroConvertido .= " y nueve";
                break;
        }
        return $numeroConvertido;
    }
?>