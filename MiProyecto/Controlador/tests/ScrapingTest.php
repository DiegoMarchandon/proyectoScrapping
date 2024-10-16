<?php

use Symfony\Component\Panther\PantherTestCase;


// definimos la clase scrapingtest
//panthertestcase (esta es una clase hija de phpunit) es una clase base proporcionada 
//por Symfony Panther que permite realizar pruebas de integración
//y de extremo a extremo (end-to-end)
class ScrapingTest extends PantherTestCase
{   

    // declaramos las variables cliente y pdo que utilizamos para interactuar 
    //con el navegador y la base de datos durante las pruebas
    private $client;
    private $pdo;

/**
 * Configura el cliente Panther y la conexión a la base de datos antes de cada prueba.
 * Esta configuracion es importante!!! para asegurar que las pruebas se ejecuten en un entorno controlado y consistente.
 */
protected function setUp(): void
{
    // Configura la ruta del binario msedgedriver.
    // Esto es necesario para que Panther pueda encontrar y usar el controlador de Microsoft Edge.
    putenv('PANTHER_EDGE_DRIVER_BINARY_PATH=C:\Drivers\edgedriver_win64\msedgedriver.exe');

    // Crea un cliente Panther configurado para usar Microsoft Edge.
    // El cliente Panther se utiliza para interactuar con el navegador durante las pruebas.
    $this->client = static::createPantherClient([
        'external_base_uri' => 'http://localhost/proyectoScrapping/MiProyecto/Vista/', // URL base para las pruebas
        'browser' => 'msedge', // Usar 'msedge' para Microsoft Edge
        'port' => 63088// Usar un puerto diferente para evitar conflictos con otros servicios (si hay conflicto podemos usar otro puerto--block de notas)
    ]);

    // Configura la conexion a la base de datos usando PDO.
    // Esta conexión se utiliza para interactuar con la base de datos durante las pruebas.
    $dsn = 'mysql:host=localhost;dbname=bdnotebooks'; 
    $username = 'root'; 
    $password = ''; 
    $this->pdo = new PDO($dsn, $username, $password); // Crear una nueva instancia de PDO
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar PDO para lanzar excepciones (segun vi en un video :,) )
}


/**
 * Cierra el cliente Panther y la conexión a la base de datos despues de cada prueba.
 * es esto tambien es importante ya que puede generar conflictos (me paso :,) )
 */
protected function tearDown(): void
{
    // Cerrar el cliente Panther
    // Esto es necesario para liberar los recursos del navegador y evitar posibles conflictos en pruebas futuras.
    $this->client->quit();

    // Cerrar la conexión a la base de datos
    // Establecer la variable $pdo a null libera la conexion a la base de datos
    $this->pdo = null;
}




//-------------------------aca empezamos con los test ---------------------
    /**
     * Verifica que la pagina se carga correctamente
     */
    public function testCargaDePagina()
    {
        // Navega a la pagina scrappy.php
        $crawler = $this->client->request('GET', 'scrappy.php');

        // Verifica que el campo de entrada esta presente
        $this->assertGreaterThan(0, $crawler->filter('#busquedaInput')->count(), 'El campo de entrada #busquedaInput no se encontró en la página.');
    }

    /**
     * Verifica que el campo de entrada #busquedaInput esta presente
     */
    public function testPresenciaDeCampoBusqueda()
    {
        // Navega a la pagina scrappy.php
        $crawler = $this->client->request('GET', 'scrappy.php');

        // Verifica que el campo de entrada esta presente
        $this->assertGreaterThan(0, $crawler->filter('#busquedaInput')->count(), 'El campo de entrada #busquedaInput no se encontró en la página.');
    }

    /**
     * Verifica que el boton de búsqueda está presente
     */
    public function testPresenciaDeBotonBuscar()
    {
        // Navega a la página scrappy.php
        $crawler = $this->client->request('GET', 'scrappy.php');

        // Verifica que el botón de búsqueda está presente
        $this->assertGreaterThan(0, $crawler->filter('button[type="submit"]')->count(), 'El botón de búsqueda no se encontró en la página.');
    }

    /**
     * Verifica que el boton #BTNautoScrapping está presente
     */
    public function testPresenciaDeBotonAutoScrapping()
    {
        // Navega a la página scrappy.php
        $crawler = $this->client->request('GET', 'scrappy.php');

        // Verifica que el botón #BTNautoScrapping está presente
        $this->assertGreaterThan(0, $crawler->filter('#BTNautoScrapping')->count(), 'El botón #BTNautoScrapping no se encontró en la página.');
    }

    /**
     * Verifica que el elemento #progressTitle esta presente
     */
    public function testPresenciaDeTituloProgreso()
    {
        // Navega a la página scrappy.php
        $crawler = $this->client->request('GET', 'scrappy.php');

        // Verifica que el elemento #progressTitle está presente
        $this->assertGreaterThan(0, $crawler->filter('#progressTitle')->count(), 'El elemento #progressTitle no se encontró en la página.');
    }

    /**
     * Verifica que la base de datos contiene al menos un registro especifico
     * para que funque tenemos que colocar todos los datos de una columna si 
     */
    /*public function testVerificacionBaseDeDatos()
    {
        // Valor de prueba que debe existir en la base de datos
        $procesadorDePrueba = 'CORE';

        // Consulta para verificar que la base de datos contiene un registro específico
        $stmt = $this->pdo->prepare('SELECT Fullname, Marca, Procesador, Sitio, Precio FROM notebook WHERE Procesador = :procesador');
        $stmt->execute(['procesador' => $procesadorDePrueba]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Depuración: Imprimir el resultado de la consulta
        echo "Resultado de la consulta: " . print_r($result, true) . "\n";

        // Verifica que se encontro al menos un registro
        $this->assertGreaterThan(0, count($result), 'No se encontró ningún registro con el procesador esperado en la base de datos.');

        // Verifica que al menos uno de los registros cumple con los criterios esperados
        $registroEncontrado = false;
        foreach ($result as $registro) {
            if ($registro['Fullname'] === 'Notebook Lenovo' &&
                $registro['Marca'] === 'marca_de_prueba' &&
                $registro['Sitio'] === 'sitio_de_prueba' &&
                $registro['Precio'] == 12345) {
                $registroEncontrado = true;
                break;
            }
        }

        $this->assertTrue($registroEncontrado, 'No se encontró el registro esperado en la base de datos.');
    }
    */

    /**
     * Verifica que la base de datos contiene al menos un registro con el procesador "CORE"
     */
    public function testVerificacionProcesadorCore()
    {
        // Valor de prueba que debe existir en la base de datos
        $procesadorDePrueba = 'CORE';

        // Consulta para verificar que la base de datos contiene un registro específico
        $stmt = $this->pdo->prepare('SELECT Fullname, Marca, Procesador, Sitio, Precio FROM notebook WHERE Procesador = :procesador');
        $stmt->execute(['procesador' => $procesadorDePrueba]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Depuracion Imprimir el resultado de la consulta
        //echo "Resultado de la consulta: " . print_r($result, true) . "\n";

        // Verifica que se encontro al menos un registro
        $this->assertGreaterThan(0, count($result), 'No se encontró ningún registro con el procesador esperado en la base de datos.');
    }
}
