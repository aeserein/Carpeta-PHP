<?php

require_once "./resources/api_modeloDeParcial.php";

$modelo = new apiModeloDeParcial();

$respuesta = $modelo->ejecutar();

Respuesta::mostrar($respuesta);

?>