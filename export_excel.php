<?php
require 'vendor/autoload.php';
include 'conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Verificar si hay un nombre seleccionado en la solicitud GET
$nombreSeleccionado = isset($_GET['nombre_seleccionado']) ? $conec->real_escape_string($_GET['nombre_seleccionado']) : '';

// Crear la consulta basada en si hay un nombre seleccionado o no
if ($nombreSeleccionado) {
    // Consulta SQL para obtener datos filtrados por nombre
    $consulta = "
        SELECT historial.*, nombres.Nombre
        FROM historial
        JOIN nombres ON historial.NombreID = nombres.ID
        WHERE nombres.Nombre = '$nombreSeleccionado'
    ";
} else {
    // Consulta SQL para obtener todos los datos
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

// Crear un nuevo archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados
$headers = ['ID', 'Nombre', 'Fecha', 'Número de Cortesías', 'Clave de Rango Inicial', 'Clave de Rango Final'];
$sheet->fromArray($headers, NULL, 'A1');

// Agregar datos
$rowNumber = 2; // Empieza en la fila 2 después de los encabezados
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray([
        $row['ID'],
        $row['Nombre'],
        $row['Fecha'],
        $row['NumeroCortesias'],
        $row['RangoInicial'],
        $row['RangoFinal']
    ], NULL, "A$rowNumber");
    $rowNumber++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="historial.xlsx"');
header('Cache-Control: max-age=0');


// Escribir el archivo Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Cerrar la conexión
$conec->close();