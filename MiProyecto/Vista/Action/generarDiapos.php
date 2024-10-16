<?php
require_once '../Composer/vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;


$json = darDatosSubmitted()['notebooks'];
$notebooks = json_decode($json, true);
$presentacion = new PhpPresentation();
$titulo = $presentacion->getActiveSlide();
$titulo->setName("Notebooks coincidentes");
$formaTexto = $titulo->createRichTextShape();
$formaTexto
    ->setHeight(300)
    ->setWidth(600)
    ->setOffsetX(170)
    ->setOffsetY(180);
$formaTexto->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
$texto = $formaTexto->createTextRun("Notebooks coincidentes");
$texto->getFont()->setBold(true)
                ->setSize(60)
                ->setColor(new Color('FFE06B20'));


foreach($notebooks as $notebook){
    $diapo = $presentacion->createSlide();
    $diapo->setName($notebook['fullname']);
    $formaTexto = $diapo->createRichTextShape();
    $formaTexto
        ->setHeight(300)
        ->setWidth(600)
        ->setOffsetX(170)
        ->setOffsetY(180);
    $formaTexto->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
    $texto = $formaTexto->createTextRun($notebook['fullname']);
    $texto->getFont()->setBold(true)
                    ->setSize(60)
                    ->setColor(new Color('FFE06B20'));
;
}

$writerPPTX = IOFactory::createWriter($presentacion, 'PowerPoint2007');
$writerPPTX->save(__DIR__ . '/sample.pptx');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diapositivas</title>
</head>
<body>

aca va un mensaje q indica si se descargó
    
</body>
</html>