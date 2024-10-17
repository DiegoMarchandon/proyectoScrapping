<?php
// Ruta del archivo PPTX
$filePath = __DIR__ . '/notebooks.pptx';
// Verificar si el archivo existe y eliminarlo
if (file_exists($filePath)) {
    unlink($filePath);
    echo "<h1>El archivo ha sido eliminado correctamente.</h1>";
} else {
    echo "<h1>El archivo no existe.</h1>";
}
// exit;
?>