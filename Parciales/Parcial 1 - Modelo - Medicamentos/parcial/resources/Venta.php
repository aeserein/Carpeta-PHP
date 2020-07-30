<?php

class Venta {

    public $id;
    public $cantidad;
    public $usuario;
    public $ganancias;

    public function __construct($id, $cantidad, $usuario, $ganancias) {
        $this->id = $id;
        $this->cantidad = $cantidad;
        $this->usuario = $usuario;
        $this->ganancias = $ganancias;
    }

    public function mostrar() {
        return "ID: " . $this->id . "<br>".
               "Cantidad: " . $this->cantidad . "<br>".
               "Comprador: " . $this->usuario . "<br>".
               "Valor: " . $this->ganancias . "<br><br>";
    }
}

?>