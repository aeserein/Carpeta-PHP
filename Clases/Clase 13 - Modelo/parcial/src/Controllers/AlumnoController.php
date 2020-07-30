<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Alumno;

class AlumnoController {
    public function getAll (Request $request, Response $response, $args) {
        echo "En GET all<br><br>";
        $alumnos = Alumno::all();

        $stringDeRespuesta = json_encode($alumnos);

        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }
    public function getOne (Request $request, Response $response, $args) {
        $response->getBody()->write("En GET One");
        return $response;
    }
    public function add (Request $request, Response $response, $args) {
        $response->getBody()->write("En add");
        return $response;
    }
    public function update (Request $request, Response $response, $args) {
        $response->getBody()->write("En update");
        return $response;
    }
    public function delete (Request $request, Response $response, $args) {
        $response->getBody()->write("En delete");
        return $response;
    }
}

?>