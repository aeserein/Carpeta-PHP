<?php

class Persona {

    public $nombre;

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function saludar() {
        return "Hola " . $this->nombre; 
    }
}

?>