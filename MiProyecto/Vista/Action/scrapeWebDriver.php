<?php
/* PASOS PARA CONECTARME CON MICROSOFT EDGE:
1) ejecutar el driver de edge en CMD:
C:\Drivers\edgedriver_win64\msedgedriver.exe
2) copiar el puerto que aparece ("msedgedriver was started successfully on port 64762.") y reemplazarlo en la variable $msgedgedriverURL 
3) ejecutar el script con el webDriver.
*/

// require __DIR__.'/vendor/autoload.php';
require '../Composer/vendor/autoload.php';
// echo __DIR__;
require '../../Utils/funciones.php';
// require '../../Controlador/ABMNotebook.php';

use Symfony\Component\Panther\Client;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Symfony\Component\Panther\PantherTestCase;

// ruta al msgedgedriver con el puerto correcto
$msedgedriverURL = 'http://localhost:62863';

// ruta al ejecutable de Microsoft Edge
$edgeBinary = 'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe';

// ruta al msedgedriver, si no está en el PATH
$msedgedriver = 'C:\\Drivers\\edgedriver_win64\\msedgedriver.exe';

$capabilities = DesiredCapabilities::microsoftEdge();
$capabilities->setCapability('ms:edgeOptions',[
    
    'binary' => $edgeBinary,
    'args' => [ '--disable-gpu','--no-sandbox']
]);

/* una vez especificadas las capacidades del navegador y la URL del servidor, me conecto al mismo. */
$driver = RemoteWebDriver::create($msedgedriverURL,$capabilities);

// realiza la solicitud

// $driver->get('https://www.culturagenial.com/es/libros-para-leer/');

// inicia un cliente de Panther (usará un navegador en segundo plano);
/* 
$client = Client::createChromeClient($msedgedriver,
[
    '--headless', // Opcional, para que se ejecute en segundo plano
    '--disable-gpu',
    '--no-sa

// Realiza la solicitud
// $crawler = $client->request('GET', 'https://www.culturagenial.com/es/libros-para-leer/');

// Selecciona los títulos de los artículos
/* $titles = $crawler->filter('h2.article-title')->each(function ($node) {
    return $node->text();
}); */

/* para filtrar los títulos de los libros 
$booksContainer= $driver->findElement(WebDriverBy::id('js-news-body'));

$titles = $booksContainer->findElements(WebDriverBy::cssSelector('h2'));

// Muestra los títulos

foreach ($titles as $title) {
    echo $title->getText()."\n";
}
*/

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
// $driver->get('https://listado.mercadolibre.com.ar/notebook#D[A:notebook]');
// $driver->get('https://www.garbarino.com/celulares-notebooks-y-tecnologia/informatica/notebooks-y-pc/notebooks');
// $driver->get('https://www.fravega.com/l/informatica/notebooks/');
// $driver->get('https://www.musimundo.com/informatica/notebook/c/98');

// filtrar y ordenar los precios de notebooks
// $netsMercadoLibre = $driver->findElements(WebDriverBy::cssSelector('li.ui-search-layout__item'));
// $netsGarbarino = $driver->findElements(WebDriverBy::cssSelector('.d-flex.justify-center.col-sm-3.col-12'));
// $netsFravega = $driver->findElements(WebDriverBy::cssSelector('li > article[data-test-id="result-item"]'));
// $netsMusimundo = $driver->findElements(WebDriverBy::cssSelector('.productListerGridItem'));

// print_r($netsMusimundo);
echo "hola\n";

/* 
foreach($netsGarbarino as $notebook){
    $precioActual = $notebook->findElement(WebDriverBy::cssSelector('.product-card-design6-vertical__price'))->getText();
    $nombreProd = $notebook->findElement(WebDriverBy::cssSelector('.product-card-design6-vertical__name'))->getText();

    // Limpio el precio para obtener solo los números
    $precioActual = preg_replace('/[^\d]/', '', $precioActual);

    echo "\n-------------INICIO--------------\n";    
    echo "producto: ".$nombreProd."\n";
    echo "precio: ".$precioActual."\n";
    echo "\n-------------FIN--------------\n";

} */

/* foreach($netsMercadoLibre as $notebook){
    $precioActual = $notebook->findElement(WebDriverBy::cssSelector('div.poly-price__current .andes-money-amount__fraction'))->getText();
    $nombreProd = $notebook->findElement(WebDriverBy::cssSelector('.poly-box.poly-component__title'))->getText();

    echo "\n-------------INICIO--------------\n";    
    echo "producto: ".$nombreProd."\n";
    echo "precio: ".$precioActual."\n";
    echo "\n-------------FIN--------------\n";
} */


/* foreach($netsFravega as $notebook){
    $precioActual = $notebook->findElement(WebDriverBy::cssSelector('.sc-1d9b1d9e-0.OZgQ'))->getText();
    $nombreProd = $notebook->findElement(WebDriverBy::cssSelector('.sc-ca346929-0.czeMAx'))->getText();

    echo "\n-------------INICIO--------------\n";    
    echo "producto: ".$nombreProd."\n";
    echo "precio: ".digitsOnly($precioActual)."\n";
    echo "\n-------------FIN--------------\n";
} */

/* 
foreach($netsMusimundo as $notebook){
    $precioActual = $notebook->findElement(WebDriverBy::cssSelector('span[data-test-item-price="item_price"]'))->getText();
    $nombreProd = $notebook->findElement(WebDriverBy::cssSelector('a[data-test-plp="item_name"]'))->getText();
    echo "\n-------------INICIO--------------\n";    
    echo "producto: ".$nombreProd."\n";
    echo "precio: ".digitsOnly($precioActual)."\n";
    echo "\n-------------FIN--------------\n";
} */

/* cada clave ($URL) guarda como valor una coleccion de clases ($infoNets) relacionadas con las notebooks de su respectiva página */
// creo una variable index para detectar en cuál elemento de mi arreglo asociativo estoy 
$index = 0;

foreach($ColURLs as $URL => $infoNets){
    $driver->get($URL);
    $index++;
    $colNets = $driver->findElements(WebDriverBy::cssSelector($infoNets['classNets']));
    foreach($colNets as $notebook){
        echo "\n------------\n INDICE NUMERO: ".$index."\n------------\n";
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
        /* 
        echo "\n-------------INICIO--------------\n";    
        echo "\nproducto: ".$nombreNet."\n";
        echo "\nprecio: ".digitsOnly($precioNet)."\n";
        echo "\n-------------FIN--------------\n"; */
        // datos de una notebook convertida en arreglo asociativo
        $netArrAssoc = dataFormatted($nombreNet,$precioNet,$URL);
        $ABMNotebook = new ABMNotebook;
        if($ABMNotebook->alta($netArrAssoc)){
            echo "\nnotebook ingresada exitosamente en la BD\n ";
        }else{
            echo "\nNotebook no ingresada.\n";
        }

    }
}

// Cierra el WebDriver
$driver->quit();