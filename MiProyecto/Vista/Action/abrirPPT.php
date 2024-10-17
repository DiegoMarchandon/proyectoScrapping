<?php
// script de la ejecución para abrir el powerPoint
// Ruta del archivo PPTX
$filePath = __DIR__ . '/sample.pptx';
// Ejecutar el comando para abrir PowerPoint con el archivo
shell_exec('start "" "' . $filePath . '"');

echo "<h1> se abrió el PowerPoint</h1>";

// Redireccionar de vuelta a la página original o mostrar un mensaje
// header('Location: index.php');
// exit;
?>