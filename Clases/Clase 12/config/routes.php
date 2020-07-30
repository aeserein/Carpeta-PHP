<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AlumnoController;
use App\Middlewares\BeforeMiddleware;

return function ($app) {
    $app->get("/", function (Request $request, Response $response, $args) {
        $response->getBody()->write("En el get fuera del grupo");
        return $response;
    });
    $app->group("/alumnos", function(RouteCollectorProxy $group) {
        $group->get("[/]", AlumnoController::class . ":getAll");
        $group->get("/:id", AlumnoController::class . ":getAll");
        $group->post("[/]", AlumnoController::class . ":getAll");
        $group->put("/:id", AlumnoController::class . ":getAll");
        $group->delete("/:id", AlumnoController::class . ":getAll");
    })->add(new BeforeMiddleware());
    
    $app->group("/materias", function(RouteCollectorProxy $group) {
        $group->get("[/]", AlumnoController::class . ":getAll");
        $group->get("/:id", AlumnoController::class . ":getAll");
        $group->post("[/]", AlumnoController::class . ":getAll");
        $group->put("/:id", AlumnoController::class . ":getAll");
        $group->delete("/:id", AlumnoController::class . ":getAll");
    });
}

?>