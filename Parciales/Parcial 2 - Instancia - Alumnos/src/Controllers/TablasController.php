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
                $table->increments("id_tipo");
                $table->string('tipo', 11)->unique();
                $table->timestamps();
            });
            $tipoUsuario1 = new TipoUsuario();
            $tipoUsuario1->tipo = "Cliente";
            $tipoUsuario1->save();
            $tipoUsuario2 = new TipoUsuario();
            $tipoUsuario2->tipo = "Veterinario";
            $tipoUsuario2->save();

            $stringDeRespuesta .= "tipos_usuarios creado<br>";
        } else {
            $stringDeRespuesta .= "tipos_usuarios ya existe<br>";
        }

        if (!Capsule::schema()->hasTable('usuarios')) {
            Capsule::schema()->create('usuarios', function ($table) {
                $table->increments('id_usuario');
                $table->integer('id_tipo')->unsigned();
                $table->foreign('id_tipo')->references('id_tipo')->on('tipos_usuarios');
                $table->string('email', 50)->unique();
                $table->string('password', 500);
                $table->timestamps();   // Este crea los created_at y updated_at
            });

            $stringDeRespuesta .= "usuarios creado<br>";
        } else {
            $stringDeRespuesta .= "usuarios ya existe<br>";
        }

        if (!Capsule::schema()->hasTable("mascotas")) {
            Capsule::schema()->create("mascotas", function ($table) {
                $table->increments("id_mascota");
                $table->string("nombre", 30);
                $table->integer("edad")->unsigned();
                $table->integer("id_cliente")->unsigned();
                $table->foreign('id_cliente')->references('id_usuario')->on("usuarios");
                $table->timestamps();   // Este crea los created_at y updated_at
            });

            $stringDeRespuesta .= "mascotas creado<br>";
        } else {
            $stringDeRespuesta .= "mascotas ya existe<br>";
        }

        if (!Capsule::schema()->hasTable("turnos")) {
            Capsule::schema()->create("turnos", function ($table) {
                $table->increments("id_turno");
                $table->integer("id_mascota")->unsigned();
                $table->foreign('id_mascota')->references('id_mascota')->on("mascotas");
                $table->date("fecha");
                $table->time("hora");
                $table->integer("id_veterinario")->unsigned();
                $table->foreign('id_veterinario')->references('id_usuario')->on("usuarios");
                $table->timestamps();   // Este crea los created_at y updated_at
            });

            $stringDeRespuesta .= "turnos creado<br>";
        } else {
            $stringDeRespuesta .= "turnos ya existe<br>";
        }

        $response->getBody()->write($stringDeRespuesta);
        return $response;
    }
}

?>