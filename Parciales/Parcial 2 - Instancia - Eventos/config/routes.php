<?php

use Slim\Routing\RouteCollectorProxy;

use App\Controllers\TablasController;
use App\Controllers\UsuarioController;
use App\Controllers\EventoController;

use App\Middlewares\BeforeMiddleware;
use App\Middlewares\MiddlewareSoloDeToken;
use App\Middlewares\MiddlewareDeFecha;
use App\Middlewares\MiddlewareRegistroEventos;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;

return function ($app) {
    $app->get("/crearTablas", TablasController::class . ":crearTablas");


    $app->post("/users", UsuarioController::class . ":registro");
    $app->post("/login", UsuarioController::class . ":login");

    $app->group("/eventos", function(RouteCollectorProxy $group) {
        $group->post("[/]", EventoController::class . ":registro")->add(new MiddlewareRegistroEventos());
        $group->get("[/]", EventoController::class . ":verTurnos");
        $group->put("[/{id}]", EventoController::class . ":modificarFecha")->add(new MiddlewareDeFecha());
    })->add(new MiddlewareSoloDeToken());


    $app->post("/test", function (Request $request, Response $response, $args) {
        $response->getBody()->write("test");
        return $response;
    })->add(new BeforeMiddleware());
}

?>