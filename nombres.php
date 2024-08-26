<?php
// nombres.php

$conec = mysqli_connect('localhost', 'root', 'rootroot', 'pasaportes');

// Verificar si la conexión a la base de datos se realizó correctamente
if (!$conec) {
    http_response_code(500); // Error de servidor
    echo json_encode(["error" => "Error de conexión: " . mysqli_connect_error()]);
    exit();
}

// Consultar nombres de la Familia Camacho desde la tabla nombres.
$consulta = "SELECT ID, Nombre FROM nombres";
$result = $conec->query($consulta);

// Verificar si la consulta fue exitosa
if (!$result) {
    http_response_code(500); // Error de servidor
    echo json_encode(["error" => "Error en la consulta: " . $conec->error]);
    exit();
}

// Crear un array para almacenar los nombres
$nombres = [];
while ($row = $result->fetch_assoc()) {
    $nombres[] = $row; // Incluye ID y Nombre
}

// Convertir el array a formato JSON
header('Content-Type: application/json');
echo json_encode($nombres, JSON_PRETTY_PRINT);

// Cerrar la conexión
$conec->close();
?>
