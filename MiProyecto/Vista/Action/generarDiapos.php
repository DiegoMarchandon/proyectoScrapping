<?php
require_once '../Composer/vendor/autoload.php';
include_once '../estructura/header.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape\Drawing\Base64;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;

$datos = darDatosSubmitted();
$accionSobrePresentacion = false;

// reconocer qué nos llega del form
if (array_key_exists('notebooks', $datos)) {
    // Obtener los datos de las notebooks del primer archivo
    $json = $datos['notebooks'];
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
        // Si la imagen es en formato base64  SIUUUUUUUU
        if (preg_match('/^data:image\/(\w+);base64,/', $notebook['imageSrc'], $type)) {
            // $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $notebook['imageSrc']);
            // echo $base64String;
            $data = "'" . $notebook['imageSrc'] . "'";

            $image = new Base64();
            $image->setName('Image of ' . $notebook['fullname']);
            $image->setDescription('Image of ' . $notebook['fullname']);
            $image->setData($data);
            $image->setHeight(200);
            $image->setWidth(250);
            $image->setOffsetX(100);
            $image->setOffsetY(300);
            $image->getShadow()->setVisible(true);
            $diapo->addShape($image);
        } else {
            // Si no es base64 guardar la URL de la imagen por si las moscas lo dejo
            $image = $diapo->createDrawingShape();
            $image->setName('Image of ' . $notebook['fullname']);
            $image->setDescription('Image of ' . $notebook['fullname']);
            $image->setPath($notebook['imageSrc']);
            $image->setHeight(200);
            $image->setWidth(250);
            $image->setOffsetX(100);
            $image->setOffsetY(300);
            $image->getShadow()->setVisible(true);
        }


        // Titulo de la notebook (fullname)
        $formaTexto = $diapo->createRichTextShape();
        $formaTexto
            ->setHeight(50)
            ->setWidth(800)
            ->setOffsetX(75)
            ->setOffsetY(50);
        $formaTexto->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $texto = $formaTexto->createTextRun($notebook['fullname']);
        $texto->getFont()->setBold(true)
            ->setSize(30)
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
            ->setOffsetX(400)
            ->setOffsetY(300);
        $formaInfo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $infoTexto = $formaInfo->createTextRun($info);
        $infoTexto->getFont()->setSize(25)
            ->setColor(new Color('FF000000'));
    }

    // Guardar la presentacion en un archivo
    $writerPPTX = IOFactory::createWriter($presentacion, 'PowerPoint2007');
    $writerPPTX->save(__DIR__ . '/notebooks.pptx');
} elseif (array_key_exists('abrirDiapos', $datos)) {
    // Ruta del archivo PPTX
    $filePath = __DIR__ . '/notebooks.pptx';
    if (file_exists($filePath)) {
        // Ejecutar el comando para abrir PowerPoint con el archivo
        shell_exec('start "" "' . $filePath . '"');
        $accionSobrePresentacion = true;
        $mensaje = "Se abrió el PowerPoint";
    }
} elseif (array_key_exists('borrarDiapos', $datos)) {
    // Ruta del archivo PPTX
    $filePath = __DIR__ . '/notebooks.pptx';
    // Verificar si el archivo existe y eliminarlo
    if (file_exists($filePath)) {
        unlink($filePath);
        $accionSobrePresentacion = true;
        $mensaje = "El archivo ha sido eliminado correctamente.";
    } else {
        $accionSobrePresentacion = true;
        $mensaje = "El archivo no existe.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diapositivas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="display-4 text-success mb-4">Presentación generada correctamente</h1>
            <p class="lead">La presentación se ha guardado como <strong>notebooks.pptx</strong>.</p>
        </div>
        <div class=" d-flex">
            <form action="#" method="post">
                <input type="submit" class="btn btn-outline-success btn-lg m-2" name="abrirDiapos" value="Abrir diapositivas">
            </form>
            <form action="#" method="post">
                <input type="submit" class="btn btn-outline-danger btn-lg m-2" name="borrarDiapos" value="Borrar archivo">
            </form>
            <!-- <button class="btn btn-outline-success btn-lg m-2" onclick="openPPT()">Abrir Diapositiva</button> -->
        </div>
        <?php if ($accionSobrePresentacion): ?>
            <div class="alert alert-success">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <?php
    include_once '../estructura/footer.php';
    ?>