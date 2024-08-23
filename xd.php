// archivo historial.php

<?php
$conec = mysqli_connect('localhost', 'root', 'rootroot', 'pasaportes');

if (!$conec) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . mysqli_connect_error()]);
    exit();
}

$nombreSeleccionado = $_GET['nombre_seleccionado'] ?? '';
$consulta = "SELECT * FROM historial WHERE Nombre = '" . mysqli_real_escape_string($conec, $nombreSeleccionado) . "'";
$result = $conec->query($consulta);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta: " . $conec->error]);
    exit();
}

$historial = [];
while ($row = $result->fetch_assoc()) {
    $historial[] = $row;
}

echo json_encode($historial);

$conec->close();
?>
