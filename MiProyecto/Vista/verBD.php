<?php

require './Composer/vendor/autoload.php';

use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
$colNets = $ABMNotebook->buscarArray(null);
// echo "hola\n";
// print_r($colNets[0]['Marca']);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scrappy</title>
    
        <!-- jQuery -->
        <!-- <script src="js/jquery-3.7.1.js"></script> -->
        <!-- script de autompletado -->
        <!-- <script src="Action/sugerencias.php"></script> -->
        <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="bg-dark text-light">
    <nav id="barraNav" class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
  
  <a class="navbar-brand" href="#">Grupo 1 PWD</a>
  <a class="btn btn-dark active" aria-current="page" href="Scrappy.php">Inicio</a>
  <a class="btn btn-dark" href="">ver Base de Datos</a>
  <a class="btn btn-dark" href="Actualizar Base de Datos">opcion3</a>
  <a class="btn btn-dark" href="#">opcion4</a>
      
      <span class="navbar-text">
          TP usando librerías
      </span>
  
</nav>
        <div class="card bg-dark text-light">
                <div class="card-header">
                    <h4>Lista de notebooks</h4>
                </div>
                <div class="card-body">
                    <table id="tablaBD" class="table table-dark table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Marca</th>
                            <th>Procesador</th>
                            <th>Sitio</th>
                            <th>Precio</th>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($colNets) && count($colNets) > 0) {
                                foreach ($colNets as $key => $value) {
                                    echo '<tr>';
                                    echo '<td>' . $colNets[$key]['id'] . '</td>';
                                    echo '<td>' . $colNets[$key]['fullname'] . '</td>';
                                    echo '<td>' . $colNets[$key]['marca'] . '</td>';
                                    echo '<td>' . $colNets[$key]['procesador'] . '</td>';
                                    echo '<td>' . $colNets[$key]['sitio'] . '</td>';
                                    echo '<td>' . $colNets[$key]['precio'] . '</td>';
                                    echo '<tr>';
                                }
                            } else echo '<tr><td colspan="6">No hay notebooks cargadas.</td></tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </body>
</html>