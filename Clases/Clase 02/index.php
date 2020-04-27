<?php

    /*
    METODOS HTTP
    GET: Obtener recursos
    POST: Crear recursos
    PUT: Modificar recursos
    DELETE: Borrar recursos
    HEAD: Como get, devuelve solo el header
    CONNECT: Crear conexión persistente
    TRACE: Hace un loop-back del mensaje enviado

    GET: Entidad -> trae todo
    GET: Entidad?id=1 -> trae datos del elemento
    POST: entidad -> Guardo datos que vienen por post

    */

    echo "Clase 2<br><br>";

    /*  Pasar parámetros por get
        Variables superglobales
        Variable _GET

    
    var_dump($_GET);
    $nombreGet = $_GET["nombre"];
    $edadGet = $_GET["edad"];
    */
    

    //echo "Nombre: $nombreGet<br> Edad: $edadGet<br><br>";

    /*  Convierto a json
        Paso de array a objeto
        Crea un stdClass

    
    echo "Objeto _GET<br>" . json_encode($_GET) . "<br><br>";
    */

    /*  POST
        Los datos se envían en el body de la consulta
        En postman se pasa por body->form-data


    echo "Objeto _POST<br" . json_encode($_POST) . "<br><br>";
     */
    

    /*  REQUEST
        Por POST lo lee, por GET no
        Alternativa a isset() -----> $id = $_GET ?? 0;
                    El ?? chequea si el valor existe y no es null
                    Si existe y no es null se obtiene el valor de la izquierda ($_GET)
                    Si no existe se obtiene el valor de la derecha (0)

    
    $id;
    if (isset($_GET["id"])) {
        echo "Método GET " . $_GET["id"] . "<br>";
    } else {
        echo "POST<br>";
    }
    echo "Objeto _REQUEST<br>" . json_encode($_REQUEST) . "<br><br>";
    */

    /*  SERVER
        Veo qué tipo de consulta me enviaron y devuelvo algo
        URI vs URL

        URL es hasta la extensión
        URN es desde el dominio hasta el final

        URL U URN = URI



    //echo json_encode($_SERVER);
    $request_method = $_SERVER["REQUEST_METHOD"];
    $path_info = $_SERVER["PATH_INFO"];
    $datos;
    
    // Ejemplo de consulta http://localhost/Prueba/index.php/mascotas
    switch ($path_info) {
        case "/mascotas" :
            if ($request_method == "POST") {
                // Guardo datos
            } else if ($request_method == "GET") {
                // Devuelvo datos
                $datos = array("Gato", "Perra fea", "Perra psiquiátrica");
            } else {
                echo "405 method not allowed";
            }
            break;
        case "/personas" : 
            if ($request_method == "POST") {
                // Guardo datos
            } else if ($request_method == "GET") {
                // Devuelvo datos
                $datos = array("Carlos Saúl Menem", "Dios Emperador Donald Trump");
            } else {
                echo "405 method not allowed";
            }
            break;
        case "/autos" : 
            if ($request_method == "POST") {
                // Guardo datos
            } else if ($request_method == "GET") {
                // Devuelvo datos
                $datos = array("Ford", "Fiat", "Chevrolet");
            } else {
                echo "405 method not allowed";
            }
            break;
    }

    $respuesta = new stdClass();
    $respuesta->success = true;
    $respuesta->data = $datos;
    echo json_encode($respuesta);
    */


    /////////////////////////////////////////////

    /*  Archivos

    fopen()
    fclose()

    fread() y fgets()
    fwrite() y fputs()

    fcopy()

    fopen()
    r -> abre solo lectura
    w -> abre solo escritura. si no existe lo crea. si existe lo sobreescribe
    a -> abre solo escritura. si no existe lo crea de nuevo. si existe escribe al final
    x -> crea un archivo solo lectura. devuelve false si ya existe
    r+ -> ??????????????

    fclose()

    fread()
    devuelve un string con todo el contenido
    arg1 -> archivo
    arg2 -> tamaño a leer

    fgets()
    devuelve un string con una sola linea
    arg1 -> archivo a ser leido
    mueve el cursor a la línea siguiente

    fwrite()
    arg1 -> archivo
    arg2 -> string a escribir
    devuelve cantidad de bytes escritos

    copy()
    arg1 -> from
    arg2 -> to




    $archivo = fopen("archivo.txt", "a+");

    // Leo entero
    //echo fread($archivo, filesize("archivo.txt"));

    // Leo línea por línea
    while (!feof($archivo)) {
        echo fgets($archivo) . "<br>";
    }

    $byes = fwrite($archivo, "\nLínea escrita");

    copy("archivo.txt", "archivo2.txt");
    unlink("archivo2.txt");

    $cerrar = fclose($archivo);
    */

    $request_method = $_SERVER["REQUEST_METHOD"];
    $path_info = $_SERVER["PATH_INFO"];
    $datos = "";
    
    // Ejemplo de consulta http://localhost/Prueba/index.php/mascotas
    switch ($path_info) {
        case "/mascotas" :
            if ($request_method == "POST") {
                // Guardo datos
                $archivoMascotas = fopen("archivoMascotas.txt", "a+");

                $linea = $_POST["apellido"] . ", " . $_POST["nombre"] . PHP_EOL;
                $bytes = fwrite($archivoMascotas, $linea);

                fclose($archivoMascotas);
            } else if ($request_method == "GET") {
                // Devuelvo datos
                $archivoMascotas = fopen("archivoMascotas.txt", "a+");

                $datos = fread($archivoMascotas, filesize("archivoMascotas.txt"));

                fclose($archivoMascotas);
            } else {
                echo "405 method not allowed";
            }
            break;
        case "/personas" : 
            if ($request_method == "POST") {
                // Guardo datos
            } else if ($request_method == "GET") {
                // Devuelvo datos
                $datos = array("Carlos Saúl Menem", "Dios Emperador Donald Trump");
            } else {
                echo "405 method not allowed";
            }
            break;
        case "/autos" : 
            if ($request_method == "POST") {
                // Guardo datos
            } else if ($request_method == "GET") {
                // Devuelvo datos
                $datos = array("Ford", "Fiat", "Chevrolet");
            } else {
                echo "405 method not allowed";
            }
            break;
    }

    $respuesta = new stdClass();
    $respuesta->success = true;
    $respuesta->data = $datos;
    echo json_encode($respuesta);
?>
