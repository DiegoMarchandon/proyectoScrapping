<?php
// falta terminar de configurar el header
// include_once('estructura/header.php');

// require_once('Action/autoScrapping.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrappy</title>

    <!-- jQuery -->
    <script src="../js/jquery-3.7.1.js"></script>
    <!-- script de autompletado -->
    <script src="Action/sugerencias.php"></script>
    <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="titleContainer">
        <img src="Assets/IMGs/scrappyLogo2.png" alt="scrappy logo" height="90">
        <h3>Scrappy</h3>
    </div>
    <div class="neon-form">
        <form>
            <div class="mb-3">
                <label for="especificaciones" class="form-label text-light">ingrese las especificaciones deseadas</label>
                <input type="text" class="form-control neon-input" id="busquedaInput" placeholder="Ej: marca, modelo, procesador...">
                <div id="suggestions"></div> <!-- donde se mostrarán las sugerencias -->
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
        
    </script>
</body>
</html>
