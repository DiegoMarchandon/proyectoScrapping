<?php
// falta terminar de configurar el header
// include_once('estructura/header.php');
// require 'Composer/vendor/autoload.php';
// require '../Utils/funciones.php';
// require 'Action/autoScrapping.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrappy</title>

    <!-- jQuery -->
    <script src="js/jquery-3.7.1.js"></script>
    <!-- script de autompletado -->
    <script src="Action/sugerencias.php"></script>
    <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav id="barraNav" class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
  
    <a class="navbar-brand" href="#">Grupo 1 PWD</a>
    <a class="btn btn-dark active" aria-current="page" href="#">Inicio</a>
    <a class="btn btn-dark" href="verBD.php">ver Base de Datos</a>
    <a class="btn btn-dark" href="Action/autoScrapping.php">Actualizar Base de Datos</a>
    <a class="btn btn-dark" href="#">opcion4</a>
        
        <span class="navbar-text">
            TP usando librerías
        </span>
    
</nav>
    <h3 id="progressTitle">Scrapping en progreso</h3>
    <div class="progress-container">
        <div id="progressBar" class="progress-bar">0%</div>
    </div>

    <div id="titleContainer">
        <img src="Assets/IMGs/scrappyLogo2.png" alt="scrappy logo" height="90">
        <h3>Scrappy</h3>
    </div>
    <div class="neon-form">
        <form>
            <div class="mb-3">
                <label for="especificaciones" class="form-label text-light">ingrese las especificaciones deseadas</label>
                <input type="text" class="form-control neon-input" id="busquedaInput" placeholder="Ej: marca, modelo, procesador...">
                <div id="suggestions">
                    
                </div> <!-- donde se mostrarán las sugerencias -->
            </div>
            
            <button type="submit" class="btn neon-btn w-100">Buscar</button>
        </form>
    </div>

    <div class="pages">
        <h4>páginas consultadas</h4>
        <div class="pages-logos">
            <div class="logoContainer">
                <a href="https://www.fravega.com/l/informatica/notebooks/">
                    <img class="logoClass" src="Assets/IMGs/marca-fravega.png" alt="">
                </a>
            </div>
            <div class="logoContainer">
                <a href="https://www.garbarino.com/celulares-notebooks-y-tecnologia/informatica/notebooks-y-pc/notebooks"></a>
                <img class="logoClass" src="Assets/IMGs/marca-garbarino.png" alt="">
            </div>
            <div class="logoContainer">
                <a href="https://listado.mercadolibre.com.ar/notebook#D[A:notebook]">
                    <img class="logoClass" src="Assets/IMGs/marca-mercadolibre.png" alt="">
                </a>
            </div>
            <div class="logoContainer">
                <a href="https://www.musimundo.com/informatica/notebook/c/98">
                    <img class="logoClass" src="Assets/IMGs/marca-musimundo.png" alt="">
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
        fetch('Action/sugerencias.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
        function checkProgress() {
            $.ajax({
                url: 'Action/getProgress.php', // Llama al script que devuelve el progreso
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var progress = data.progress;
                    // Actualizar la barra de progreso
                    $('#progressBar').css('width', progress + '%').text(progress + '%');

                    // Si no ha llegado al 100%, seguir consultando
                    if (progress < 100) {
                        setTimeout(checkProgress, 1000); // Volver a llamar en 1 segundo
                    }
                },
                error: function() {
                    console.error('Error obteniendo el progreso');
                }
            });
        }
        $(document).ready(function() {
            checkProgress();
            
            $('#busquedaInput').on('input', function() {

                const inputValue = $(this).val();
                /* imprimo el valor del input: */
                // console.log(inputValue);

                if (inputValue.length > 0) {
                    $.ajax({
                        url: 'Action/getProgress.php', // Ruta al script en Action
                        method: 'GET',
                        dataType: 'json',
                        data: { search: inputValue },
                        success: function(data) {
                            // Aquí deberías procesar y mostrar las sugerencias
                            $('#suggestions').html(data);
                        }
                    });
                } else {
                    $('#suggestions').empty(); // Limpiar sugerencias si no hay entrada
                }
            });
        });
    </script>
</body>
</html>
