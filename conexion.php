<?php
$servername = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "pasaportes";

// Crear conexión
$conec = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conec->connect_error) {
    http_response_code(500); // Error de servidor
    echo json_encode(["error" => "Error de conexión: " . $conec->connect_error]);
    exit();
}
?>
