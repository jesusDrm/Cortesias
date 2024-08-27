<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/estilos.css">
  <link rel="icon" href="./assets/img/icono.ico" type="image/x-icon">
  <title>Historial</title>
  <style>
    /* Añadido para ajustar el ancho de la tarjeta */
    .card-custom {
      width: calc(100% + 5cm); /* Añade 5 cm al ancho actual */
      max-width: 100%; /* Asegura que no se salga del contenedor */
    }

    /* Asegura que la tabla esté centrada */
    .table-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <?php include "navbar.php"; ?>
  <form id="historialForm" enctype="multipart/form-data" method="GET">
    <section class="">
      <div class="container py-5 h-100 fondo">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong card-custom" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <h1 class="text-center">Historial</h1>

                <div class="container mb-3 mt-2">
                  <h2>Nombres</h2>
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Seleccionar
                    </button>
                    <ul class="dropdown-menu" id="dropdownMenu" aria-labelledby="dropdownMenuButton">
                      <!-- Opciones serán cargadas por JavaScript -->
                    </ul>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Nombre Seleccionado: </label>
                  <input type="text" class="form-control" id="nombreSeleccionado" name="nombre_seleccionado" readonly>
                </div>

                <button type="button" class="btn btn-primary" id="consultarBtn">Consultar</button>
                <button type="button" class="btn btn-success" id="exportBtn">Descargar Excel</button>
                
                <!-- Aquí se añadirá la tabla -->
                <div id="resultados" class="mt-4 table-container"></div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
  // Cargar nombres para el dropdown
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
        dropdownMenu.innerHTML = '';
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

  // Cargar todos los datos al inicio
  fetch('historial.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Error en la red');
      }
      return response.json();
    })
    .then(data => {
      displayTable(data);
    })
    .catch(error => console.error('Error al cargar los datos:', error));
});

// Establecer el nombre seleccionado en el campo de texto
function setName(name) {
  document.getElementById('nombreSeleccionado').value = name;
}

// Consultar historial y mostrar en la tabla
document.getElementById('consultarBtn').addEventListener('click', function() {
  const nombreSeleccionado = document.getElementById('nombreSeleccionado').value;
  if (nombreSeleccionado) {
    fetch('historial.php?nombre_seleccionado=' + encodeURIComponent(nombreSeleccionado))
      .then(response => {
        if (!response.ok) {
          throw new Error('Error en la red');
        }
        return response.json();
      })
      .then(data => {
        displayTable(data);
      })
      .catch(error => console.error('Error al cargar los datos:', error));
  } else {
    alert('Por favor, selecciona un nombre.');
  }
});

// Función para mostrar la tabla
function displayTable(data) {
  let html = '<table class="table table-striped">';
  html += '<thead><tr><th>ID</th><th>Nombre</th><th>Fecha</th><th>No. de cortesías</th><th>Clave de rango inicial</th><th>Clave de rango final</th></tr></thead><tbody>';
  
  data.forEach(item => {
    html += `<tr><td>${item.ID || ''}</td><td>${item.NombreID || ''}</td><td>${item.Fecha || ''}</td><td>${item.NumeroCortesias || ''}</td><td>${item.RangoInicial || ''}</td><td>${item.RangoFinal || ''}</td></tr>`;
  });  
  
  html += '</tbody></table>';
  document.getElementById('resultados').innerHTML = html;
}

// Exportar a Excel
document.getElementById('exportBtn').addEventListener('click', function() {
  const nombreSeleccionado = document.getElementById('nombreSeleccionado').value;
  let url = 'export_excel.php';
  if (nombreSeleccionado) {
    url += '?nombre_seleccionado=' + encodeURIComponent(nombreSeleccionado);
  }
  window.location.href = url;
});

  </script> 
</body>
</html>