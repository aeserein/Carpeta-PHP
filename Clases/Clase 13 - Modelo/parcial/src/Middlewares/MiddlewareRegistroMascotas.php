<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\Utils\Respuesta;

class MiddlewareRegistroMascotas {
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response {

        $body = $request->getParsedBody();
        $headers = $request->getHeaders();

        $key = $_SERVER["KEY_JWT"];
        $todoPelotaJuez = true;
        try {
            $decoded = JWT::decode($headers["token"][0], $key, array('HS256'));
        } catch (\Throwable $th) {
            $todoPelotaJuez = false;
        }

        if (!isSet($body["nombre"]) || !isSet($body["edad"]) || !isSet($headers["token"])
            || $decoded->tipo != "Cliente") {
            $todoPelotaJuez = false;
        }

        if ($todoPelotaJuez) {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $resp = new Response();
            $resp->getBody()->write($existingContent);
            return $resp;
        } else {
            $response = new Response();
            $respuesta = Respuesta::crear(false, "Error en los campos", NULL);
            $stringDeRespuesta = json_encode($respuesta);
            $response->getBody()->write($stringDeRespuesta);
            return $response;
        }
    }
}

?>