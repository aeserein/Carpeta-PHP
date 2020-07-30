<?php

namespace App\Utils;

class Respuesta {

    static function crear($status, $descripcion, $obj) {
        $respuesta = array(
            "status" => $status,            // Un boolean para que el usuario chequee si andó con un if
            "descripcion" => $descripcion,  // Respuesta verbosa
            "objeto" => $obj                // Variable flexible para el objeto pedido
        );
        return $respuesta;
    }

    static function mostrar($respuesta) {
        try {
            echo "status: " . $respuesta["status"] . "<br>";
            echo "descripción: " . $respuesta["descripcion"] . "<br>";
            echo "objeto: ";
            var_dump($respuesta["objeto"]);
            echo "<br>";
        } catch (\Throwable $th) {
            echo "Que bonita mi respuesta. Se rompió mi respuesta.";
        }
    }

}

?>