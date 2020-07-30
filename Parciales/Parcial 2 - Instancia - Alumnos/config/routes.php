<?php

use Slim\Routing\RouteCollectorProxy;

use App\Controllers\MateriaController;
use App\Controllers\UsuarioController;

use App\Middlewares\BeforeMiddleware;
use App\Middlewares\MiddlewareRegistroMateria;
use App\Middlewares\MiddlewareSoloDeToken;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;

return function ($app) {
    
    $app->post("/usuario", UsuarioController::class . ":registro");
    $app->post("/login", UsuarioController::class . ":login");

    /////////////////////////////

    $app->group("/materias", function(RouteCollectorProxy $group) {
        $group->post("[/]", MateriaController::class . ":registro")->add(new MiddlewareRegistroMateria());
        $group->get("/{id}", MateriaController::class . ":verMaterias")->add(new MiddlewareSoloDeToken());
        $group->put("/{id}/{profesor}", MateriaController::class . ":asignarProfesor")->add(new MiddlewareSoloDeToken());
        $group->put("/{id}", MateriaController::class . ":inscribirAlumno")->add(new MiddlewareSoloDeToken());
        $group->get("[/]", MateriaController::class . ":verDatosEInscripcionesDeMateria")->add(new MiddlewareSoloDeToken());
    });

    $app->post("/test", function (Request $request, Response $response, $args) {
        $response->getBody()->write("test");
        return $response;
    })->add(new BeforeMiddleware());
}

?>