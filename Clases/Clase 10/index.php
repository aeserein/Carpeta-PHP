<?php

require_once "./alumno.php";

$operacion = "update";

if ($operacion == "select") {
    echo "Select<br>";
    try {

        $id = "a";
        // Las variables que va a pasar el usuario
    
        $connectionString = "mysql:host=localhost; dbname=mibasededatos";
        $user = "root";
        $pass = "";
        
        $pdo = new PDO($connectionString, $user, $pass,
                       array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    
        $consultaString = "SELECT * FROM alumnos_utn WHERE id = :id";
        $consulta = $pdo->prepare($consultaString);
        $consulta->bindParam("id", $id, PDO::PARAM_INT);
        $consulta->execute();
    
        /*
        $consultaString = "SELECT * FROM alumnos_utn WHERE id = ?";
        Signo "?" en vez de los valores
    
        $consulta = $pdo->prepare($consultaString);
    
        $consulta->execute(array($id));
        Sino array con los campos que se usan en la consulta
        */
    
        $objeto = $consulta->fetchAll(PDO::FETCH_CLASS, "Alumno");
        var_dump($objeto);
    
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
} else if ($operacion == "delete") {
    echo "Delete<br>";
    try {
        $id = "7";
        // Las variables que va a pasar el usuario

        $connectionString = "mysql:host=localhost; dbname=mibasededatos";
        $user = "root";
        $pass = "";
        
        $pdo = new PDO($connectionString, $user, $pass,
                    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


        $consultaString = "DELETE FROM alumnos_utn WHERE id = :id";
        $consulta = $pdo->prepare($consultaString);
        $consulta->bindParam("id", $id, PDO::PARAM_INT);
        $consulta->execute();

        /*
        $consultaString = "SELECT * FROM alumnos_utn WHERE id = ?";
        Signo "?" en vez de los valores

        $consulta = $pdo->prepare($consultaString);

        $consulta->execute(array($id));
        Sino array con los campos que se usan en la consulta
        */

        $objeto = $consulta->rowCount();
        var_dump($objeto);

    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
} else if ($operacion == "insert") {
    echo "Insert<br>";
    try {
        $alumno = "Rigoberto";
        $legajo = 1237;
        $localidad = 3;
        $cuatrimestre = 1;
        // Las variables que va a pasar el usuario

        $connectionString = "mysql:host=localhost; dbname=mibasededatos";
        $user = "root";
        $pass = "";
        
        $pdo = new PDO($connectionString, $user, $pass,
                    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


        $consultaString = "INSERT INTO alumnos_utn (alumno, legajo, localidad, cuatrimestre) VALUES (:alumno, :legajo, :localidad, :cuatrimestre)";
        $consulta = $pdo->prepare($consultaString);
        $consulta->bindParam("alumno", $alumno, PDO::PARAM_STR);
        $consulta->bindParam("legajo", $legajo, PDO::PARAM_INT);
        $consulta->bindParam("localidad", $localidad, PDO::PARAM_INT);
        $consulta->bindParam("cuatrimestre", $cuatrimestre, PDO::PARAM_INT);
        $consulta->execute();

        /*
        $consultaString = "SELECT * FROM alumnos_utn WHERE id = ?";
        Signo "?" en vez de los valores

        $consulta = $pdo->prepare($consultaString);

        $consulta->execute(array($id));
        Sino array con los campos que se usan en la consulta
        */

        $objeto = $pdo->lastInsertId();
        var_dump($objeto);

    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
} else if ($operacion == "update") {
    echo "Update<br>";
    try {
        $alumno = "AEEEA";
        $id = 13;
        // Las variables que va a pasar el usuario

        $connectionString = "mysql:host=localhost; dbname=mibasededatos";
        $user = "root";
        $pass = "";
        
        $pdo = new PDO($connectionString, $user, $pass,
                    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


        $consultaString = "UPDATE alumnos_utn SET alumno = :alumno WHERE id = :id";
        $consulta = $pdo->prepare($consultaString);
        $consulta->bindParam("alumno", $alumno, PDO::PARAM_STR);
        $consulta->bindParam("id", $id, PDO::PARAM_INT);
        $consulta->execute();

        /*
        $consultaString = "SELECT * FROM alumnos_utn WHERE id = ?";
        Signo "?" en vez de los valores

        $consulta = $pdo->prepare($consultaString);

        $consulta->execute(array($id));
        Sino array con los campos que se usan en la consulta
        */

        $objeto = $consulta->rowCount();
        var_dump($objeto);

    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
}


/*  fetch_assoc Array asociativo
    fetch_num   Array indexado
    fetch_both  Array con ambos accesos
    fetch_all   Array con todas las filas
    fetch_obj   Objeto con los campos seteados

    Pasos
        1) Instanciar una conexión
            (crear el pdo o llamar al get del singleton)
        2) Preparar la consulta
        3) Ejecutarla
        4) Fetch

*/

?>