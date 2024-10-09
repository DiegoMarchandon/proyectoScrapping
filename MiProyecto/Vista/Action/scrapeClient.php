<?php

// require __DIR__.'/vendor/autoload.php';
require '../../vendor/autoload.php';
// echo __DIR__;
require '../../Utils/funciones.php';

use Symfony\Component\Panther\Client;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Symfony\Component\Panther\PantherTestCase;

/* Pasos:
1) buscar y copiar la ubicación de tu driver de Chrome. (no confundir driver con Ejecutable)
Ejemplo con mi driver de Edge: (C:\Drivers\edgedriver_win64\msedgedriver.exe) 
2) Ingresarla en el CMD (tal como está en el ejemplo de los paréntesis)
3) copia el puerto que te aparece (Ejemplo: ("msedgedriver was started successfully on port 64762."))
4) reemplazar el puerto (64762) en "Client::createSeleniumClient()
5) descomentar la variable "DesiredCapabilities::chrome() y comentar "DesiredCapabilities::microsoftEdge();"
6) ingresar "goog:chromeOptions" en lugar de "ms:edgeOptions"
7) Ahora sí, ejecutar este script :,)

Bueno eso fue todo amigos de Youtube, like y suscribiros para más
*/

// ruta al EJECUTABLE de Microsoft Edge
$rutaExe = 'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe';

// ruta al DRIVER de Microsoft Edge (msedgedriver), (no sé si lo tomaría igual en caso de que ya se encuentre en el PATH)
$msedgedriver = 'C:\\Drivers\\edgedriver_win64\\msedgedriver.exe';

$capabilities = DesiredCapabilities::microsoftEdge();
// $capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability('ms:edgeOptions',[
    
    'binary' => $rutaExe,
    'args' => [ '--disable-gpu','--no-sandbox']
]);

// $client = Client::createChromeClient();
// la diferencia entre createSeleniumClient() y createChromeClient() es que (según chatGPT) Selenium permite ejecutar las pruebas en diferentes navegadores (No solo en Chrome) y diferentes plataformas.  
$client = Client::createSeleniumClient('http://localhost:56377',$capabilities);
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

$index = 0;
foreach ($ColURLs as $URL => $infoNets) {
    // Accedemos a la URL con el cliente de Panther
    $crawler = $client->request('GET', $URL);
    $index++;

    // Seleccionamos los elementos de la página
    $colNets = $crawler->filter($infoNets['classNets']);
    
    // Recorremos cada notebook encontrada
    $colNets->each(function ($notebook) use ($infoNets, $index, $URL) {
        echo "\n------------\n INDICE NUMERO: " . $index . "\n------------\n";

        // Para manejar la espera y evitar errores en Musimundo, verificamos si estamos en el índice correspondiente
        if ($index == 4) {
            try {
                $nombreNet = $notebook->filter($infoNets['nombreNet'])->text();
            } catch (\Exception $e) {
                $nombreNet = "Nombre no disponible";
                echo "Error al obtener el nombre en la URL: $URL\n";
                echo "Mensaje de error: " . $e->getMessage() . "\n";
            }
        } else {
            $nombreNet = $notebook->filter($infoNets['nombreNet'])->text();
        }

        $precioNet = $notebook->filter($infoNets['precioNet'])->text();

        // Imprimimos los resultados
        echo "\n-------------INICIO--------------\n";
        echo "Producto: " . $nombreNet . "\n";
        echo "Precio: " . digitsOnly($precioNet) . "\n";
        echo "\n-------------FIN--------------\n";
    });
}

// Finalizamos el cliente (esto no es necesario con Panther, ya que se maneja automáticamente)
