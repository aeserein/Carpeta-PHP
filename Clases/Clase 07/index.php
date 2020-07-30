<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/Prueba");

$app->addErrorMiddleware(true, !false, !false);

$app->get('/persona/{id}/{numero}', function (Request $request, Response $response, array $args) {
    $array = array(
        "nombre" => "Cacho",
        "apellido" => "Castaña",
        "edad" => 420,
        "teAgarraConOtro" => true
    );

    //Path/{variablePorQueryString}/{otraVariablePorQueryString}?VariablePorGet=asd
    // Son 2 formas de pasar variables

    $queryArgs = $request->getQueryParams();    // Argumentos del GET
    $headers = $request->getHeaders();          // Argumentos del header
    $rta = array(
        "args"=>$args,          // Query string
        "query"=>$queryArgs,    // Argumentos del GET
        "headers"=>$headers     // Argumentos del header
    );

    $response->getBody()->write(json_encode($rta));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->post('/persona', function (Request $request, Response $response, array $args) {
    
    $body = $request->getParsedBody();      // Leo las variables pasadas por post
    $archivo = $request->getUploadedFiles();
    var_dump($archivo);

    $response->getBody()->write(json_encode($body));
    
    return $response;
});

$app->run();

/*  PARA QUE ANDE ESTA MIERDA

$app = AppFactory::create();
$app->setBasePath("/Prueba");

$app->run();
*/

/*
CAMPOS POR POST  ->     request->getParsedBody()
CAMPOS POR GET   ->     request->getQueryParams()
CAMPOS POR HEADER->     $request->getHeaders()
ARCHIVOS         ->     No hacemos andar la funcion de archivos,
                        para el parcial se hace por $_FILE
*/

// Devolver las cosas siempre como json
//      (La respuesta va como json)S