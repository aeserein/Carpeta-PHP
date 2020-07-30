<?php

class Usuario {

    public $id;
    public $nombre;
    public $dni;
    public $obraSocial;
    public $clave;
    public $tipo;

    public function __construct($id, $nombre, $dni, $obraSocial, $clave, $tipo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->obraSocial = $obraSocial;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }

    public function getID() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getDNI() {
        return $this->dni;
    }
    public function getObraSocial() {
        return $this->obraSocial;
    }
    public function getTipo() {
        return $this->tipo;
    }
    public function getClave() {
        return $this->clave;
    }

    static public function estaEsteUsuarioEn($array, $nombreDeUsuario) {
        foreach ($array as $u) {
            if ($u->nombre === $nombreDeUsuario)
                return true;
        }
        return false;
    }
}

?>