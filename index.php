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

                  <!-- DIV para mostrar nombres -->
                <div class="container mb-3 mt-2">
                  <h2>Nombres</h2>
                  <div class="d-flex align-items-center">
                    <div class="dropdown me-3">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Seleccionar
                      </button>
                      <ul class="dropdown-menu" id="dropdownMenu" aria-labelledby="dropdownMenuButton">
                        <!-- Opciones serán cargadas por JavaScript -->
                      </ul>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Cantidad de Cortesías:</label>
                      <input type="text" class="form-control" id="cantidadCortesias" name="cantidad_cortesias">
                    </div>
                  </div>
                </div>
                
                <!-- Cuadro de texto para mostrar el nombre seleccionado -->
                <div class="mb-3">
                  <label class="form-label">Nombre Seleccionado: </label>
                  <input type="text" class="form-control" id="nombreSeleccionado" name="nombre_seleccionado" readonly>
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

  <!-- Script para cargar datos JSON y actualizar el dropdown -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      fetch('nombres.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Error en la red');
          }
          return response.json();
        })
        .then(data => {
          const dropdownMenu = document.getElementById('dropdownMenu');
          
          if (Array.isArray(data)) {
            // Limpiar dropdown antes de agregar nuevos elementos
            dropdownMenu.innerHTML = '';
            
            // Crear y agregar elementos de la lista
            data.forEach(nombre => {
              const li = document.createElement('li');
              li.innerHTML = `<a class="dropdown-item" onclick="setName('${nombre}')">${nombre}</a>`;
              dropdownMenu.appendChild(li);
            });
          } else {
            console.error('Los datos recibidos no son un array JSON válido:', data);
          }
        })
        .catch(error => console.error('Error al cargar los datos:', error));
    });

    function setName(name) {
      document.getElementById('nombreSeleccionado').value = name;
    }
  </script>
</body>

</html>