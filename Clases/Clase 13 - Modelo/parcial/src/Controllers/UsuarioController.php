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
            "cliente",
            "veterinario",
            "1",
            "2"
        );
        if (!isSet($body["email"]) || !isSet($body["password"]) || !isSet($body["tipo"]) ||
            !in_array(strtolower($body["tipo"]), $match)) {
            
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {
            $usuario = new Usuario();
            $usuario->email = $body["email"];

            $jwtPassword = self::pseudoencriptarPassword($body["password"]);
            $usuario->password = $jwtPassword;

            if (strtolower($body["tipo"]) === "cliente") {
                $usuario->id_tipo = 1;
            } else {
                $usuario->id_tipo = 2;
            }
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

        if (!isSet($body["email"]) || !isSet($body["password"])) {            
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {
            $usuario = Usuario::join("tipos_usuarios", "tipos_usuarios.id_tipo", "usuarios.id_tipo")
                ->where("email", $body["email"])->first();
            
            if (isSet($usuario)) {
                $passwordEnJwt = $usuario->password;
                $decodedPassword = self::pseudodesencriptarPassword($passwordEnJwt);

                if ($decodedPassword === $body["password"]) {

                    $keyJwt = $_SERVER["KEY_JWT"];
                    $payload = array(
                        "id" => $usuario->id_usuario,
                        "email" => $usuario->email,
                        "tipo" => $usuario->tipo
                    );
                    $jwt = JWT::encode($payload, $keyJwt);
                    $respuesta = Respuesta::crear(true, "Login válido", $jwt);
                } else {
                    $respuesta = Respuesta::crear(false, "Usuario o contraseña incorrectas2", NULL);
                }
            } else {
                $respuesta = Respuesta::crear(false, "Usuario o contraseña incorrectas", NULL);
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