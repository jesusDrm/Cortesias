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
                  <!-- Cuadro de texto para mostrar el nombre seleccionado -->
                <div class="mb-3">
                  <label class="form-label">Nombre Seleccionado: </label>
                  <input type="text" class="form-control" id="nombreSeleccionado" name="nombre_seleccionado" readonly>
                  <input type="hidden" id="ID_Nom" name="ID_Nom">
                </div>   
                </div>

                <div class="mb-3">
                <label class="form-label">Cantidad de Cortesías:</label>
                <input type="text" class="form-control" id="cantidadCortesias" name="cantidad_cortesias" oninput="actualizarRangos()" required>
              </div>
                

                <div class="mb-3">
                  <label class="form-label">DE PSWAS: </label>
                  <input type="text" class="form-control" id="valorInicial" name="valor_inicial">
                </div>

                <div class="mb-3">
                  <label class="form-label">HASTA PSWAS: </label>
                  <input type="text" class="form-control" id="valorFinal" name="valor_final" >
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
        data.forEach(item => {
          const li = document.createElement('li');
          li.innerHTML = `<a class="dropdown-item" onclick="setName('${item.Nombre}', ${item.ID})">${item.Nombre}</a>`;
          dropdownMenu.appendChild(li);
        });
      } else {
        console.error('Los datos recibidos no son un array JSON válido:', data);
      }
    })
    .catch(error => console.error('Error al cargar los datos:', error));
});

function setName(name, id) {
  document.getElementById('nombreSeleccionado').value = name;
  document.getElementById('ID_Nom').value = id;
  actualizarRangos();
}

function actualizarRangos() {
  const nombreSeleccionado = document.getElementById('nombreSeleccionado').value;
  const cantidadCortesias = document.getElementById('cantidadCortesias').value;
  const idNom = document.getElementById('ID_Nom').value;

  if (nombreSeleccionado && cantidadCortesias && idNom) {
    fetch('calcular_rangos.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        ID_Nom: idNom,
        cantidad_cortesias: cantidadCortesias
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data && data.rangoInicial && data.rangoFinal) {
        document.getElementById('valorInicial').value = data.rangoInicial;
        document.getElementById('valorFinal').value = data.rangoFinal;
      } else {
        console.error('Respuesta inesperada del servidor: ', data);
      }
    })
    .catch(error => console.error('Error al actualizar los rangos: ', error));
  }
}
  </script>
</body>

</html>