<?php

    function saludarEnFunciones(){
        echo "AEEEEA DALE MENEM DALE MENEM<br>";
    }

    class persona {
        public $nombre;

        public function __construct($nombre) {
            $this->nombre = $nombre;
        }

        public function saludarNombre() {
            echo "Hola ".$this->nombre;
        }
    }

    class personaDerivada extends persona {
        public $edad;

        public function __construct($edad) {
            $this->edad = $edad;
        }

        public function saludarNombreEdad() {
            echo "Hola $this->nombre, $this->edad años";
        }
    }
?>