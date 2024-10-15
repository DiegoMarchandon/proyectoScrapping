
<?php
require '../Composer/vendor/autoload.php';
echo '<h1>Nets sugeridas impresas:</h1><br>';
$datos = darDatosSubmitted();
print_r($datos);
// echo $datos['busquedaInput']."\n";
// echo $datos;
echo '<br><h1>Cant de sugerencias: </h1><br>';
echo "nets sugeridas: ".$datos['infoNets'];
// $colNets = json_encode();
// foreach()
echo "\ncantidad: ".count($datos);
?>