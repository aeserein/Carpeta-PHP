<?php

    echo "Aplicación No 8 (Carga aleatoria)<br>
        Imprima los valores del vector asociativo siguiente usando la estructura de control foreach:<br>
        \$v[1]=90; \$v[30]=7; \$v['e']=99; \$v['hola']= 'mundo';<br><br>";
    
    $v = array(
        1 => 90,
        30 => 7,
        'e' => 99,
        "hola" => "mundo"
    );

    foreach ($v as $f) {
        echo "Índice " . key($v) . " - " . $f . "<br>";
        next($v);
    }
?>