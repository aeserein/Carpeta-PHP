<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class UsuarioController {

    public function registro (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $respuesta;

        $match = array(
            "1",
            "2"
        );
        if (!isSet($body["email"]) || !isSet($body["nombre"]) ||
            !isSet($body["clave"]) || !isSet($body["tipo"]) ||
            !in_array(strtolower($body["tipo"]), $match) || strlen($body["clave"]) < 4) {
            
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {
            $usuario = new Usuario();
            $usuario->email = $body["email"];
            $usuario->nombre = $body["nombre"];
            $jwtPassword = self::pseudoencriptarPassword($body["clave"]);
            $usuario->clave = $jwtPassword;
            $usuario->id_tipo = (int) $body["tipo"];

            try {
                $usuario->save();
                $respuesta = Respuesta::crear(true, "Usuario creado", NULL);
            } catch (\Throwable $th) {
                $respuesta = Respuesta::crear(false, "Usuario ".$usuario->email." ya existe", NULL);
            }
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function login (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $respuesta;
        
        if ((!isSet($body["email"]) && !isSet($body["nombre"])) ||
             !isSet($body["clave"])) {            
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {
            if (isSet($body["email"]))
                $usuario = Usuario::join("tipos_usuarios", "tipos_usuarios.id", "users.id_tipo")
                    ->select("users.id", "users.email", "users.nombre", "users.clave", "tipos_usuarios.tipo")
                    ->where("email", $body["email"])->first();
            else
                $usuario = Usuario::join("tipos_usuarios", "tipos_usuarios.id", "users.id_tipo")
                    ->select("users.id", "users.email", "users.nombre", "users.clave", "tipos_usuarios.tipo")
                    ->where("nombre", $body["nombre"])->first();
            
            if (isSet($usuario)) {
                $passwordEnJwt = $usuario->clave;
                $decodedPassword = self::pseudodesencriptarPassword($passwordEnJwt);

                if ($decodedPassword === $body["clave"]) {

                    //echo $usuario->id;
                    //echo "<br><br>";
                    //var_dump($usuario);
                    
                    $keyJwt = $_SERVER["KEY_JWT"];
                    $payload = array(
                        "id" => $usuario->id,
                        "nombre" => $usuario->nombre,
                        "email" => $usuario->email,
                        "tipo" => $usuario->tipo
                    );
                    $jwt = JWT::encode($payload, $keyJwt);
                    $respuesta = Respuesta::crear(true, "Login válido", $jwt);
                } else {
                    $respuesta = Respuesta::crear(false, "Contraseña incorrecta", NULL);
                }
            } else {
                $respuesta = Respuesta::crear(false, "Email o nombre incorrectos", NULL);
            }
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    private function pseudodesencriptarPassword($jwtPassword) {
        $keyPassword = $_SERVER["KEY_PASSWORD"];
        $decodedPassword = JWT::decode($jwtPassword, $keyPassword, array('HS256'));
        return $decodedPassword->password;
    }

    private function pseudoencriptarPassword($password) {
        $keyPassword = $_SERVER["KEY_PASSWORD"];
        $payloadPassword = array(
            "password" => $password
        );
        $jwtPassword = JWT::encode($payloadPassword, $keyPassword);
        return $jwtPassword;
    }
}

?>