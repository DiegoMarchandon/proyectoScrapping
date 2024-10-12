<?php 
require '../Composer/vendor/autoload.php';
// require '../../Utils/funciones.php';
use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
$colNets = json_encode($ABMNotebook->buscarArray(null));
// el echo es el que hace que se me muestren los resultados 
echo $colNets;
?>

