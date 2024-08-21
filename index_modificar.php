<?php
require_once "vendor/autoload.php"; // Incluimos el autoload, sive para generar los codigos  QR
require "phpqrcode/qrlib.php";
include 'conexion.php';
$area_qr = $_POST['area_qr'];
$tama_texto = $_POST['tama_texto'];
$posicion_horizontal_qr = $_POST['posicion_horizontal_qr'];
$posicion_vertical_qr = $_POST['posicion_vertical_qr'];
$posicion_horizontal_texto = $_POST['posicion_horizontal_texto'];
$posicion_vertical_texto = $_POST['posicion_vertical_texto'];
$texto1r = 'PSWAS1000';


if (isset($_POST['modificar'])) { //Si no recibe el boton de baja, no entra al ciclo


  $actualizar = "UPDATE posicion SET area_qr='$area_qr', 
  tam_texto='$tama_texto', 
  ejex_qr='$posicion_horizontal_qr', 
  ejey_qr='$posicion_vertical_qr', 
  ejey_texto='$posicion_vertical_texto', 
  ejex_texto='$posicion_horizontal_texto'";

  $resultado2 = mysqli_query($conec, $actualizar);

  if (mysqli_query($conec, $actualizar)) {

    header('index_modificar.php');
  } else {

    echo "Error: " . $actualizar . mysqli_error($conec);
  }
}


if (isset($_POST['probar'])) {

  //Declaramos una carpeta temporal para guardar la imágenes generadas
  $dir = 'temp/';

  //Si no existe la carpeta la creamos
  if (!file_exists($dir))
    mkdir($dir);

  //Declaramos la ruta y nombre del archivo a generar
  $filename = 'pruebaqr' . $texto1r . '.png';

  //Parámetros de Configuración

  $tamaño = 10; //Tamaño del Pixel
  $level = 'L'; //Precisión Baja
  $framSize = 3; //Tamaño de la parte blanca del codigo
  $contenido = $texto1r; //Texto contenido en el codigo QR

  //Enviamos los parámetros a la Función para generar código QR 
  QRcode::png($contenido, $filename, $level, $tamaño, $framSize);

  $rutaFuente = __DIR__ . "/" . "Victoria-Typewriter-Regular.ttf";

  $nombreImagenr = "frente.png"; //Plantilla delantera del pasaporte
  $nuevo_ancho = $area_qr; // Ancho del QR
  $nuevo_alto = $area_qr; // Alto del QR

  // Crear instancias de imágenes
  $origenr = imagecreatefrompng("pruebaqr" . $texto1r . ".png");
  //$origenr = imagecreatefrompng("codigos/test.png");
  $origenr_redimensionadar = imagescale($origenr, $area_qr, $area_qr);
  $destinor = imagecreatefrompng($nombreImagenr);
  $contenedorr = imagecreatetruecolor(imagesx($destinor), imagesy($destinor));

  $imagenr = imagecreatefrompng($nombreImagenr);
  $colorr = imagecolorallocate($imagenr, 116, 27, 26);




  $tamanior = $tama_texto;
  $angulor = 0;

  $xr = $posicion_horizontal_texto; //Eje X del texto
  $yr = $posicion_vertical_texto; //Eje Y del texto

  imagettftext($destinor, $tamanior, $angulor, $xr, $yr, $colorr, $rutaFuente, $texto1r);

  //ver el tamaño de la original
  // Copiar
  imagecopy($contenedorr, $destinor, 0, 0, 0, 0, imagesx($destinor), imagesy($destinor));
  imagecopy($contenedorr, $origenr_redimensionadar, $posicion_horizontal_qr, $posicion_vertical_qr, 0, 0, imagesx($origenr_redimensionadar), imagesy($origenr_redimensionadar)); //Valores para mover el codigo QR

  // Imprimir y liberar memoria
  header("Content-Type: image/png");

  $salidar = "prueba_pasaporte" . $texto1r . ".png";

  imagepng($contenedorr); //Mostrar Imagen, solo de descomenta para hacer prueba
  imagepng($contenedorr, $salidar);
}



?>

<!doctype html>

<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/estilos.css">
  <link rel="icon" href="./assets/img/icono.ico" type="image/x-icon">


  <title>PROBAR PLANTILLA NUEVA</title>
</head>

<body>

  <?php
  require 'conexion.php';
  include "navbar.php";


  ?>
  <!--------------------------------------- FORMULARIO BUSQUEDA DE EMPLEADOS ------------------------------------------>


  <form action="index_modificar.php" enctype="multipart/form-data" method="POST">
    <section class="">
      <div class="container py-5 h-100 fondo">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <h2 class="text-center">MODIFICAR VALORES</h2>
                <br><br>
                <?php
                //Consulta para obtener la posicion de los elementos
                $sql2 = "SELECT * FROM posicion";
                $result2 = mysqli_query($conec, $sql2);
                $mostrar2 = mysqli_fetch_array($result2);
                //Variables de tamaños
                $areaqr = $mostrar2['area_qr'];
                $tamtexto = $mostrar2['tam_texto'];
                $ejexqr = $mostrar2['ejex_qr'];
                $ejeyqr = $mostrar2['ejey_qr'];
                $ejextexto = $mostrar2['ejex_texto'];
                $ejeytexto = $mostrar2['ejey_texto'];
                ?>
                <div class="mb-3">
                  <label for="" class="form-label">AREA DEL QR</label>
                  <input type="text" class="form-control" value="<?php echo $areaqr; ?>" name="area_qr">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">TAMAÑO DEL TEXTO</label>
                  <input type="text" class="form-control" value="<?php echo $tamtexto; ?>" name="tama_texto">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">POSICION HORIZONTAL DEL QR</label>
                  <input type="text" name="posicion_horizontal_qr" value="<?php echo $ejexqr; ?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">POSICION VERTICAL DEL QR</label>
                  <input type="text" name="posicion_vertical_qr" value="<?php echo $ejeyqr; ?>" class="form-control">
                </div>


                <div class="mb-3">
                  <label for="" class="form-label">POSICION HORIZONTAL DEL TEXTO</label>
                  <input type="text" name="posicion_horizontal_texto" value="<?php echo $ejextexto; ?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">POSICION VERTICAL DEL TEXTO</label>
                  <input type="text" name="posicion_vertical_texto" value="<?php echo $ejeytexto; ?>" class="form-control">
                </div>


                <!-- BOTONES -->
                <button type="submit" name="modificar" class="btn btn-primary">MODIFICAR</button>
                &nbsp;
                <button type="submit" name="probar" class="btn btn-primary">PROBAR</button>
  


              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>