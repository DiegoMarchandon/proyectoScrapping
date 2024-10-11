<?php
// API para consultar el progreso
// Action/getProgress.php
session_start();

header('Content-Type: application/json');

// Obtener el progreso desde la sesión
$progress = isset($_SESSION['progreso_scrapping']) ? $_SESSION['progreso_scrapping'] : 0;

// Devolver el progreso como JSON
echo json_encode(['progress' => $progress]);

?>