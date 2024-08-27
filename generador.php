<?php

//require('fpdf.php'); // Incluye la biblioteca FPDF
//require_once "vendor/autoload.php"; // Incluimos el autoload, sive para generar los codigos  QR
//require "phpqrcode/qrlib.php";
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

/************************* BIBLIOTECAS PARA CODIGOS DE BARRAS ******************************************/
// # Indicamos que usaremos el namespace de BarcodeGeneratorPNG
// use Picqer\Barcode\BarcodeGeneratorJPG;
// # Crear generador
// $generador = new BarcodeGeneratorJPG();
/*******************************************************************************************************/
// Variables
$ID_Nom = $_POST['ID_Nom']; // ID del nombre seleccionado
$cantidad_cortesias = $_POST['cantidad_cortesias']; // Cantidad de cortesías
$fecha_actual = date('Y-m-d'); // Fecha actual

// Verifica que las variables no estén vacías
if (empty($ID_Nom) || empty($cantidad_cortesias)) {
    die("ID_Nom o cantidad_cortesias están vacíos.");
}

// Obtener la clave del nombre
$queryNombre = "SELECT Clave FROM nombres WHERE ID = ?";
$stmtNombre = $conec->prepare($queryNombre);
$stmtNombre->bind_param("i", $ID_Nom);
$stmtNombre->execute();
$resultNombre = $stmtNombre->get_result();

if ($resultNombre->num_rows === 0) {
    die("No se encontró el nombre con ID: $ID_Nom");
}

$rowNombre = $resultNombre->fetch_assoc();
$claveNombre = $rowNombre['Clave'];

// Consulta para obtener el último valor de clave final
$query = "SELECT `Clave de rango final` FROM historial WHERE NombreID = ? ORDER BY ID DESC LIMIT 1";
$stmt = $conec->prepare($query);
$stmt->bind_param("i", $ID_Nom);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error en la consulta de historial: " . $conec->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastFinalKey = $row['Clave de rango final'];
} else {
    $lastFinalKey = $claveNombre . '0000';
}

// Extraer el número de la clave
$lastNumber = (int)substr($lastFinalKey, strlen($claveNombre));

// Calcular el nuevo rango
$startNumber = $lastNumber + 1;
$endNumber = $startNumber + $cantidad_cortesias - 1;

// Convertir los números de nuevo a formato de clave
$claveRangoInicial = $claveNombre . str_pad($startNumber, 4, '0', STR_PAD_LEFT);
$claveRangoFinal = $claveNombre . str_pad($endNumber, 4, '0', STR_PAD_LEFT);

$valor_inicial =  str_pad($startNumber, 4, '0', STR_PAD_LEFT);
$valor_final = str_pad($endNumber, 4, '0', STR_PAD_LEFT);
// Mensajes de depuración
echo "Clave Nombre: $claveNombre<br>";
echo "Última Clave Final: $lastFinalKey<br>";
echo "Rango Inicial: $claveRangoInicial<br>";
echo "Rango Final: $claveRangoFinal<br>";

// Inserción en la base de datos
$queryInsert = "INSERT INTO historial (NombreID, Fecha, NumeroCortesias, `Clave de rango inicial`, `Clave de rango final`) 
                VALUES (?, ?, ?, ?, ?)";

$stmtInsert = $conec->prepare($queryInsert);
if ($stmtInsert === false) {
    die("Error al preparar la consulta: " . $conec->error);
}
$stmtInsert->bind_param("isiss", $ID_Nom, $fecha_actual, $cantidad_cortesias, $claveRangoInicial, $claveRangoFinal);

// echo  "valor inicial".$valor_inicial;
// echo  "valor final".$valor_final;
// for ($i = $valor_inicial; $i <= $valor_final; $i++) {
//         // Aplicar str_pad para que cada número tenga 4 dígitos con ceros a la izquierda
//         $numero_formateado = str_pad($i, 4, '0', STR_PAD_LEFT);
//         echo $numero_formateado . '<br>';
//     }

for($j=$valor_inicial;$j<=$valor_final;$j++){   
        $valorf=str_pad($j, 4, '0', STR_PAD_LEFT);

        echo $j . '<br>';
}
//$valor_inicial = $_POST['valor_inicial']; //Recibe el primer valor del intervalo
//$valor_final = $_POST['valor_final']; //Recibe el segundo valor del intervalo

// if ($valor_final < $valor_inicial) {
//         echo '<script type="text/javascript">alert("El valor final es mayor que el inicial");
//     window.location.href="index.php";
//     </script>';
// } else {
    if ($stmtInsert->execute()) {
        echo "Inserción realizada con éxito.";
    } else {
        echo "Error en la inserción: " . $stmtInsert->error;
    }
    
    $stmtInsert->close();
    $conec->close();
    
?>