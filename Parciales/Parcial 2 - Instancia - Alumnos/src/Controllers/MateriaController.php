<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use App\Models\Inscripto;
use App\Models\Usuario;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;
use DateTime;

class MateriaController {

    public function registro (Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();

        $materia = new Materia();
        $materia->materia = $body["materia"];
        $materia->cuatrimestre = $body["cuatrimestre"];
        $materia->vacantes = $body["vacantes"];
        $materia->profesor_id = $body["profesor"];

        try {
            $materia->save();
            $respuesta = Respuesta::crear(true, "Materia guardada", NULL);
        } catch (\Throwable $th) {
            $respuesta = Respuesta::crear(false, "No se pudo guardar materia", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function verMaterias (Request $request, Response $response, $args) {
        $headers = $request->getHeaders();

        $keyJwt = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));

        if ($decoded->tipo == 1) {      // Alumno
            try {
                $materia = Materia::select("id", "materia", "cuatrimestre", "vacantes", "profesor_id")
                                  ->where("id", $args["id"])
                                  ->get();
                $respuesta = Respuesta::crear(true, "Materia recibida", $materia);
            } catch (\Throwable $th) {
                $respuesta = Respuesta::crear(false, "Error al buscar materia", NULL);
            }

        } else if ($decoded->tipo == 2 || $decoded->tipo == 3) {        // Profesor o admin
            try {
                $materia = Materia::select("id", "materia", "cuatrimestre", "vacantes", "profesor_id")
                                  ->where("id", $args["id"])
                                  ->get();

                $inscriptos = Inscripto::select("users.nombre as alumnos")
                                       ->join("users", "users.id", "inscriptos.alumno_id")
                                       ->get();

                $obj = array(
                    "materia" => $materia,
                    "inscriptos" => $inscriptos
                );
                $respuesta = Respuesta::crear(true, "Materia recibida", $obj);
            } catch (\Throwable $th) {
                echo $th->getMessage();
                echo "<br><br>";
                $respuesta = Respuesta::crear(false, "Error al buscar materia", NULL);
            }
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function asignarProfesor (Request $request, Response $response, $args) {
        $headers = $request->getHeaders();
        $respuesta;

        $keyJwt = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));
        if ($decoded->tipo == 3) {
            try {
                $materia = Materia::where("id", $args["id"])
                                ->first();
                $profesor = Usuario::where("id", $args["profesor"])
                                ->first();

                if (isSet($materia) && isSet($profesor) && $profesor->tipo_id == 2) {
                    $materia->profesor_id = $profesor->id;

                    try {
                        $materia->save();
                        $respuesta = Respuesta::crear(true, "Profesor asignado", NULL);
                    } catch (\Throwable $th) {
                        $respuesta = Respuesta::crear(false, "No se pudo asignar profesor", NULL);
                    }
            
                } else {
                    $respuesta = Respuesta::crear(false, "Ids de materia y/o profesor incorrectos", NULL);
                }
            } catch (\Throwable $th) {
                $respuesta = Respuesta::crear(false, "Ids de materia y/o profesor incorrectos", NULL);
            }
        } else {
            $respuesta = Respuesta::crear(false, "No tiene permisos para asignar profesores", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function inscribirAlumno (Request $request, Response $response, $args) {
        $headers = $request->getHeaders();
        $respuesta;

        $keyJwt = $_SERVER["KEY_JWT"];
        $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));
        if ($decoded->tipo == 1) {
            $materia = Materia::where("id", $args["id"])
                                    ->first();
            if (isSet($materia)) {
                
                if  ($materia->vacantes > 0) {
                    
                    $inscripto = new Inscripto();
                    $inscripto->alumno_id = $decoded->id;
                    $inscripto->materia_id = $materia->id;
                    date_default_timezone_set("America/Buenos_Aires");
                    $fecha = new Datetime();
                    $inscripto->date = $fecha->getTimestamp();

                    $materia->vacantes -= 1;

                    try {
                        $inscripto->save();
                        $materia->save();
                        $respuesta = Respuesta::crear(true, $decoded->nombre." inscripto", NULL);
                    } catch (\Throwable $th) {
                        $respuesta = Respuesta::crear(false, "Error al guardar cambios", NULL);
                    }
                } else {
                    $respuesta = Respuesta::crear(false, "No hay vacantes", NULL);
                }
            } else {
                $respuesta = Respuesta::crear(false, "No existe materia", NULL);
            }
        } else {
            $respuesta = Respuesta::crear(false, "No es alumno", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    public function verDatosEInscripcionesDeMateria (Request $request, Response $response, $args) {
        $headers = $request->getHeaders();
        $respuesta;

        $materias = Materia::select("materias.id", "materias.materia", "materias.vacantes", "materias.cuatrimestre", "users.nombre", "users.email")
                            ->join("users", "users.id", "materias.profesor_id")
                            ->get();

        if (isSet($materias)) {
            $cantidadDeMaterias = Materia::count();
            for ($f=0; $f<$cantidadDeMaterias; $f++) {
                $cantidadDeInscriptos = Inscripto::where("materia_id", $materias[$f]->id)
                                            ->count();
                $materias[$f]->cantidadDeInscriptos = $cantidadDeInscriptos;
            }
            $respuesta = Respuesta::crear(true, "Materia recibida", $materias);
        } else {
            $respuesta = Respuesta::crear(false, "No existe materia", NULL);
        }

        $stringDeRespuesta = json_encode($respuesta);
        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }

    ///////////////////////////
    /*
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
    */
}

?>