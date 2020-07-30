<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DateTime;
use App\Models\Evento;
use App\Models\Usuario;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class EventoController {

    public function registro (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();

        $keyJwt = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));
        
        date_default_timezone_set("America/Buenos_Aires");
        $hoy = new DateTime();
        $fecha_y_hora = new DateTime($body['fecha']);
        
        if ($hoy->getTimestamp() > $fecha_y_hora->getTimestamp()) {

            $respuesta = Respuesta::crear(false, "Fecha incorrecta", NULL);

        } else {

            $usuario = Usuario::where("id", $decoded->id)
                ->where("id_tipo", 1)
                ->first();

            if (isSet($usuario) && $usuario->id_tipo == 1) {
                $evento = new Evento();
                $evento->fecha = $fecha_y_hora;
                $evento->descripcion = $body["descripcion"];
                $evento->id_usuario = $decoded->id;

                echo $decoded->id;

                try {
                    $evento->save();
                    $respuesta = Respuesta::crear(true, "Evento guardado", NULL);
                } catch (\Throwable $th) {
                    $respuesta = Respuesta::crear(false, "No se pudo guardar evento", NULL);
                }
            } else {
                $respuesta = Respuesta::crear(false, "Usuario inválido", NULL);
            }
        }
        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function modificarFecha (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();
        $respuesta;

        $keyJwt = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));

        if ($decoded->tipo == "user") {
            try {
                $evento = Evento::where("id", $args["id"])
                                ->first();
                $usuario = Usuario::where("id", $decoded->id)
                                ->first();

                if (isSet($evento) && isSet($usuario) && $usuario->id_tipo == 1) {
                    
                    if ($evento->id_usuario == $usuario->id) {

                        $hoy = new DateTime();
                        $nuevaFechaYHora = new DateTime($body['fecha']);
                        $evento->fecha = $nuevaFechaYHora;

                        try {
                            $evento->save();
                            $respuesta = Respuesta::crear(true, "Evento modificado", NULL);
                        } catch (\Throwable $th) {
                            $respuesta = Respuesta::crear(false, "No se pudo modificar el evento", NULL);
                        }
                    } else {
                        $respuesta = Respuesta::crear(false, "No se pude modificar el evento de otro usuario", NULL);
                    }            
                } else {
                    $respuesta = Respuesta::crear(false, "Ids de evento y/o usuario incorrectos-", NULL);
                }
            } catch (\Throwable $th) {
                $respuesta = Respuesta::crear(false, "Ids de evento y/o usuario incorrectos", NULL);
            }
        } else {
            $respuesta = Respuesta::crear(false, "Usuario no es de tipo user", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function verTurnos (Request $request, Response $response, $args) {
        $headers = $request->getHeaders();

        $keyJwt = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));

        if (isSet($decoded->id)) {
            $usuario = Usuario::where("id", $decoded->id)
                ->first();
            
            if (isSet($usuario)) {

                if ($usuario->id_tipo == 1) {
                    $turnos = Evento::select("id", "fecha", "descripcion")
                        ->where("id_usuario", $decoded->id)
                        ->orderBy('fecha', 'DESC')
                        ->get();
                    $respuesta = Respuesta::crear(true, "Lista recibida", $turnos);

                } else if ($usuario->id_tipo == 2) {

                    $turnos = Evento::select("eventos.id", 'eventos.fecha', 'eventos.descripcion', "users.id", 'users.nombre')
                        ->join('users', 'eventos.id_usuario', 'users.id')
                        // Asumo que primero por nombre de usuario y después por fecha,
                        // y en order ascendente
                        ->orderBy('users.nombre', 'ASC')    
                        ->orderBy('eventos.fecha', 'ASC')
                        ->get();

                    $respuesta = Respuesta::crear(true, "Lista recibida", $turnos);
                }
            } else {
                $respuesta = Respuesta::crear(false, "Id incorrecto", NULL);
            }
        } else {
            $respuesta = Respuesta::crear(false, "No debería venir acá", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }
}

?>