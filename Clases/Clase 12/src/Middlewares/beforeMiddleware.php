<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class BeforeMiddleware {
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
        
        /*
            Acá valido token

            Si tengo que hacer más de un middleware son diferentes archivos
            Hacer un middleware diferente para cada cosa que haya que validar
            1:57 el demo de las llamadas a middlewares en cadena
            Hacer logs
        */

        $response = new Response();
        if (!true) {
            $response->getBody()->write($existingContent);
        } else {
            $response->getBody()->write("Lo hice pero se me crachea");
        }
    
    
        return $response;
    }
}

?>