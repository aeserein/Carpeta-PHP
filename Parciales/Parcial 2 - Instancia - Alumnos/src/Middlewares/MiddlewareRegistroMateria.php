<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Utils\Respuesta;
use \Firebase\JWT\JWT;

class MiddlewareRegistroMateria {
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
        $todoPelotaJuez = true;

        if (!isSet($body["materia"]) || !isSet($body["cuatrimestre"]) ||
            !isSet($body["vacantes"]) || !isSet($body["profesor"])) {
            
            $todoPelotaJuez = false;
        }

        $keyJwt = $_SERVER["KEY_JWT"];
        if (!isSet($headers["token"][0])) {
            $todoPelotaJuez = false;
        } else {
            try {
                $decoded = JWT::decode($headers["token"][0], $keyJwt, array('HS256'));
                if ($decoded->tipo != 3) {
                    $todoPelotaJuez = false;
                }
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
            $respuesta = Respuesta::crear(false, "Error en los campos", NULL);
            $stringDeRespuesta = json_encode($respuesta);
            $response->getBody()->write($stringDeRespuesta);
            return $response;
        }
    }
}

?>