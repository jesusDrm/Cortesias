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

// Mensajes de depuración
echo "Clave Nombre: $claveNombre<br>";
echo "Última Clave Final: $lastFinalKey<br>";
echo "Rango Inicial: $claveRangoInicial<br>";
echo "Rango Final: $claveRangoFinal<br>";

// Inserción en la base de datos
$queryInsert = "INSERT INTO historial (NombreID, Fecha, NumeroCortesias, `Clave de rango inicial`, `Clave de rango final`) 
                VALUES (?, ?, ?, ?, ?)";

$stmtInsert = $conec->prepare($queryInsert);
$stmtInsert->bind_param("isiss", $ID_Nom, $fecha_actual, $cantidad_cortesias, $claveRangoInicial, $claveRangoFinal);

if ($stmtInsert->execute()) {
    echo "Datos insertados correctamente";
} else {
    echo "Error al insertar datos: " . $stmtInsert->error;
}

// Cerrar la conexión
$conec->close();

/*

//$valor_inicial = $_POST['valor_inicial']; //Recibe el primer valor del intervalo
//$valor_final = $_POST['valor_final']; //Recibe el segundo valor del intervalo

$valor_inicial="1";
$valor_final=$cantidad_cortesias;
if ($valor_final < $valor_inicial) {
        echo '<script type="text/javascript">alert("El valor final es mayor que el inicial");
    window.location.href="index.php";
    </script>';
} else {

        for ($valorf = $valor_inicial; $valorf <= $valor_final; $valorf++) {

                //Declaramos una carpeta temporal para guardar la imágenes generadas
                $dir = 'temp/';

                //Si no existe la carpeta la creamos
                if (!file_exists($dir))
                        mkdir($dir);

                //Declaramos la ruta y nombre del archivo a generar
                $filename = 'codigos/PSWAS' . $valorf . '.png';

                //Parámetros de Configuración

                $tamaño = 10; //Tamaño del Pixel
                $level = 'L'; //Precisión Baja
                $framSize = 3; //Tamaño de la parte blanca del codigo
                $contenido = "PSWAS" . $valorf; //Texto contenido en el codigo QR

                //Enviamos los parámetros a la Función para generar código QR 
                QRcode::png($contenido, $filename, $level, $tamaño, $framSize);


                /**************************** GENERADOR DE CODIGO DE BARRAS EN CASO DE SER NECESARIO ******************************/

                // # Indicamos que usaremos el namespace de BarcodeGeneratorPNG
                // use Picqer\Barcode\BarcodeGeneratorJPG;
                // # Crear generador
                // $generador = new BarcodeGeneratorJPG();
                // # Ajustes
                // $texto = $valorf;
                // $tipo = $generador::TYPE_CODE_39;
                // # Generar imagen
                // $imagen = $generador->getBarcode($texto, $tipo, 2, 81);
                // # Guardar la imagen en un archivo
                // file_put_contents('codigos/PSWAS'.$texto.'.png', $imagen);

                /*****************************************************************************************************************/

                //date_default_timezone_set('America/Mexico_City');


                //$rutaFuente = __DIR__ . "/" . "Victoria-Typewriter-Regular.ttf";
                /****************************************** PARTE FRONTAL DEL PASAPORTE ******************************************************/
                //$nombreImagenf = "reverso.png"; //Plantilla trasera del pasaporte

                // Se crea instancias de imágenes
                //$destinof = imagecreatefrompng($nombreImagenf);
                //$contenedorf = imagecreatetruecolor(imagesx($destinof), imagesy($destinof));

                // Se genera contenedor con imagen dentro
                //imagecopy($contenedorf, $destinof, 0, 0, 0, 0, imagesx($destinof), imagesy($destinof));

                // Imprimir y liberar memoria
                /*
                header("Content-Type: image/png");
                $salidaf = "pasaportes/PSWAS" . $valorf . "_Reverso.png";
*/
              //imagejpeg($contenedorf);  //Mostrar imagen, solo se descomenta para hacer pruebas

//                imagepng($contenedorf, $salidaf);


                /********************************************* PARTE REVERSO DEL PASAPORTE ****************************************************/

    
