<?php

    $auto1 = new Auto("Ford", "Blanco", 2000, new DateTime());
    $auto2 = new Auto("Peugeot", "Gris", 2000, new DateTime());
    $auto3 = new Auto("Chery", "Azul", 2000, new DateTime());
    $auto4 = new Auto("Mazda", "Blanco", 2000, new DateTime());
    $auto5 = new Auto("Chinchun", "Blanco", 2000, new DateTime());

    $garage = new Garage("Aeeeea", 60);
    
    $garage->add($auto1);
    $garage->add($auto2);
    $garage->add($auto3);
    $garage->add($auto4);
    $garage->add($auto5);
    
    $garage->mostrarGarage();

    echo "--------------------------------------------------------------------------------------------------------------<br><br>";

    $garage->add($auto5);
    $garage->remove($auto1);
    $garage->remove($auto3);

    $garage->mostrarGarage();

    /////////////////////////////////////////////////////////////////////////////////////////

    class Garage {
        private $_razonSocial;
        private $_precioPorHora;
        private $_autos;

        public function __construct($razonSocial, $precioPorHora) {
            $this->_razonSocial = $razonSocial;
            if ($precioPorHora!=null) {
                $this->_precioPorHora = $precioPorHora;
            } else {
                $this->_precioPorHora = 0;
            }
            $this->_autos = array();
        }
        public function mostrarGarage() {
            echo "Razón social: $this->_razonSocial<br>
                Precio por hora: $this->_precioPorHora/h<br>
                Autos:<br>";
            foreach ($this->_autos as $a) {
                Auto::mostrarAuto($a);
            }
        }
        public function equals($auto) {
            foreach ($this->_autos as $a) {
                if ($a->equals($auto)) {
                    return true;
                }
            }
            return false;
        }
        public function add($auto) {
            if (!$this->equals($auto)) {
                array_push($this->_autos, $auto);
            } else {
                echo "No se agregó auto<br>";
            }
        }
        public function remove($auto) {
            $index = array_search($auto, $this->_autos);
            if (!is_bool($index)) {
                unset($this->_autos[$index]);
            }
        }
    }

    class Auto {
        private $_color;
        private $_precio;
        private $_marca;
        private $_fecha;

        public function __construct($marca, $color, $precio, $fecha) {
            $this->_marca = $marca;
            $this->_color = $color;

            if ($precio!=null) {
                $this->_precio = $precio;
            } else {
                $this->_precio = 0;
            }
            $this->_fecha = $fecha;
        }

        function agregarImpuestos($impuesto) {
            $this->_precio += $impuesto;
        }
        static function mostrarAuto($auto) {
            echo "Color: $auto->_color<br>
                Precio: $auto->_precio<br>
                Marca: $auto->_marca<br>";
                if ($auto->_fecha != null) {
                    echo "Fecha: " . $auto->_fecha->format("d/m/y");
                }
                echo "<br><br>";
        }
        function equals($auto) {
            return ($this->_marca == $auto->_marca);
        }
        static function add($auto1, $auto2) {
            if ($auto1->equals($auto2) &&
                strcasecmp($auto1->_color, $auto2->_color) == 0) {

                return ($auto1->_precio + $auto2->_precio);
            }                
            else
                echo "No se pudieron sumar autos<br>";
                return 0;
        }
    }

?>