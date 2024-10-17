
<?php
require '../Composer/vendor/autoload.php';
include '../estructura/header.php';
use Controlador\ABMNotebook;
use Facebook\WebDriver\Exception\NoSuchAlertException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Symfony\Component\Panther\Client;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception;

// Inicializacion de la clase ABMNotebook
$ABMNotebook = new ABMNotebook();
$datos = darDatosSubmitted();
$especificaciones = $datos['busquedaInput'];
$coincidenciasNet = $ABMNotebook->returnMatches($especificaciones);
$json = json_encode($coincidenciasNet);

// Configuración del WebDriver para Microsoft Edge
$msedgedriverURL = 'http://localhost:49799'; 
$edgeBinary = 'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe';
$msedgedriver = 'C:\\Drivers\\edgedriver_win64\\msedgedriver.exe';

$capabilities = DesiredCapabilities::microsoftEdge();
$capabilities->setCapability('ms:edgeOptions', [
    'binary' => $edgeBinary,
    'args' => ['--disable-gpu', '--no-sandbox', '--disable-popup-blocking', '--disable-notifications', '--headless']
]);

// Conexión al WebDriver
$driver = RemoteWebDriver::create($msedgedriverURL, $capabilities);

// Obtener imagenes de Google para cada notebook y almacenarlas
$notebookData = [];
    foreach ($coincidenciasNet as $notebook) {
        $url = 'https://www.google.com/search?q=' . str_replace(' ', '+', $notebook['fullname']) . '&udm=2';
        $driver->get($url);
        $driver->wait(10);

        // Buscar la imagen utilizando XPath
        $image = $driver->findElement(WebDriverBy::xpath('/html/body/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/h3/a/div/div/div/g-img/*'));

        if ($image == null) {
            $imageSrc = "https://cdn-icons-png.freepik.com/512/13434/13434972.png";
        } else $imageSrc = $image->getAttribute('src');

        $notebookData[] = [
            'fullname' => $notebook['fullname'],
            'marca' => $notebook['marca'],
            'procesador' => $notebook['procesador'],
            'sitio' => $notebook['sitio'],
            'precio' => $notebook['precio'],
            'imageSrc' => $imageSrc
        ];
    }

// Cerrar el WebDriver
$driver->quit();

// Pasar los datos de las notebooks como JSON
$json = json_encode($notebookData);

?>

<div class="container mt-5">
        <div class="card bg-dark">
            <div class="card-header text-light h1 my-5 d-flex justify-content-between align-items-center">
                Coincidencias con la búsqueda
                <?php if (!empty($datos['busquedaInput']) && !empty($coincidenciasNet)): ?>
                    <form action="generarDiapos.php" method="post">
                        <input type="hidden" id="notebooks" name="notebooks" value='<?php echo $json; ?>'>
                        <input type="submit" class="btn btn-light btn-lg" value="Generar diapo">
                    </form>
                <?php endif; ?>
            </div>
            <div class="card-body row">
                <?php if (empty($datos['busquedaInput']) || empty($coincidenciasNet)): ?>
                    <h1>No hubo búsquedas relacionadas.</h1>
                <?php else: ?>
                    <?php foreach ($notebookData as $notebook): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-secondary text-white">
                                <img src="<?php echo $notebook['imageSrc']; ?>" class="card-img-top" alt="Imagen de <?php echo $notebook['fullname']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $notebook['fullname']; ?></h5>
                                    <p class="card-text">
                                        <strong>Marca:</strong> <?php echo $notebook['marca']; ?><br>
                                        <strong>Procesador:</strong> <?php echo $notebook['procesador']; ?><br>
                                        <strong>Sitio:</strong> <?php echo $notebook['sitio']; ?><br>
                                        <strong>Precio:</strong> <?php echo $notebook['precio']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include ('../estructura/footer.php');
?>