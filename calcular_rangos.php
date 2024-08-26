<?php
$conec=mysqli_connect('localhost','root', 'rootroot', 'pasaportes');
$nombre = $_GET['nombre'];
$cantidad = intval($_GET['cantidad']);

// Consulta para obtener el último valor registrado en la tabla historial
$sql_last_entry = "SELECT `Clave de rango final` FROM historial ORDER BY `ID` DESC LIMIT 1";
$result_last_entry = mysqli_query($conec, $sql_last_entry);

if ($result_last_entry && mysqli_num_rows($result_last_entry) > 0) {
    $row_last_entry = mysqli_fetch_assoc($result_last_entry);
    $ultimo_rango_final = $row_last_entry['Clave de rango final'];

    // Extraer el número del último rango final
    preg_match('/\d+$/', $ultimo_rango_final, $matches);
    $ultimo_rango_final_num = intval($matches[0]);
} else {
    // Si no hay registro, comenzar desde el valor inicial
    $ultimo_rango_final_num = 0;
}

// Consulta del IDNombre y Clave asociada
$sql_clave = "SELECT Clave FROM nombres WHERE Nombre = '$nombre'";
$result = mysqli_query($conec, $sql_clave);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $clave = $row['Clave'];

    // Calcular el nuevo rango concatenando la clave
    $clave_rango_inicial = $clave . str_pad($ultimo_rango_final_num + 1, 4, '0', STR_PAD_LEFT);
    $clave_rango_final = $clave . str_pad($ultimo_rango_final_num + $cantidad, 4, '0', STR_PAD_LEFT);

    echo json_encode(['rangoInicial' => $clave_rango_inicial, 'rangoFinal' => $clave_rango_final]);
} else {
    echo json_encode(['error' => 'Nombre no encontrado']);
}

mysqli_close($conec);
?>