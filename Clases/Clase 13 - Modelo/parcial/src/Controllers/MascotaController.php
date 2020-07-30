<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Mascota;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class MascotaController {

    public function registro (Request $request, Response $response, $args) {
        $args = $request->getParsedBody();
        $headers = $request->getHeaders();

        $mascota = new Mascota();
        $mascota->nombre = $args["nombre"];
        $mascota->edad = $args["edad"];
        $key = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $key, array('HS256'));
        $mascota->id_cliente = $decoded->id;

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