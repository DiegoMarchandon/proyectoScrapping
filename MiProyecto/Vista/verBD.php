<?php
require '../Composer/vendor/autoload.php';
require '../../Utils/funciones.php';
use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
$colNets = $ABMNotebook->buscarArray(null);
// echo "hola\n";
// print_r($colNets);
?>

