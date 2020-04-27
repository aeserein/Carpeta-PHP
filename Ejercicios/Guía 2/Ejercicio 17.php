<?php

    $auto1 = new Auto("Ford", "Blanco", null, null);
    $auto2 = new Auto("Ford", "Negro", null, null);

    $auto3 = new Auto("Ford", "Blanco", 1000, null);
    $auto4 = new Auto("Ford", "Blanco", 500, null);

    $auto5 = new Auto("Mazda", "Blanco", 2000, new DateTime());

    $auto3->agregarImpuestos(1500);
    $auto4->agregarImpuestos(1500);
    $auto5->agregarImpuestos(1500);

    Auto::mostrarAuto($auto1);
    Auto::mostrarAuto($auto2);
    Auto::mostrarAuto($auto3);
    Auto::mostrarAuto($auto4);
    Auto::mostrarAuto($auto5);

    echo "Auto 1 + Auto 2: " . Auto::add($auto1, $auto2) . "<br>";
    echo "Auto 3 + Auto 4: " . Auto::add($auto3, $auto4) . "<br>";

    if ($auto1->equals($auto2)) {
        echo "Auto 1 y 2 son iguales<br>";
    } else {
        echo "Auto 1 y 2 son diferentes<br>";
    }
    if ($auto1->equals($auto5)) {
        echo "Auto 1 y 5 son iguales<br>";
    } else {
        echo "Auto 1 y 5 son diferentes<br>";
    }

    /////////////////////////////////////////////////////////////////////////////////////////

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