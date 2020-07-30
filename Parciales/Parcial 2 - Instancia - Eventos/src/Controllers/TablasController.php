<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\TipoUsuario;

class TablasController {

    public function crearTablas (Request $request, Response $response, $args) {
        $stringDeRespuesta = "Creando tablas...<br><br>";

        if (!Capsule::schema()->hasTable('tipos_usuarios')) {
            Capsule::schema()->create("tipos_usuarios", function ($table) {
                $table->increments("id");
                $table->string('tipo', 11)->unique();
                $table->timestamps();
            });
            $tipoUsuario1 = new TipoUsuario();
            $tipoUsuario1->tipo = "user";
            $tipoUsuario1->save();
            $tipoUsuario2 = new TipoUsuario();
            $tipoUsuario2->tipo = "admin";
            $tipoUsuario2->save();

            $stringDeRespuesta .= "tipos_usuarios creado<br>";
        } else {
            $stringDeRespuesta .= "tipos_usuarios ya existe<br>";
        }

        if (!Capsule::schema()->hasTable('users')) {
            Capsule::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->string('email', 50)->unique();
                $table->string('nombre', 100);
                $table->string('clave', 300);
                $table->integer('id_tipo')->unsigned();
                $table->foreign('id_tipo')->references('id')->on('tipos_usuarios');
                $table->timestamps();   // Este crea los created_at y updated_at
            });

            $stringDeRespuesta .= "users creado<br>";
        } else {
            $stringDeRespuesta .= "users ya existe<br>";
        }

        if (!Capsule::schema()->hasTable("eventos")) {
            Capsule::schema()->create("eventos", function ($table) {
                $table->increments("id");
                $table->datetime("fecha");
                $table->string('descripcion', 500);
                $table->integer('id_usuario')->unsigned();
                $table->foreign('id_usuario')->references('id')->on('users');
                $table->timestamps();   // Este crea los created_at y updated_at
            });

            $stringDeRespuesta .= "eventos creado<br>";
        } else {
            $stringDeRespuesta .= "eventos ya existe<br>";
        }

        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }
}

?>