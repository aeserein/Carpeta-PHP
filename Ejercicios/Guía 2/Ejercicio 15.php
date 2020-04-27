<?php

    $ancho = $_GET["ancho"];
    $largo = $_GET["largo"];
    $color = $_GET["color"];

    $cuadrado = new Cuadrado($ancho, $largo, $color);
    $cuadrado->calcularDatos();
    $cuadrado->toString();


    /////////////////////////////////////////////////////////////////////////////////////////

    abstract class FiguraGeometrica {
        protected $_color;
        protected $_perimetro;
        protected $_superficie;

        public function __construct() {            
        }

        function getColor() {
            return $this->_color;
        }
        function setColor($color) {
            $this->_color = $color;
        }
        function toString() {
        }
        abstract function dibujar();
        abstract protected function calcularDatos();
    }

    class Cuadrado extends FiguraGeometrica {
        private $_lado1;
        private $_lado2;

        public function __construct($l1, $l2, $color) {
            $this->_lado1 = $l1;
            $this->_lado2 = $l2;
            $this->setColor($color);
        }

        function calcularDatos() {
            $this->_perimetro = $this->_lado1*2 + $this->_lado2*2;
            $this->_superficie = $this->_lado1 * $this->_lado2;
            echo "Perímetro: $this->_perimetro - Superficie: $this->_superficie<br>";
        }
        function dibujar() {            
            $dibujo = "";
            for ($a=0; $a<$this->_lado2; $a++) {
                for ($l=0; $l<$this->_lado1; $l++) {
                    $dibujo .= "*";
                }
                $dibujo .= "<br>";
            }
            return "<p> <font color=" . $this->getColor() . ">$dibujo</font> </p>";
        }
        function toString() {
            echo $this->dibujar();
        }
    }

?>