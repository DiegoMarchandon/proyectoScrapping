<?php
require "../Composer/vendor/autoload.php";

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Style\Color;

// Crear una nueva presentación
$objPHPPresentation = new PhpPresentation();

// Crear una nueva diapositiva
$currentSlide = $objPHPPresentation->getActiveSlide();

// Agregar un texto a la diapositiva
$richTextShape = $currentSlide->createRichTextShape()
    ->setHeight(300)
    ->setWidth(600)
    ->setOffsetX(180)
    ->setOffsetY(180);

    // Añadir un nuevo objeto RichText
$richText = new RichText();
// $richTextShape->getActiveParagraph()->addShape($richText);

$textRun = $richText->createTextRun('¡Hola, mundo!');
$textRun->getFont()->setBold(true);
$textRun->getFont()->setSize(60);
$textRun->getFont()->setColor(new Color('FF0000')); // Color en formato hexadecimal

// Guardar la presentación
$objWriter = IOFactory::createWriter($objPHPPresentation, 'PowerPoint2007');
$objWriter->save('mi_presentacion.pptx');
?>
