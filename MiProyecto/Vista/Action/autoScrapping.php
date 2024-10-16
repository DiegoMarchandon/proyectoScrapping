<?php
// script que se encarga de cargar automáticamente la base de datos con los distintos datos recopilados de las notebooks
// 1) crear un controlador en Action que se encargue de consultar las diferentes páginas web, realizar el scraping, y cargar los resultados en la base de datos.

// inicio una sesión para almacenar los datos del prograso del scraping en una variable superglobal
session_start();

// require 'Composer/vendor/autoload.php';
require '../Composer/vendor/autoload.php';
// require '../Utils/funciones.php';


use Controlador\ABMNotebook;
use Symfony\Component\Panther\Client;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Symfony\Component\Panther\PantherTestCase;

// ruta al ejecutable de Microsoft Edge (Diego)
$rutaExe = 'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe';

// ruta al driver de Edge, si no está en el PATH (Diego)
$msedgedriver = 'C:\\Drivers\\edgedriver_win64\\msedgedriver.exe';

// Nro de puerto obtenido después de ingresar la ubicación de mi driver $msedgedriver en el CMD (Diego)
$puertoDriver = 'http://localhost:60190';

// En caso de Edge (Diego):
$capabilities = DesiredCapabilities::microsoftEdge();
// en caso de Chrome (comentar la anterior):
// $capabilities = DesiredCapabilities::chrome();

// Modificar ms:edgeOptions por goog:chromeOptions en caso de usar Chrome, moz:firefoxOptions en caso de usar firefox
$capabilities->setCapability('ms:edgeOptions',[
    
    'binary' => $rutaExe,
    'args' => [ '--disable-gpu','--no-sandbox','--disable-popup-blocking','--disable-notifications', '--headless']
]);

/* Acá se crea la conexión. Hasta donde ví, existen 2 clases que representan maneras diferentes de conectarse: */
/* 1) con RemoteWebDriver (las funciones y métodos implementadas acá son de esta clase. Se usa un driver en lugar de simular el comportamiento de Cliente): */
$driver = RemoteWebDriver::create($puertoDriver,$capabilities);
/* 2) con Selenium (las funciones y métodos varían. Ver scrapeClient.php que fue implementado con selenium): */
// $client = Client::createSeleniumClient($puertoDriver,$capabilities);


// realiza la solicitud

// URL de las distintas paginas a consultar
// la key es la URL y el value es un elemento que hace referencia a una net de la página 
$ColURLs = [
    'https://listado.mercadolibre.com.ar/notebook#D[A:notebook]' => 
    [ 
        'classNets' => 'li.ui-search-layout__item',
        'precioNet' => 'div.poly-price__current .andes-money-amount__fraction',
        'nombreNet' => '.poly-box.poly-component__title'
    ],
    'https://www.garbarino.com/celulares-notebooks-y-tecnologia/informatica/notebooks-y-pc/notebooks' => 
    [
        'classNets' => '.d-flex.justify-center.col-sm-3.col-12',
        'precioNet' => '.product-card-design6-vertical__price',
        'nombreNet' => '.product-card-design6-vertical__name'
    ],
    'https://www.fravega.com/l/informatica/notebooks/' => 
    [
        'classNets' => 'li > article[data-test-id="result-item"]',
        'precioNet' => '.sc-1d9b1d9e-0.OZgQ',
        'nombreNet' => '.sc-ca346929-0.czeMAx'
    ],
    'https://www.musimundo.com/informatica/notebook/c/98' => 
    [
        'classNets' => '.productListerGridItem',
        'precioNet' => 'span[data-test-item-price="item_price"]',
        'nombreNet' => 'a[data-test-plp="item_name"]'
    ]
];

$ABMNotebook = new ABMNotebook; 
$ABMNotebook->deleteRegis();
/* if($ABMNotebook->deleteRegis() > 0){
    echo "<h1>Se eliminaron los datos correctamente</h1>";
}else{
    echo "<h1>No se eliminaron los datos.</h1>";
} */

$cantURLs = count($ColURLs); #total de páginas a recorrer

/* cada clave ($URL) guarda como valor una coleccion de clases ($infoNets) relacionadas con las notebooks de su respectiva página */
// creo una variable index para detectar en cuál elemento de mi arreglo asociativo estoy 
$index = 0;
// inicializo el porcentaje de scrapping
$_SESSION['progreso_scrapping'] = 0;

foreach($ColURLs as $URL => $infoNets){
    $driver->get($URL);
    $index++;
    // actualizo el progreso: 
    $_SESSION['progreso_scrapping'] = ($index / $cantURLs) * 100;
    
    $colNets = $driver->findElements(WebDriverBy::cssSelector($infoNets['classNets']));

    foreach($colNets as $notebook){

        // cuando llego a la página de musimundo (última en mi arreglo) siempre tengo problemas al momento de querer acceder a la clase con el nombre de las notebooks, (PHP Error: no such element... 'a[data-test-plp="item_name"]')
        // por eso probé utilizar las funciones de Espera de WebDriver. Para esperar la aparición del elemento en mi cssSelector 
        if($index == 4){
            $wait = new WebDriverWait($driver,10);
            $wait->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector($infoNets['nombreNet'])));

            // este try-catch hace lo mismo que el que viene por defecto configurado en WebDriver, solo devuelve un mensaje en español. Pueden sacarlo si quieren
            try {
                // $nombreNet = $driver->findElement(WebDriverBy::xpath("//*[self::h2 or self::h3 or self::p or self::a][contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'notebook')]"))->getText();
                $nombreNet = $notebook->findElement(WebDriverBy::cssSelector($infoNets['nombreNet']))->getText();
            } catch (Exception $e) {
                $nombreNet = "Nombre no disponible"; // Puedes asignar un valor por defecto si lo prefieres
                echo "Error al obtener el nombre en la URL: $URL\n";
                echo "Mensaje de error: " . $e->getMessage() . "\n";
            }
            $precioNet = $notebook->findElement(WebDriverBy::cssSelector($infoNets['precioNet']))->getText();
        }else{
            $nombreNet = $notebook->findElement(WebDriverBy::cssSelector($infoNets['nombreNet']))->getText();
            // $nombreNet = $driver->findElement(WebDriverBy::xpath("//*[contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'notebook')]"))->getText();
            $precioNet = $notebook->findElement(WebDriverBy::cssSelector($infoNets['precioNet']))->getText();
        }
        // datos de una notebook convertida en arreglo asociativo
        $netArrAssoc = dataFormatted($nombreNet,$precioNet,$URL);

        $ABMNotebook->alta($netArrAssoc);


    }
}

// proceso completo
$_SESSION['progreso_scrapping'] = 100;
session_write_close(); // Cerrar la sesión para asegurar que se guarde el progreso

echo json_encode(['status'=>true]);
// Cierra el WebDriver
// header('Location: ../Scrappy.php');
$driver->quit();
?>