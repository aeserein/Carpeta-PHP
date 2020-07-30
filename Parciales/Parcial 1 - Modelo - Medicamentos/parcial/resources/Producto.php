<?php

class Producto {

    public $id;
    public $producto;
    public $marca;
    public $precio;
    public $stock;
    public $foto;

    public function __construct($id, $producto, $marca, $precio, $stock, $foto) {
        $this->id = $id;
        $this->producto = $producto;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->foto = $foto;
    }

    public function mostrar() {
        echo "Producto: " . $this->producto . "<br>".
        "ID: " . $this->id . "<br>".
        "Marca: " . $this->marca . "<br>".
        "Precio: " . $this->precio . "<br>".
        "Stock: " . $this->stock . "<br><br>";
    }

    static public function AlJson($productoAAgregar, $path) {
        $lista = array();        
        try {
            $dato = Archivo::Leer($path);
            if ($dato!=null)
                $lista = json_decode($dato);

            array_push($lista, $productoAAgregar);
            $json = json_encode($lista);
            Archivo::guardar($path, $json);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    static public function bajarDeJson($path) {
        $lista = array();
        try {
            $dato = Archivo::Leer($path);
            if ($dato!=null)
                $json = json_decode($dato);

            foreach ($json as $j) {
                $producto = new Producto($j->id, $j->producto, $j->marca, $j->precio, $j->stock, $j->foto);
                array_push($lista, $producto);
            }
            return $lista;
        } catch (\Throwable $th) {
            throw $th;
        }

        return $lista;
    }

    static public function vender($id_producto, $cantidad, $usuario, $pathProductos, $pathVentas) {
        try {
            $lista = Producto::bajarDeJson($pathProductos);
            $ventas = array();

            for ($f=0; $f<count($lista); $f++) {
                if ($lista[$f]->id == $id_producto) {
                    if ($lista[$f]->stock >= $cantidad) {

                        $lista[$f]->stock -= $cantidad;
                        $precioFinal = $lista[$f]->precio * $cantidad;

                        if ($lista[$f]->stock == 0) {
                            unlink($lista[$f]->foto);
                            array_splice($lista, $f, 1);
                        }

                        $json = json_encode($lista);
                        Archivo::guardar($pathProductos, $json);
                        
                        $datos = Archivo::leer($pathVentas);
                        if ($datos != null)
                            $ventas = unserialize($datos);                        
                        
                        $estaVenta = new Venta($id_producto, $cantidad, $usuario, $precioFinal);
                        array_push($ventas, $estaVenta);

                        Archivo::guardar($pathVentas, serialize($ventas));
                        return Respuesta::crear(true, "Compra realizada", $precioFinal);

                    } else {
                        return Respuesta::crear(false, "No hay stock", null);
                    }
                }
            }
            return Respuesta::crear(false, "No se encontró el ID", $id_producto);
        } catch (\Throwable $th) {
            return Respuesta::crear(false, "Algo salió mal", null);
        }
        
    }
}