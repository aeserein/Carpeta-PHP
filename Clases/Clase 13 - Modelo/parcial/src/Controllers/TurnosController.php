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

        date_default_timezone_set("America/Buenos_Aires");
        $horaApertura = new DateTime('09:00');
        $horaCierre = new DateTime('17:00');
        $hoy = new DateTime();
        $turno_hora = new DateTime($body['hora']);
        $turno_fecha = new DateTime($body['fecha']);
        
        if ($hoy->getTimestamp() > $turno_fecha->getTimestamp()) {

            $respuesta = Respuesta::crear(false, "Fecha incorrecta", NULL);

        } else if ($turno_hora->getTimestamp() < $horaApertura->getTimestamp() ||
            $turno_hora->getTimestamp() > $horaCierre->getTimestamp() ||
            ($turno_hora->format('i') != "30" && $turno_hora->format('i') != "00")) {

            $respuesta = Respuesta::crear(false, "Hora incorrecta", NULL);

        } else {
            $veterinario = Usuario::where("id_usuario", $body["id_veterinario"])
                ->where("id_tipo", 2)
                ->first();

            if (isSet($veterinario)) {
                $turno = Turno::where("fecha", $turno_fecha)
                    ->where("hora", $turno_hora)
                    ->where("id_veterinario", $veterinario->id_usuario)
                    ->count();
                if ($turno > 0) {
                    $respuesta = Respuesta::crear(false, "Veterinario ocupado en ese horario", NULL);
                } else {
                    $turno = new Turno();
                    $turno->id_mascota = $body["id_mascota"];
                    $turno->fecha = $turno_fecha;
                    $turno->hora = $turno_hora;
                    $turno->id_veterinario = $veterinario->id_usuario;

                    try {
                        $turno->save();
                        $respuesta = Respuesta::crear(true, "Turno reservado", NULL);
                    } catch (\Throwable $th) {
                        $respuesta = Respuesta::crear(true, $th->getMessage(), NULL);
                    }
                }
            } else {
                $respuesta = Respuesta::crear(false, "Error en el campo id_veterinario", NULL);
            }
        }
        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function verTurnos (Request $request, Response $response, $args) {

        if (isSet($args["id_usuario"])) {
            $usuario = Usuario::where("id_usuario", $args["id_usuario"])
                ->first();
            
            if (isSet($usuario)) {
                if ($usuario->id_tipo === 2) {
                    $turnos = Turno::select("id_turno", "id_mascota", "fecha", "hora", "id_veterinario")
                    ->where("id_veterinario", $args["id_usuario"])
                    ->get();
                    $respuesta = Respuesta::crear(true, "Lista recibida", $turnos);
                } else if ($usuario->id_tipo === 1) {
                    $turnos = Turno::join("mascotas", "mascotas.id_mascota", "turnos.id_turno")
                        ->join("usuarios", "usuarios.id_usuario", "mascotas.id_cliente")
                        ->select("turnos.fecha", "turnos.hora", "mascotas.nombre")
                        ->where("id_usuario", $usuario->id_usuario)
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