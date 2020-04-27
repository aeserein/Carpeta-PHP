<?php

session_start();

// var_dump($_SESSION);

/*
Variables de Sesión

Duran hasta que se cierra el explorador
Variable global $_SESSION
Lo de la cookie se guarda del lado del cliente
Lo de la sesión se guarda del lado del server
La cookie se puede cambiar desde el cliente por lo que solo se usa de forma superficial
*/

if (isSet($_SESSION["nombre"])) {
    echo "Hola " . $_SESSION["nombre"];
} else {
    $_SESSION["nombre"] = $_GET["nombre"];
    setcookie("usuario", $_SESSION["nombre"], time() + 3600);
}

/*
La primera vez que se entra "nombre" no está seteado
A la segunda consulta ya está seteado
*/

var_dump($_COOKIE);
echo "<br><br>LEO POR COOKIE<br>Nombre = " . $_COOKIE["usuario"];

/* Variable global _COOKIE con los campos seteados con setcookie

session_unset();
session_destroy();

/*
unset pone en null
destroy libera la variable
*/

?>