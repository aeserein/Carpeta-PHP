<?php

namespace App\Models;

class TipoUsuario extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'tipos_usuarios';          // Acá declaro el nombre de la tabla
    protected $primaryKey = "id_tipo";   // Acá declaro el id si no es simplemente "id"
    public $timestamp = false;               // Acá pongo si quiero que use los timestamps

    //const CREATED_AT = "ts_creacion";       //
    //const UPDATED_AT = "ts_actualizacion";  //  Acá pongo los nombres de los timestamps si están cambiados
    //const DELETED_AT = "ts_borrado";        //
}

?>