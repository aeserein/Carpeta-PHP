<?php

class Archivo {

    static function leer($path, $modo = "r") {
        try {
            if (filesize($path) > 0) {
                $file = fopen($path, $modo);
                $dato = fread($file, filesize($path));
                fclose($file);
                return $dato;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    static function guardar($path, $dato, $modo = "w") {
        try {
            $file = fopen($path, $modo);
            fwrite($file, $dato);
            fclose($file);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    static function crearCarpeta($carpeta){
        if (!file_exists($carpeta)) {
            mkdir($carpeta);
        }
    }

    static function ponerMarcaDeAgua($imagen, $logo, $extension) {
        if ($extension == "jpg") {
            $extension = "jpeg";
        }
        $stamp = imagecreatefrompng("resources/logo.png");
        $im = ("imagecreatefrom" . $extension)($imagen);
        
        $marge_right = 20;
        $marge_bottom = 20;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

        ("image" . $extension)($im, $imagen);
    }
}

?>