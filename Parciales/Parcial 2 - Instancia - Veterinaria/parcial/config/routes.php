<?php

use Slim\Routing\RouteCollectorProxy;

use App\Controllers\TablasController;
use App\Controllers\MascotaController;
use App\Controllers\UsuarioController;
use App\Controllers\TurnosController;

use App\Middlewares\BeforeMiddleware;
use App\Middlewares\MiddlewareRegistroMascotas;
use App\Middlewares\MiddlewareRegistroTurnos;
use App\Middlewares\MiddlewareVerTurnos;
use App\Middlewares\MiddlewareMayusculas;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;

return function ($app) {
    $app->get("/crearTablas", TablasController::class . ":crearTablas");

    $app->post("/registro", UsuarioController::class . ":registro");
    $app->post("/login", UsuarioController::class . ":login");
    $app->post("/tipo_mascota", MascotaController::class . ":registrarTipo");

    $app->group("/mascotas", function(RouteCollectorProxy $group) {
        $group->post("[/]", MascotaController::class . ":registro")->add(new MiddlewareRegistroMascotas());
        $group->get("/{id_mascota}", MascotaController::class . ":verHistorialDeMascota");
    });
    
    $app->group("/turnos", function(RouteCollectorProxy $group) {
        $group->post("/mascota", TurnosController::class . ":registro")->add(new MiddlewareRegistroTurnos());
        $group->get("/{id_usuario}", TurnosController::class . ":verTurnos")->add(new MiddlewareVerTurnos())->add(new MiddlewareMayusculas());
    });

    $app->post("/test", function (Request $request, Response $response, $args) {
        $response->getBody()->write("test");
        return $response;
    })->add(new BeforeMiddleware());
}

?>