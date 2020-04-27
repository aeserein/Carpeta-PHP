<?php

    $nombre = "El Donaldo";
    echo "Hola PHP $nombre<br>";

    $nombre = 12;
    echo "Hola PHP $nombre<br>";

    $nombre = "El Donaldo";
    echo strtoupper("Hola PHP $nombre<br><br>");

    $array = array(1,2,"AEEEA" => "Yo soy menemista");
    var_dump($array);
    echo "<br>";

    echo "$array[0]<br>";

    $array[0] = "-Primer índice array-";
    $array[1234] = "Número 1234";
    $array["Cacho Castaña"] = "Índice Cacho Castaña";
    array_push($array, "Pusheado");
    var_dump($array);
    echo "<br>";

    rsort($array);
    var_dump($array);
    echo "<br><br>";

    SaLuDaR();

    function saludar($unArgumento="NN") {
        echo "AEEEEA YO SOY MENEMISTA<br>";
    }
    include './funciones.php';
    include_once './funciones.php';
    include_once './funciones.php';
    include_once './funciones.php';
    // include copia todo lo que está en el archivo en este archivo
    // include_once solo incluye si no está incluida
    // con include el programa intenta seguir ejecutando si no encuentra algo
    // con require se crachea
    saludarEnFunciones();

    $persona = new persona("NombreDePersona");
    $persona->saludarNombre();
    echo "<br><br>";

    $personaDerivada = new personaDerivada(420);
    $personaDerivada->saludarNombreEdad();
    echo "<br><br>";
    
    // Composer
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    // create a log channel
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

    // add records to the log
    $log->warning('Foo');
    $log->error('Bar');

    //$countries = new RestCountries->all

// Comentario de una linea

# Otro comentario de una línea

/* Comentario de líneas múltiples

    PHP = Hypertext Pre-Processor
    Invisible al browser
    Capacidad de conexión a base de datos
    Muchos plugins
    Server side
    Todo el código dentro de xampp/htdocs/

    Por defecto si no pongo el nombre del archivo en la url va a buscar index.php

    Variables

    Boolean
    Integer
    Float
    String

    Array
    Object

    Las variables empiezan con el signo $
    $nombre ; $edad
    Castea automático (tipado leve)
    También se puede castear manual
        -> Todos los tipos + (unset) para pasar a null

    echo " ------- "
    printf como en c

    ---------------------

    if -> como siempre
    switch -> como siempre
    for -> como siempre, sin declarar la variable de control
    foreach -> arrays y objetos
    foreach($array as $valor) {
        $valor es la variable
    }
    while -> como siempre
    do while -> como siempre

    ------------------------

    3 tipos de array
        Indexados       -> índice numerado
        Asociativos     -> índice con strings
        Multidimensionales -> array de array
    
    Funciones para ordenar arrays

    ------------------------

    Declarar funciones
    function NombreDeFunción(){        
    }

    nombres no case sensitive
    las variables tienen que tener un valor si o si
        -> Por defecto o definidas en el php o en la url

    ------------------------

    Declarar clases
    class NombreDeClase(){
        private $var1;
        protected $var2;
        public static $var3;

        function __construct() {
            Esto es el constructor
        }
    }
    por defecto todo público
    no hay sobrecarga de construcotres
     parent::__construct

    -------------------------

    composer init -> crea json
    composer require [nombre de dependencia a instalar] -> instala dependencia
    composer install -> lee las dependencias en composer.json e instala

    -------------------------

    Clase que viene
    2 guías de ejercicios
    Otro proyecto para hacer con composer con la api de los países
*/
?>
