<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DateTime;
use App\Models\Turno;
use App\Models\Usuario;
use App\Models\Mascota;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class TurnosController {

    public function registro (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();

        date_default_timezone_set("America/Buenos_Aires");
        $horaApertura = new DateTime('09:00');
        $horaCierre = new DateTime('17:00');
        $hoy = new DateTime();
        $fecha_y_hora = new DateTime($body['fecha']);
        $fechaTurno = $fecha_y_hora->format('d/m/Y');
        $horaTurno = $fecha_y_hora->format('H:i:s');
        
        if ($hoy->getTimestamp() > $fecha_y_hora->getTimestamp()) {

            $respuesta = Respuesta::crear(false, "Fecha incorrecta", NULL);

        } else if ($fecha_y_hora->format('H') < $horaApertura->format("H") ||
                   $fecha_y_hora->format('H') > $horaCierre->format("H") ||
                   ($fecha_y_hora->format('i') != "30" && $fecha_y_hora->format('i') != "00")) {

            $respuesta = Respuesta::crear(false, "Hora incorrecta", NULL);

        } else {

            $veterinario = Usuario::where("id", $body["veterinario_id"])
                ->where("tipo", 2)
                ->first();

            if (isSet($veterinario)) {
                $turno = Turno::where("fecha", $fecha_y_hora)
                    ->where("veterinario_id", $veterinario->id)
                    ->count();
                    
                if ($turno > 0) {
                    $respuesta = Respuesta::crear(false, "Veterinario ocupado en ese horario", NULL);
                } else {

                    $turno = new Turno();
                    $turno->veterinario_id = $veterinario->id;
                    $turno->mascota_id = $body["mascota_id"];
                    $turno->fecha = $fecha_y_hora;
                    try {
                        $turno->save();
                        $respuesta = Respuesta::crear(true, "Turno reservado", NULL);
                    } catch (\Throwable $th) {                        
                        $respuesta = Respuesta::crear(false, "Algun campo no es correcto", NULL);
                    }
                }
            } else {
                $respuesta = Respuesta::crear(false, "Error en el campo veterinario_id", NULL);
            }
        }
        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function verTurnos (Request $request, Response $response, $args) {

        if (isSet($args["id_usuario"])) {
            $usuario = Usuario::where("id", $args["id_usuario"])
                ->first();
            
            if (isSet($usuario)) {

                if ($usuario->tipo === 2 && $usuario->id == $args["id_usuario"]) {
                    $turnos = Turno::select("id", "mascota_id", "fecha", "veterinario_id")
                        ->where("veterinario_id", $args["id_usuario"])
                        ->get();
                    $respuesta = Respuesta::crear(true, "Lista recibida", $turnos);

                } else if ($usuario->tipo === 3) {

                    $hoy = new DateTime();
                    $turnos = Turno::select('fecha', 'mascotas.nombre', 'mascotas.fecha_nacimiento', 'usuarios.usuario as dueño')
                        ->whereDate('fecha', $hoy->format('Y-m-d'))
                        ->join('mascotas', 'turnos.mascota_id', '=', 'mascotas.id')
                        ->join('usuarios', 'mascotas.cliente_id', '=', 'usuarios.id')
                        ->orderBy('fecha', 'desc')
                        ->get();

                    $respuesta = Respuesta::crear(true, "Lista recibida", $turnos);
                } else {
                    $respuesta = Respuesta::crear(false, "Id incorrecto(2)", NULL);
                }
            } else {
                $respuesta = Respuesta::crear(false, "Id incorrecto", NULL);
            }
        } else {
            $respuesta = Respuesta::crear(false, "Error en el query param", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }
}

?>