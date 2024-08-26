<?php

//require('fpdf.php'); // Incluye la biblioteca FPDF
//require_once "vendor/autoload.php"; // Incluimos el autoload, sive para generar los codigos  QR
//require "phpqrcode/qrlib.php";
include 'conexion.php';

/************************* BIBLIOTECAS PARA CODIGOS DE BARRAS ******************************************/
// # Indicamos que usaremos el namespace de BarcodeGeneratorPNG
// use Picqer\Barcode\BarcodeGeneratorJPG;
// # Crear generador
// $generador = new BarcodeGeneratorJPG();
/*******************************************************************************************************/


// Recibir el nombre seleccionado y cantidad de cortesías del formulario
$nombreSeleccionado = $_POST['nombre_seleccionado'];
$cantidad_cortesias = $_POST['cantidad_cortesias'];
$fecha_actual = date("Y-m-d");

// 1. Obtener el último valor registrado
$sql_last_entry = "SELECT `Clave de rango final` FROM historial ORDER BY `ID` DESC LIMIT 1";
$result_last_entry = mysqli_query($conec, $sql_last_entry);

if($result_last_entry && mysqli_num_rows($result_last_entry) > 0){
    $row_last_entry = mysqli_fetch_assoc($result_last_entry);
    $ultimo_rango_final = $row_last_entry['Clave de rango final'];

    // Extraer el número del último rango final
    preg_match('/\d+$/', $ultimo_rango_final, $matches);
    $ultimo_rango_final_num = intval($matches[0]);

} else {
    // Si no hay registro, comenzar desde el valor inicial
    $ultimo_rango_final_num = 0;
}

// 2. Consulta del IDNombre y Clave asociada
$sql_clave = "SELECT ID, Clave FROM nombres WHERE Nombre = '$nombreSeleccionado'";
$result = mysqli_query($conec, $sql_clave);

if($result && mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $ID_Nom = $row['ID'];
    $clave = $row['Clave'];

    // 3. Calcular el nuevo rango concatenando la clave
    $clave_rango_inicial = $clave . str_pad($ultimo_rango_final_num + 1, 4, '0', STR_PAD_LEFT);
    $clave_rango_final = $clave . str_pad($ultimo_rango_final_num + $cantidad_cortesias, 4, '0', STR_PAD_LEFT);

    echo "ID Nombre: " . $ID_Nom . "<br>";
    echo "Clave: " . $clave . "<br>";
    echo "Clave de rango inicial: " . $clave_rango_inicial . "<br>";
    echo "Clave de rango final: " . $clave_rango_final . "<br>";

    // 4. Ingreso de datos para la tabla historial
    $insert_historial = "INSERT INTO historial (NombreID, Fecha, NumeroCortesias, `Clave de rango inicial`, `Clave de rango final`) 
                         VALUES ('$ID_Nom', '$fecha_actual', '$cantidad_cortesias', '$clave_rango_inicial', '$clave_rango_final')";

    // Ejecutar la consulta
    if (mysqli_query($conec, $insert_historial)){
        echo "Registro añadido correctamente a la tabla historial.";
    } else {
        echo "Error: " . mysqli_error($conec); 
    }

} else {
    echo "No se encontró el nombre seleccionado.";
}

mysqli_close($conec);        


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


