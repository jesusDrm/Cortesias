<?php

include 'conexion.php';

$sql = "SELECT Nombre FROM nombres";
$result = $conec->query($sql);

if ($result->num_rows > 0) {
    // Crear el menú desplegable
    $dropdownItems = '';
    while ($row = $result->fetch_assoc()) {
        $dropdownItems .= '<a class="dropdown-item" href="#">' . htmlspecialchars($row["Nombre"]) . '</a>';
    }
} else {
    $dropdownItems = '<a class="dropdown-item" href="#">No hay nombres disponibles</a>';
}

// Imprimir el HTML generado
echo $dropdownItems;

?>
