<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Mascota;
use App\Models\TipoMascota;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class MascotaController {

    public function registrarTipo (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();
        $respuesta;

        if (!isSet($body["tipo"]) || !isSet($headers["token"][0])) {
            $respuesta = Respuesta::crear(false, "Error en los argumentos", NULL);
        } else {
            try {
                $key = $_SERVER["KEY_JWT"];
                $decoded = JWT::decode($headers["token"][0], $key, array('HS256'));
                if ($decoded->tipo === 1) {
                    $tipoMascota = new TipoMascota();
                    $tipoMascota->tipo = $body["tipo"];
    
                    try {
                        $tipoMascota->save();
                        $respuesta = Respuesta::crear(true, "Tipo ".$tipoMascota->tipo." creado", NULL);
                    } catch (\Throwable $th) {
                        $respuesta = Respuesta::crear(false, "Mascota tipo ".$tipoMascota->tipo." ya existe", NULL);
                    }
                } else {
                    $respuesta = Respuesta::crear(false, "Usuario no tiene permisos para realizar esta tarea", NULL);
                }
            } catch (\Throwable $th) {
                $respuesta = Respuesta::crear(false, "Error en el token", NULL);
            }
            
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function registro (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();

        $mascota = new Mascota();
        $mascota->nombre = $body["nombre"];
        $mascota->fecha_nacimiento = $body["fecha_nacimiento"];
        $mascota->cliente_id = $body["cliente_id"];
        $mascota->tipo_mascota_id = $body["tipo_mascota_id"];

        try {
            $mascota->save();
            $respuesta = Respuesta::crear(true, "Mascota guardada", NULL);
        } catch (\Throwable $th) {
            $respuesta = Respuesta::crear(false, "No se pudo guardar mascota", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    ///////////////////////////

    public function verHistorialDeMascota (Request $request, Response $response, $args) {

        if (isSet($args["id_mascota"])) {
            try {
                $mascota = Mascota::join("turnos", "turnos.id_mascota", "mascotas.id_mascota")
                    ->select("mascotas.nombre", "mascotas.edad", "turnos.fecha", "turnos.hora")
                    ->where("mascotas.id_mascota", $args["id_mascota"])
                    ->get();
                $respuesta = Respuesta::crear(true, "Lista recibida", $mascota);
            } catch (\Throwable $th) {
                $respuesta = Respuesta::crear(false, $th->getMessage(), NULL);
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