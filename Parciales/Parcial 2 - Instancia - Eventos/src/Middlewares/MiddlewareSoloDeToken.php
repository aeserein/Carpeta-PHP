<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class MiddlewareSoloDeToken {
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response {
        $headers = $request->getHeaders();
        $todoPelotaJuez = true;

        $keyJwt = $_SERVER["KEY_JWT"];
        if (!isSet($headers["token"][0])) {
            $todoPelotaJuez = false;
        } else {
            try {
                $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));
            } catch (\Throwable $th) {
                $todoPelotaJuez = false;
            }
        }
        
        if ($todoPelotaJuez) {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $resp = new Response();
            $resp->getBody()->write($existingContent);
            return $resp;
        } else {
            $response = new Response();
            $respuesta = Respuesta::crear(false, "Error en el token", NULL);
            $stringDeRespuesta = json_encode($respuesta);
            $response->getBody()->write($stringDeRespuesta);
            return $response;
        }
    }
}

?>