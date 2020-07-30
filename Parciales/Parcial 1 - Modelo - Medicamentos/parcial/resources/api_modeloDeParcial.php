<?php

require_once "./resources/Usuario.php";
require_once "./resources/Producto.php";
require_once "./resources/Venta.php";
require_once "./resources/Respuesta.php";
require_once "./resources/Archivo.php";
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class apiModeloDeParcial {

    private $request_method;
    private $path_info;
    private $key;
    private $headers;

    public function __construct() {
        $this->request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
        $this->path_info = $_SERVER["PATH_INFO"];
        $this->key = "example_key";
        $this->headers = getallheaders();
    }

    //////////////////////////////////////////////////////////////////////////////

    public function ejecutar() {

        switch($this->path_info) {
            
            case "/usuario" :
                if ($this->request_method == "POST") {
                    return $this->punto1();
                }
                break;

            case "/login" :
                if ($this->request_method == "POST") {
                    return $this->punto2();
                }
                break;

            case "/stock" :
                if ($this->request_method == "POST") {
                    return $this->punto3();
                } else if ($this->request_method == "GET") {
                    return $this->punto4();
                }
                break;

            case "/ventas" :
                if ($this->request_method == "POST") {
                    return $this->punto5();
                } else if ($this->request_method == "GET") {
                    return $this->punto6();
                }
                break;
        }
    }

    /////////////////////////////////////////////////////////////////////// Puntos

    private function punto1() {

        if (isSet($_POST["nombre"]) && isSet($_POST["dni"]) && isSet($_POST["obra_social"])
            && isSet($_POST["clave"]) && isSet($_POST["tipo"]) &&
            ($_POST["tipo"]=="admin" || $_POST["tipo"]=="user") ) {

            $lista = array();

            try {
                $datos = Archivo::leer("./files/usuarios.txt");
            } catch (\Throwable $th) {
                echo $th->getMessage();
                return Respuesta::crear(false, "Error interno", null);
            }
            
            if ($datos != null)
                $lista = unserialize($datos);

            if ( !Usuario::estaEsteUsuarioEn($lista, $_POST["nombre"]) ) {
                $usuario = new Usuario(time(), $_POST["nombre"], $_POST["dni"], $_POST["obra_social"], $_POST["clave"], $_POST["tipo"]);
                array_push($lista, $usuario);

                try {
                    Archivo::guardar("./files/usuarios.txt", serialize($lista));
                    return Respuesta::crear(true, "Usuario ".$_POST["nombre"]." registrado", null);

                } catch (\Throwable $th) {
                    echo $th->getMessage();
                    return Respuesta::crear(false, "Error interno", null);
                }
            } else {
                return Respuesta::crear(false, "Usuario ".$_POST["nombre"]." ya existe", null);
            }
        }
        return Respuesta::crear(false, "Faltan campos o son incorrectos", null);
    }

    private function punto2() {
        $lista = array();
        if (isSet($_POST["nombre"]) && $_POST["clave"]) {

            try {
                $datos = Archivo::leer("./files/usuarios.txt");
            } catch (\Throwable $th) {
                echo $th->getMessage();
                return Respuesta::crear(false, "Error interno", null);
            }
            
            if ($datos != null)
                $lista = unserialize($datos);
            
            foreach ($lista as $u) {
                if ($u->getNombre() == $_POST["nombre"] && $u->getClave() == $_POST["clave"]) {
                    
                    $payload = array(
                        "id" => $u->getID(),
                        "nombre" => $u->getNombre(),
                        "dni" => $u->getDNI(),
                        "obra_social" => $u->getObraSocial(),
                        "tipo" => $u->getTipo()
                    );
                    $jwt = JWT::encode($payload, $this->key);
                    return Respuesta::crear(true, "Login válido", $jwt);
                }
            }
            return Respuesta::crear(false, "Login fallido", null);
        } else {
            return Respuesta::crear(false, "Faltan campos", null);
        }
    }

    private function punto3() {
        if (isSet($this->headers["token"])) {

            try {
                $decode = $this->decode();
                
                if ($this->esAdminEsteUsuario($decode)) {

                    if (isSet($_POST["producto"]) && isSet($_POST["marca"]) && isSet($_POST["stock"])
                        && isSet($_POST["precio"]) && isSet($_FILES["foto"])) {
                    
                        Archivo::CrearCarpeta("imágenes");

                        $id = time();
                        $origen = $_FILES["foto"]["tmp_name"];
                        $extension = substr($_FILES["foto"]["name"], -3);
                        $destino = "imágenes/" . $id . "." . $extension;
                        move_uploaded_file($origen, $destino);

                        ///////// Punto 7
                        Archivo::ponerMarcaDeAgua($destino, "resources/logo.png", $extension);
                        ////////////////

                        $producto = new Producto($id, $_POST["producto"], $_POST["marca"], $_POST["precio"], $_POST["stock"], $destino);
                        try {
                            Producto::AlJson($producto, "./files/productos.txt");
                            return Respuesta::crear(true, "Producto subido", null);
                        } catch (\Throwable $th) {
                            return Respuesta::crear(true, "Error interno", null);
                        }
                        
                    } else {
                        return Respuesta::crear(false, "Faltan campos", null);
                    }
                } else {
                    return Respuesta::crear(false, "Usuario no es administrador", $decode);
                }                            
            } catch (\Throwable $th) {
                echo $th->getMessage();
                return Respuesta::crear(false, "Token inválido", $this->headers["token"]);
            }
        } else {
            return Respuesta::crear(false, "Falta token", null);
        }
    }

    private function punto4() {
        try {
            $decode = $this->decode();

            $lista = Producto::bajarDeJson("./files/productos.txt");
            foreach ($lista as $p) {
                $p->mostrar();
            }
            return Respuesta::crear(true, "Lista recibida", $lista);
        } catch (\Throwable $th) {
            return Respuesta::crear(false, "Token inválido", $this->headers["token"]);
        }
    }

    private function punto5() {
        try {
            $decode = $this->decode();

            if ($this->esUserEsteUsuario($decode)) {

                if (isSet($_POST["id_producto"]) &&
                    isSet($_POST["cantidad"]) &&
                    isSet($_POST["usuario"])) {

                    $respuesta = Producto::vender($_POST["id_producto"], $_POST["cantidad"], $decode->nombre,
                                                  "./files/productos.txt", "./files/ventas.xxx");
                        // El campo POST usuario no sirve porque ya está en el token y conflictúa
                    return $respuesta;
                } else {
                    return Respuesta::crear(false, "Faltan campos", null);
                }
            } else {
                return Respuesta::crear(false, "Usuario no es cliente", $decode);
            }
        } catch (\Throwable $th) {
            return Respuesta::crear(false, "Token inválido", $this->headers["token"]);
        }
    }

    private function punto6() {
        try {
            $decode = $this->decode();
            $lista = array();

            $datos = Archivo::leer("./files/ventas.xxx");
            if ($datos!=null)
                $lista = unserialize($datos);

            echo "<b>Ventas:</b><br>";
                        
            if ($decode->tipo == "admin") {                
                foreach ($lista as $venta) {
                    echo $venta->mostrar();
                }
                return Respuesta::crear(true, "Lista recibida", $lista);

            } else if ($decode->tipo == "user") {
                $listaDelUsuario = array();
                foreach ($lista as $venta) {
                    if ($venta->usuario == $decode->nombre) {
                        echo $venta->mostrar();
                        array_push($listaDelUsuario, $venta);
                    }
                }
                return Respuesta::crear(true, "Lista recibida", $listaDelUsuario);
            }

        } catch (\Throwable $th) {
            return Respuesta::crear(false, "Token inválido", $this->headers["token"]);
        }
    }

    /////////////////////////////////////////////////////////////////////// Auxiliares

    private function esAdminEsteUsuario($decode) {
        return ($decode->tipo === "admin");
    }
    private function esUserEsteUsuario($decode) {
        return ($decode->tipo === "user");
    }

    private function decode() {
        try {
            $token = $this->headers["token"];
            $decode = JWT::decode($token, $this->key, array('HS256'));
            return $decode;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
?>