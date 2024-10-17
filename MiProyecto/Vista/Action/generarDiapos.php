<?php
require_once '../Composer/vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;

// Obtener los datos de las notebooks del primer archivo
$json = darDatosSubmitted()['notebooks'];
$notebooks = json_decode($json, true);

$presentacion = new PhpPresentation();
$titulo = $presentacion->getActiveSlide();
$titulo->setName("Notebooks coincidentes");

// Titulo de la presentacion
$formaTexto = $titulo->createRichTextShape();
$formaTexto
    ->setHeight(300)
    ->setWidth(600)
    ->setOffsetX(170)
    ->setOffsetY(180);
$formaTexto->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$texto = $formaTexto->createTextRun("Notebooks coincidentes");
$texto->getFont()->setBold(true)
                 ->setSize(60)
                 ->setColor(new Color('FFE06B20'));

foreach ($notebooks as $notebook) {
    // Crear una nueva diapositiva para cada notebook
    $diapo = $presentacion->createSlide();
    $diapo->setName($notebook['fullname']);

    // Agregar la imagen de la notebook
    if (file_exists($notebook['imageSrc'])) {
        $image = $diapo->createDrawingShape();
        $image->setName('Image of ' . $notebook['fullname']);
        $image->setDescription('Image of ' . $notebook['fullname']);
        $image->setPath($notebook['imageSrc']);
        $image->setHeight(300);
        $image->setOffsetX(100);
        $image->setOffsetY(150);
        $image->getShadow()->setVisible(true);
    }

    // Titulo de la notebook (fullname)
    $formaTexto = $diapo->createRichTextShape();
    $formaTexto
        ->setHeight(50)
        ->setWidth(600)
        ->setOffsetX(100)
        ->setOffsetY(50);
    $formaTexto->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $texto = $formaTexto->createTextRun($notebook['fullname']);
    $texto->getFont()->setBold(true)
                    ->setSize(20)
                    ->setColor(new Color('FFE06B20'));

    // Informacion adicional
    $info = "Marca: " . $notebook['marca'] . "\n" .
            "Procesador: " . $notebook['procesador'] . "\n" .
            "Sitio: " . $notebook['sitio'] . "\n" .
            "Precio: $" . number_format($notebook['precio'], 2, ',', '.');

    $formaInfo = $diapo->createRichTextShape();
    $formaInfo
        ->setHeight(200)
        ->setWidth(600)
        ->setOffsetX(100)
        ->setOffsetY(470);
    $formaInfo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $infoTexto = $formaInfo->createTextRun($info);
    $infoTexto->getFont()->setSize(20)
                        ->setColor(new Color('FF000000'));
}

// Guardar la presentacion en un archivo
$writerPPTX = IOFactory::createWriter($presentacion, 'PowerPoint2007');
$writerPPTX->save(__DIR__ . '/sample.pptx');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diapositivas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="display-4 text-success mb-4">Presentación generada correctamente</h1>
            <p class="lead">La presentación se ha guardado como <strong>sample.pptx</strong>.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
