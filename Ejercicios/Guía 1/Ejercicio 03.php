<?php

    echo "Aplicación No 3 (Obtener el valor del medio)<br>
        Dadas tres variables numéricas de tipo entero \$a, \$b y \$c realizar una aplicación que muestre<br>
        el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres variables.<br>
        De no existir dicho valor, mostrar un mensaje que indique lo sucedido.<br>
        Ejemplo 1: \$a = 6; \$b = 9; \$c = 8; => se muestra 8.<br>
        Ejemplo 2: \$a = 5; \$b = 1; \$c = 5; => se muestra un mensaje “No hay valor del medio”<br><br>";

    $a=$_GET['a'];
    $b=$_GET['b'];
    $c=$_GET['c'];
    $medio;

    if ($a==$b || $b==$c || $c==$a) {
        $medio = null;
    } elseif ($a>$b) {
        if ($c>$a)
            $medio = $a;
        elseif ($c>$b)
            $medio = $c;
        else
            $medio = $b;
    } else {
        if ($c>$b)
            $medio = $b;
        elseif ($c>$a)
            $medio = $c;
        else
            $medio = $a;
    }

    if ($medio==null)
        echo "No hay valor del medio";
    else
        echo "Valor del medio: $medio";
    
?>