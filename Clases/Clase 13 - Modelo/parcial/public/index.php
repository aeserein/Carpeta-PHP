<?php

(require_once __DIR__ . "/../config/bootstrap.php")->run();
// Esto va entre paréntesis porque lo que está en config no está en una clase
// Lo que está entre paréntesis es igual a la instancia de $app







//use App\Models\Alumno;
// Se pone este use de namespace y no se incluye la línea de abajo
// require_once __DIR__ . "/../src/models/alumno.php";
// ***** Editar el composer.json
    /*
        "autoload" : {
            "classmap" : [
                "src/Models"
            ]
        }
    */
// ***** Correr "composer dump-autoload"

// Sino...
    /*
        "autoload" : {
            "psr-4" : {
                "App\\": "src"
            }
        }
    */
// ***** Correr "composer dumpautoload -o" (sin punto, con -o)

//$alumno1 = new Alumno();

// Controlador -> Modelo (Se comunica con la BD) -> Vuelve al controlador