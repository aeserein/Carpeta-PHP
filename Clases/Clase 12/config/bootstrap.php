<?php

require_once __DIR__ . "/../vendor/autoload.php";
use Slim\Factory\AppFactory;
use Config\Database;
use Psr\Http\Message\ServerRequestInterface;

new Database();
$app = AppFactory::create();
$app->setBasePath("/Prueba/public");
$app->addErrorMiddleware(true, !false, !false);
$app->addRoutingMiddleware();

$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    // Acá el mensaje de error para rutas cracheadas
    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    return $response;
};

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

// Registrar rutas
(require_once __DIR__."/routes.php")($app);

// Registrar middlewares
(require_once __DIR__."/middlewares.php")($app);

return $app;

?>