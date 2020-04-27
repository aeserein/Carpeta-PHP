<?php

include_once './Persona.php';

$personas = array();

$personas[0] = new Persona("Juan");
$personas[1] = new Persona("Cacho");
$personas[2] = new Persona("Castaña");
$personas[3] = new Persona("Donaldo");

$serializado = serialize($personas);

/*
$file = fopen("./files/personas.txt", "w");
$rta = fwrite($file, $serializado);
fclose($file);
echo $rta;
*/


$file = fopen("./files/personas.txt", "r");
$rta = fread($file, filesize("./files/personas.txt"));
fclose($file);

$listadoPersonas = unserialize($rta);
foreach($listadoPersonas as $p) {
    echo $p->saludar() . "<br>";
}

/*
    Solo serializa cosas públicas



*/

?>