<?php

namespace App\Models;

class TipoMascota extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'tipo_mascota';          // Acá declaro el nombre de la tabla
    protected $primaryKey = "id";   // Acá declaro el id si no es simplemente "id"
    public $timestamps = false;               // Acá pongo si quiero que use los timestamps

    //const CREATED_AT = "ts_creacion";       //
    //const UPDATED_AT = "ts_actualizacion";  //  Acá pongo los nombres de los timestamps si están cambiados
    //const DELETED_AT = "ts_borrado";        //
}

?>