<?php 
require '../Composer/vendor/autoload.php';
// require '../../Utils/funciones.php';
use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
/* MODIFICAR colNets de forma que el arreglo almacene arreglos asociativos conteniendo claves (nombre, id) y valores. */
// $arreglo = $ABMNotebook->buscarArray(null);
// $arrIDyNombres = []; 
$colNets = json_encode($ABMNotebook->buscarArray(null));

echo $colNets;
// el echo es el que hace que se me muestren los resultados 
/* foreach($arreglo as $net){
    $arrIDyNombres[] = ['id' => $net['id'], 'fullname' => $net['fullname']];
} */
/* 
Array ( [0] => Array ( [id] => 7600 [fullname] => Notebook Lenovo Intel I5-1235u 16gb 512gb 15,6 Fhd Black ) 
[1] => Array ( [id] => 7601 [fullname] => Notebook Hp Elitebook 840 G5 I7-8250u 14 8gb 512gb Ssd ) 
[2] => Array ( [id] => 7602 [fullname] => Netbook Exomate X5-s1441p Intel N4020c 4gb Ssd128gb 11,6 W11 Color Gris ) 
[3] => Array ( [id] => 7603 [fullname] => Notebook Noblex N14x1010 14.1 Hd Intel Celeron 4gb/128gb Sdd ))
*/
// arreglo indexado que contiene pares clave-valor
// print_r($arrIDyNombres);

// arreglo con objetos
// $colNetsJSON = json_encode($arrIDyNombres);
/* 
[{"id":7600,"fullname":"Notebook Lenovo Intel I5-1235u 16gb 512gb 15,6 Fhd Black"},
{"id":7601,"fullname":"Notebook Hp Elitebook 840 G5 I7-8250u 14 8gb 512gb Ssd"},
{"id":7602,"fullname":"Netbook Exomate X5-s1441p Intel N4020c 4gb Ssd128gb 11,6 W11 Color Gris"},
{"id":7603,"fullname":"Notebook Noblex N14x1010 14.1 Hd Intel Celeron 4gb\/128gb Sdd"}]
*/

?>