/*
                //Consulta para obtener la posicion de los elementos
                $sql2 = "SELECT * FROM posicion";
                $result2 = mysqli_query($conec, $sql2);
                $mostrar2 = mysqli_fetch_array($result2);
                //Variables de tamaños
                $area_qr = $mostrar2['area_qr'];
                $tam_texto = $mostrar2['tam_texto'];
                $ejex_qr = $mostrar2['ejex_qr'];
                $ejey_qr = $mostrar2['ejey_qr'];
                $ejex_texto = $mostrar2['ejex_texto'];
                $ejey_texto = $mostrar2['ejey_texto'];
               


                $nombreImagenr = "frente.png"; //Plantilla delantera del pasaporte
                $nuevo_ancho = $ancho; // Ancho del QR
                $nuevo_alto = $alto; // Alto del QR

                // Crear instancias de imágenes
                $origenr = imagecreatefrompng("codigos/PSWAS" . $valorf . ".png");
                //$origenr = imagecreatefrompng("codigos/test.png");
                $origenr_redimensionadar = imagescale($origenr, $area_qr, $area_qr);
                $destinor = imagecreatefrompng($nombreImagenr);
                $contenedorr = imagecreatetruecolor(imagesx($destinor), imagesy($destinor));

                $imagenr = imagecreatefrompng($nombreImagenr);
                $colorr = imagecolorallocate($imagenr, 116, 27, 26);


                $texto1r = "PSWAS" . $valorf;

                $tamanior = $tam_texto;
                $angulor = 0;

                $xr = $ejex_texto; //Eje X del texto
                $yr = $ejey_texto; //Eje Y del texto

                imagettftext($destinor, $tamanior, $angulor, $xr, $yr, $colorr, $rutaFuente, $texto1r);

                //ver el tamaño de la original
                // Copiar
                imagecopy($contenedorr, $destinor, 0, 0, 0, 0, imagesx($destinor), imagesy($destinor));
                imagecopy($contenedorr, $origenr_redimensionadar, $ejex_qr, $ejey_qr, 0, 0, imagesx($origenr_redimensionadar), imagesy($origenr_redimensionadar)); //Valores para mover el codigo QR

                // Imprimir y liberar memoria
                header("Content-Type: image/png");

                $salidar = "pasaportes/PSWAS" . $valorf . "_Frente.png";
     
                //imagepng($contenedorr); //Mostrar Imagen, solo de descomenta para hacer prueba
                imagepng($contenedorr, $salidar);
        }
        /*********************************************** GENERAR PDF ************************************************************/
/*
        // Ruta de la carpeta con las imágenes con los pasaportes echos
        $carpeta_imagenes = 'pasaportes/';

        // Obtén la lista de todos los archivos en la carpeta
        $archivos = scandir($carpeta_imagenes);

        // Crea un nuevo objeto FPDF
        $pdf = new FPDF();

        // Recorre los archivos en la carpeta
        foreach ($archivos as $archivo) {
                // Ignora los directorios y archivos ocultos
                if ($archivo != "." && $archivo != "..") {
                        // Ruta completa de la imagen
                        $ruta_imagen = $carpeta_imagenes . $archivo;

                        // Obtén las dimensiones de la imagen para que la hoja se ajuste al tamaño del pasaporte
                        list($ancho, $alto) = getimagesize($ruta_imagen);

                        // Configura el tamaño de la página según las dimensiones de la imagen del pasaporte
                        $pdf->AddPage('P', array($ancho, $alto));

                        // Inserta el pasaporte en la pagina
                        $pdf->Image($ruta_imagen, 0, 0, $ancho, $alto);
                }
        }

        // Descarga el archivo desde el navegador
        $pdf->Output('PSWAS' . $valor_inicial . ' - PSWAS' . $valor_final . '.pdf', 'D');

        /************************************** BORRADO DE ARCHIVOS BASURA ************************************************/
/*
        //Borra todos los codigos QR, que se guardaron en la carpeta codigos, al terminar el proceso
        $files = glob('codigos/*'); //obtenemos todos los nombres de los archivos en la carpeta codigos
        foreach ($files as $file) {
                if (is_file($file))
                        unlink($file); //Se elimina cada archivo que encuentre
        }

        //Borra todas los pasaportes, que se guardaron en la carpeta pasaportes para generar el PDF, al terminar el proceso
        $files = glob('pasaportes/*'); //obtenemos todos los nombres de los archivos en la carpeta pasaportes
        foreach ($files as $file) {
                if (is_file($file))
                        unlink($file); //Se elimina cada archivo que encuentre
        }
                        
}
*/
?>