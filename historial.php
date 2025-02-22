<?php
// Configuración de la base de datos
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

// Verificar si hay un nombre seleccionado en la solicitud GET
$nombreSeleccionado = isset($_GET['nombre_seleccionado']) ? $conec->real_escape_string($_GET['nombre_seleccionado']) : '';

// Crear la consulta basada en si hay un nombre seleccionado o no
if ($nombreSeleccionado) {
    // Consulta SQL para unir las tablas y obtener el nombre completo
    $consulta = "
        SELECT historial.*, nombres.Nombre
        FROM historial
        JOIN nombres ON historial.NombreID = nombres.ID
        WHERE nombres.Nombre = '$nombreSeleccionado'
    ";
} else {
    // Consulta SQL sin filtro de nombre
    $consulta = "
        SELECT historial.*, nombres.Nombre
        FROM historial
        JOIN nombres ON historial.NombreID = nombres.ID
    ";
}

// Ejecutar la consulta
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
