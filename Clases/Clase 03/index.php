<?php

/*
// POST
switch ($path_info) {
    case "/personas" :
        $file = fopen("datos.txt", "a+");
        $bytes = fwrite($file, $_POST["var1"] . ", " . $_POST["var2"] . PHP_EOL);
        fclose($file);
        return $bytes; // a index
}

// GET
switch ($path_info) {
    case "/personas" :
        $file = fopen("datos.txt", "a+");
        $data = fread($file, filesize("datos.txt"));
        fclose($file);
        return $data;
}
*/

/*  Subir archivos
    Los archivos se mandan por formulario html
    Por POST
    Postman -> body -> form-data - cambiar el campo a archivo
*/

// $_GET $_POST $_REQUEST $_SERVER

// Se lee por el array $_FILES
echo json_encode($_FILES);
echo "<br><br>--------------------------------------------------------<br><br>";
var_dump($_FILES);
echo "<br><br>--------------------------------------------------------<br><br>";
var_dump($_FILES['archivoMenem']);

// tmp_name es la ubicación temporal donde Apache guarda las cosas subidas
// name es el nombre del archivo
$origen = $_FILES['archivoMenem']["tmp_name"];

// Guardo con el nombre original
$destino = './files/' . $_FILES['archivoMenem']["name"];
// El nombre se pone según el diseño y se concatena la extensión

// Agarrar un archivo y copiarlo en otra carpeta
move_uploaded_file($origen, $destino);

// Borro pero primero guardo en un backup
$file = './files/' . $_FILES['archivoMenem']["name"];
$destinoCopy = './backup/' . $_FILES['archivoMenem']["name"];
copy($file, $destinoCopy);
unlink($file);

?>