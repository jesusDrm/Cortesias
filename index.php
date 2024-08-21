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


  <title>CORTESIAS</title>
</head>

<body>

  <?php
  require_once 'conexion.php';
  include "navbar.php";
  


  ?>
  <!--------------------------------------- FORMULARIO BUSQUEDA DE EMPLEADOS ------------------------------------------>


  <form action="generador.php" enctype="multipart/form-data" method="POST">
    <section class="">
      <div class="container py-5 h-100 fondo">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <h1 class="text-center">CORTESIAS</h1>

                <!-- DIV agregado -->
                  <div class="container mb-3 mt-2">
                  <h2>Nombres</h2>
                  <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Seleccionar
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <?php include 'nombres.php' 
                          
                          ?>
                      </div>
                  </div>
                   </div>

                <div class="mb-3">
                  <label class="form-label">DE PSWAS: </label>
                  <input type="text" class="form-control" name="valor_inicial" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">HASTA PSWAS: </label>
                  <input type="text" class="form-control" name="valor_final" required>
                </div>

                <button type="submit" class="btn btn-primary">GENERAR PASAPORTES</button>
                
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