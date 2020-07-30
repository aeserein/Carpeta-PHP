<?php
namespace App\Middlewares;
use DateTime;
// use Psr\Http\Message\ResponseInterface as Response;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MiddlewareMayusculas {
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
        $res = json_decode($existingContent) ?? $existingContent;
        
        if (isset($res)) {
            //echo $res->objeto[0]->fecha;
            echo "<br><br>";
            var_dump($res);
            $today = new DateTime();
            //$res->objeto[0]->nombre = "NOMBRE MODIFICADO";
        } 

        /*
        if (isset($res) && isset($res->turnos)) {
            $today = new DateTime();
            foreach ($res->turnos as $turno) {
                $turnoFecha = new DateTime($turno->fecha);
                if ($today->getTimestamp() < $turnoFecha->getTimestamp()) {
                    $turno->nombre = strtoupper($turno->nombre);
                    $turno->nombre = strtoupper($turno->nombre);
                    if(isset($turno->veterinario)){
                        $turno->veterinario = strtoupper($turno->veterinario);
                    }
                }
            }
        } 
        */
        $response = new Response();
        $response->getBody()->write(json_encode($res));

        return $response;
    }
}

?>