<?php

    echo "Escribir un programa que use la variable \$operador que pueda almacenar<br>
        los símbolos matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras \$op1 y \$op2.<br>
        De acuerdo al símbolo que tenga la variable \$operador,<br>
        deberá realizarse la operación indicada y mostrarse el resultado por pantalla.<br><br>";

    $operador = $_GET['operador'];
    $op1 = $_GET['op1'];
    $op2 = $_GET['op2'];
    $resultado;

    echo "<br><br>$operador<br><br>";


    if ( ($operador != "+" && $operador != "-" && $operador != "*" && $operador != "/") ||
          $op1-(int)$op1 != 0 ||
          $op2-(int)$op2 != 0) {
        echo "Valores inválidos";
    } else {
        switch ($operador) {
            case "+" :
                $resultado = $op1 + $op2;
                break;
            case "-" :
                $resultado = $op1 - $op2;
                break;
            case "*" :
                $resultado = $op1 * $op2;
                break;
            case "/" :
                $resultado = $op1 / $op2;
                break;
        }
        echo "$op1 $operador $op2 = $resultado";
    }    
    
?>