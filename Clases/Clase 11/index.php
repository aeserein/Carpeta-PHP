<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;  // Middleware
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . "/config/capsule.php";
require_once __DIR__ . "/models/Usuario.php";

$app = AppFactory::create();
$app->setBasePath("/Prueba");
$app->addErrorMiddleware(true, !false, !false);


//////// Middleware

$beforeMiddleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $existingContent = (string) $response->getBody();

    //$response = new Response();
    $response->getBody()->write('BEFORE' . $existingContent);

    return $response;
};

$afterMiddleware = function ($request, $handler) {
    $response = $handler->handle($request);
    $response->getBody()->write('AFTER');
    return $response;
};

$app->add($beforeMiddleware);
$app->add($afterMiddleware);

/////// Fin middleware

$app->get('/', function (Request $request, Response $response, $args) {
    $usuarios = Capsule::table('usuarios_utn')
        // --------------------------------------------
        //->where("legajo", ">","1235") // AND
        //->where("usuario", "AEEEA")
        // --------------------------------------------
        ->where("legajo", ">","1235") // OR
        ->orWhere("usuario", "Donaldo")
        // --------------------------------------------
        //->whereRaw("") // Acá consulta  escrita a mano

        ->select("usuario", "legajo")  // Restringir a estos campos

        //->first();    // Trae el objeto solo en vez un array
        ->get();        // Get trae un array
    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->get("/join", function (Request $request, Response $response, array $args) {
    $usuarios = Capsule::table('usuarios_utn')
        ->join("localidades", "localidades.id", "usuarios_utn.localidad")
        ->join("cuatrimestres", "cuatrimestres.id", "usuarios_utn.cuatrimestre")
        //join([Nombre de tabla], [primary key], [foreign key])
        ->select("usuarios_utn.id", "usuarios_utn.usuario", "usuarios_utn.legajo", "localidades.localidad", "cuatrimestres.nombre")
        ->where("usuarios_utn.id", "1")
        ->get();
    
    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->get("/aggregate", function (Request $request, Response $response, array $args) {
    $usuarios = Capsule::table('usuarios_utn')
        //->count() // Cuenta entradas en la tabla
        //->avg("legajo")    // Saca promedio de un valor
        //->max("legajo")    // Trae el máximo valor
        ->min("legajo");    // Trae el mínimo valor
    
    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->post("/insert", function (Request $request, Response $response, $args) {
    $usuarios = Capsule::table('usuarios_utn')
        ->insert([   // Lleva un array
            "usuario" => "Odio la universidad",
            "legajo" => 1238,
            "localidad" => 3,
            "cuatrimestre" => 1
        ]);

    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->post("/insertGetId", function (Request $request, Response $response, $args) {
    // La misma mierda pero devuelve el id del row creado
    $usuarios = Capsule::table('usuarios_utn')
        ->insertGetId([   // Lleva un array
            "usuario" => "Odio la universidad2",
            "legajo" => 1239,
            "localidad" => 3,
            "cuatrimestre" => 1
        ]);

    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->put("/update", function (Request $request, Response $response, $args) {
    // La misma mierda pero devuelve el id del row creado
    $usuarios = Capsule::table('usuarios_utn')
        ->where("id", 20)
        // ->increment("legajo") // Le sube 1
        // ->decrement("legajo") // Le baja 1
        ->update([
            "usuario" => "nombre modificado-",
            "legajo" => 1240
        ]);

    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->delete("/delete", function (Request $request, Response $response, $args) {
    // La misma mierda pero devuelve el id del row creado
    $usuarios = Capsule::table('usuarios_utn')
        ->where("id", 20)
        ->delete();

    $stringDeRespuesta = json_encode($usuarios);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

//////////////////////////////////////////////

$app->get('/orm', function (Request $request, Response $response, $args) {
    $usuario = Usuario::find(2);   // Busca y trae por campo "id"
    $usuario->usuario = "Nombre modificado"; // Le cambia un campo
    $guardo = $usuario->save();

    $stringDeRespuesta = json_encode([$usuario, "guardo" => $guardo]);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->get('/ormGetAll', function (Request $request, Response $response, $args) {
    $usuario = Usuario::all();   // Trae todo

    $stringDeRespuesta = json_encode($usuario);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->get('/ormTraerConWhere', function (Request $request, Response $response, $args) {
    try {   // firstOrFailt tira una excepción si no encuentra
        $usuario = Usuario::where('legajo', '>', 1235)->firstOrFail();
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }    

    $stringDeRespuesta = json_encode($usuario);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->post('/ormInsert', function (Request $request, Response $response, $args) {
    $usuario = new Usuario();
    $usuario->usuario = "Otro usuario orm";
    $usuario->legajo = 1242;
    $usuario->localidad = 2;
    $usuario->cuatrimestre = 2;
    $guardo = $usuario->save();

    $stringDeRespuesta = json_encode([$usuario, "guardo"=>$guardo]);

    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->post('/crearTabla', function (Request $request, Response $response, $args) {
    Capsule::schema()->create('tablaCreada', function ($table) {
        $table->increments('id');
        $table->string('email', 50)->unique();
        $table->string('pass', 20)->unique();
        $table->integer('unNumero');
        $table->timestamps();   // Este crea los created_at y updated_at

        if (Capsule::schema()->hasTable('tablaCreada')) {
            echo "tablaCreada existe<br>";
        }
        if (Capsule::schema()->hasTable('TABLA_MENEMISTA')) {
            echo "TABLA_MENEMISTA no existe, pero DEBERÍA<br>";
        }
    });

    $stringDeRespuesta = "MENEM";
    $response->getBody()->write($stringDeRespuesta);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->run();

/*  Terminar de ver cómo crear la tabla con lo del Schema

*/

?>