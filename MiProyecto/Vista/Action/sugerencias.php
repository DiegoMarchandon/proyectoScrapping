<?php 
require '../Composer/vendor/autoload.php';
require '../../Utils/funciones.php';
use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
$colNets = json_encode($ABMNotebook->buscarArray(null));
echo $colNets;
// print_r($colNets);
?>

