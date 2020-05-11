<?php

/* JWT
    header.payload.signature
    Header = Información sobre el token
    Payload = Información
    Signature = ??

    Uso firebase con composer
    https://jwt.io/
*/

require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;

try {
    $key = "example_key";
    echo $key . "<br>";
    // Clave única

    // Se manda por header
    // Se lee con getAllHeaders();
    // El token va por el header de la consulta
    //      Se pone el campo en postman (le pongo variable token)
    $headers = getallheaders();
    $token = $headers["token"];

    $payload = array(
        "user" => "Juan",
        "email" => "juan@mail.com",
        "level" => 4
    );
    // Los campos se llaman claims
    // El jwt se manda solo en el login

    //$jwt = JWT::encode($payload, $key);
    $decoded = JWT::decode($token, $key, array('HS256'));

    //echo "JWT: $jwt<br><br>";
    print_r($decoded);

} catch (Throwable $th) {
    echo $th->getMessage();
}

?>