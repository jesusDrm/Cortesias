<?php
$conec = mysqli_connect('localhost', 'root', 'rootroot', 'pasaportes');
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$ID_Nom = $_POST['ID_Nom'] ?? ''; // ID del nombre
$cantidad = intval($_POST['cantidad_cortesias'] ?? 0);

// Verifica que las variables no estén vacías
if (empty($ID_Nom) || $cantidad <= 0) {
    echo json_encode([
        'error' => 'ID o cantidad inválidos.',
        'ID_Nom' => $ID_Nom,
        'cantidad' => $cantidad
    ]);
    exit();
}

// Obtener la clave del nombre seleccionado usando ID
$queryClave = "SELECT Clave FROM nombres WHERE ID = ?";
$stmtClave = $conec->prepare($queryClave);
$stmtClave->bind_param("i", $ID_Nom);
$stmtClave->execute();
$resultClave = $stmtClave->get_result();

if ($resultClave && $resultClave->num_rows > 0) {
    $rowClave = $resultClave->fetch_assoc();
    $clave = $rowClave['Clave'];

    // Obtener el último rango final de la tabla historial
    $queryLastEntry = "SELECT `Clave de rango final` FROM historial ORDER BY ID DESC LIMIT 1";
    $stmtLastEntry = $conec->prepare($queryLastEntry);
    $stmtLastEntry->execute();
    $resultLastEntry = $stmtLastEntry->get_result();

    if ($resultLastEntry && $resultLastEntry->num_rows > 0) {
        $rowLastEntry = $resultLastEntry->fetch_assoc();
        $ultimoRangoFinal = $rowLastEntry['Clave de rango final'];

        // Extraer el prefijo y el número del rango final
        preg_match('/^([A-Z]+)(\d+)$/', $ultimoRangoFinal, $matches);
        $prefijo = $matches[1] ?? $clave;
        $ultimoRangoFinalNum = isset($matches[2]) ? intval($matches[2]) : 0;
    } else {
        $prefijo = $clave;
        $ultimoRangoFinalNum = 0;
    }

    // Calcular el nuevo rango
    $claveRangoInicial = $prefijo . str_pad($ultimoRangoFinalNum + 1, 4, '0', STR_PAD_LEFT);
    $claveRangoFinal = $prefijo . str_pad($ultimoRangoFinalNum + $cantidad, 4, '0', STR_PAD_LEFT);

    echo json_encode(['rangoInicial' => $claveRangoInicial, 'rangoFinal' => $claveRangoFinal]);
} else {
    echo json_encode(['error' => 'ID no encontrado']);
}

$conec->close();
?>
