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
            "2",
            "3"
        );
        if (!isSet($body["email"]) || !isSet($body["clave"]) ||
            !isSet($body["tipo"]) || !isSet($body["nombre"]) ||
            !in_array(strtolower($body["tipo"]), $match)) {
            
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {

            $legajo = Usuario::count() + 1000;

            $usuario = new Usuario();
            $usuario->email = $body["email"];
            $jwtPassword = self::pseudoencriptarPassword($body["clave"]);
            $usuario->clave = $jwtPassword;
            $usuario->tipo_id = (int) $body["tipo"];
            $usuario->nombre = $body["nombre"];
            $usuario->legajo = $legajo;

            try {
                $usuario->save();
                $respuesta = Respuesta::crear(true, "Usuario ".$usuario->nombre." creado", NULL);
            } catch (\Throwable $th) {
                echo $th->getMessage();
                $respuesta = Respuesta::crear(false, "Usuario ".$usuario->nombre." ya existe", NULL);
            }
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function login (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $respuesta;
        
        if (!isSet($body["email"]) || !isSet($body["clave"])) {            
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {
            $usuario = Usuario::where("email", $body["email"])->first();
            
            if (isSet($usuario)) {
                $passwordEnJwt = $usuario->clave;
                $decodedPassword = self::pseudodesencriptarPassword($passwordEnJwt);

                if ($decodedPassword === $body["clave"]) {

                    $keyJwt = $_SERVER["KEY_JWT"];
                    $payload = array(
                        "id" => $usuario->id,
                        "email" => $usuario->email,
                        "nombre" => $usuario->nombre,
                        "tipo" => $usuario->tipo_id,
                        "legajo" => $usuario->legajo
                    );
                    $jwt = JWT::encode($payload, $keyJwt);
                    $respuesta = Respuesta::crear(true, "Login válido", $jwt);
                } else {
                    $respuesta = Respuesta::crear(false, "Email o contraseña incorrectas2", NULL);
                }
            } else {
                $respuesta = Respuesta::crear(false, "Email o contraseña incorrectas", NULL);
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