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
    // Clave única

    // Se manda por header
    // Se lee con getAllHeaders();
    // El token va por el header de la consulta
    //      Se pone el campo en postman (le pongo variable token)
    $headers = getallheaders();
    $token = $headers["token"];

    $payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,

        "user" => "Juan",
        "email" => "juan@mail.com",
        "level" => 5
    );
    // Los campos se llaman claims. Hay campos estándar. Se llaman
    // El jwt se manda solo en el login

    //$jwt = JWT::encode($payload, $key);
    $decoded = JWT::decode($token, $key, array('HS256'));

    //echo "JWT: $jwt<br><br>";
    print_r($decoded);

} catch (Throwable $th) {
    echo $th->getMessage();
}

?>