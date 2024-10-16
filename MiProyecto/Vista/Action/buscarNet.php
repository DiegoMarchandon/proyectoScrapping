
<?php
require '../Composer/vendor/autoload.php';
use Controlador\ABMNotebook;

$ABMNotebook = new ABMNotebook;
$datos = darDatosSubmitted();
$especificaciones = $datos['busquedaInput'];
$coincidenciasNet = $ABMNotebook->returnMatches($especificaciones);

echo "<br>nets coincidentes:<br>";
echo $datos['busquedaInput'];

// print_r($coincidenciasNet);
/* foreach($coincidenciasNet as $net){
    echo "<br>".print_r($net['fullname'])."<br>";
} */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
     <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Notebooks coincidentes</title>
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
        <div class="row">
            <?php foreach($coincidenciasNet as $net): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $net['fullname']; ?></h5>
                            <p class="card-text">
                                <strong>Marca:</strong> <?php echo $net['marca']; ?><br>
                                <strong>Procesador:</strong> <?php echo $net['procesador']; ?><br>
                                <strong>Sitio:</strong> <?php echo $net['sitio']; ?><br>
                                <strong>Precio:</strong> <?php echo $net['precio']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>