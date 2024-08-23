<?php
$conec = mysqli_connect('localhost', 'root', 'rootroot', 'pasaportes');

// Verificar si la conexión a la base de datos se realizó correctamente
if (!$conec) {
    http_response_code(500); // Error de servidor
    echo json_encode(["error" => "Error de conexión: " . mysqli_connect_error()]);
    exit();
}

// Verificar si hay un nombre seleccionado en la solicitud GET
$nombreSeleccionado = isset($_GET['nombre_seleccionado']) ? $conec->real_escape_string($_GET['nombre_seleccionado']) : '';

if ($nombreSeleccionado) {
    // Filtrar por nombre seleccionado
    $consulta = "SELECT * FROM historial WHERE Nombre = '$nombreSeleccionado'";
} else {
    // Obtener todos los registros
    $consulta = "SELECT * FROM historial";
}

$result = $conec->query($consulta);

// Verificar si la consulta fue exitosa
if (!$result) {
    http_response_code(500); // Error de servidor
    echo json_encode(["error" => "Error en la consulta: " . $conec->error]);
    exit();
}

// Crear un array para mostrar historial
$historial = [];
while ($row = $result->fetch_assoc()) {
    $historial[] = $row;
}

// Convertir el array a formato JSON
header('Content-Type: application/json');
echo json_encode($historial, JSON_PRETTY_PRINT);

// Cerrar la conexión
$conec->close();
?>
