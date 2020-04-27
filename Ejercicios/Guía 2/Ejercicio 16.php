<?php

    $punto1 = new Punto ($_GET["p1x"], $_GET["p1y"]);
    $punto3 = new Punto ($_GET["p3x"], $_GET["p3y"]);

    $Rectangulo = new Rectangulo($punto1, $punto3);

    $Rectangulo->dibujar();

    /////////////////////////////////////////////////////////////////////////////////////////

    class Punto {
        private $_x;
        private $_y;

        public function __construct($x, $y) {
            $this->_x = $x;
            $this->_y = $y;
        }

        public function getX() {
            return $this->_x;
        }
        public function getY() {
            return $this->_y;
        }
    }

    class Rectangulo {
        private $_vertice1;
        private $_vertice2;
        private $_vertice3;
        private $_vertice4;

        private $area;
        private $ladoUno;
        private $ladoDos;
        private $perimetro;

        public function __construct($punto1, $punto3) {
            $this->_vertice1 = new Punto($punto1->getX(), $punto1->getY());
            $this->_vertice2 = new Punto($punto3->getX(), $punto1->getY());
            $this->_vertice4 = new Punto($punto1->getX(), $punto3->getY());
            $this->_vertice3 = new Punto($punto3->getX(), $punto3->getY());

            $this->ladoUno = abs($this->_vertice1->getX() - $this->_vertice3->getX());
            $this->ladoDos = abs($this->_vertice1->getY() - $this->_vertice3->getY());
            $this->area = $this->ladoUno * $this->ladoDos;
            $this->perimetro = ($this->ladoUno*2) + ($this->ladoDos*2);
        }

        public function dibujar() {
            $partida = min($this->_vertice1->getX(), $this->_vertice3->getX());

            echo str_repeat("<br>", min($this->_vertice1->getY(), $this->_vertice3->getY()));

            for ($f=0 ; $f<$this->ladoDos ; $f++) {
                for ($i=0; $i<$partida; $i++) {
                    echo "&nbsp";
                }
                for ($i=0 ; $i<$this->ladoUno ; $i++) {
                    echo "*";
                }
                echo "*<br>";
            }

            echo "<br>Área: $this->area, Perímetro: $this->perimetro";
        }
    }

?>