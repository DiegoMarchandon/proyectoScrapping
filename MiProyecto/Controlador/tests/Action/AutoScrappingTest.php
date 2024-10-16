<?php

use Symfony\Component\Panther\PantherTestCase;

class AutoScrappingIntegrationTest extends PantherTestCase
{
    private $client;
    private $pdo;

    protected function setUp(): void
    {
        // Configura la ruta del binario msedgedriver.
        putenv('PANTHER_EDGE_DRIVER_BINARY_PATH=C:\Drivers\edgedriver_win64\msedgedriver.exe');

        // Crea un cliente Panther configurado para usar Microsoft Edge.
        $this->client = static::createPantherClient([
            'external_base_uri' => 'http://localhost/proyectoScrapping/MiProyecto/Vista/', // URL base para las pruebas
            'browser' => 'msedge', // Usar 'msedge' para Microsoft Edge
            'port' => 63088 // Usar un puerto diferente para evitar conflictos con otros servicios
        ]);

        // Configura la conexión a la base de datos usando PDO.
        $dsn = 'mysql:host=localhost;dbname=bdnotebooks'; 
        $username = 'root'; 
        $password = ''; 
        $this->pdo = new PDO($dsn, $username, $password); 
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void
    {
        // Cerrar el cliente Panther
        $this->client->quit();

        // Cerrar la conexión a la base de datos
        $this->pdo = null;
    }


    //prueba de integración que verifique que el script autoScrapping.php se 
    //ejecuta correctamente y que los datos se guardan en la base de datos.
    public function testScrapingFunctionality()
    {
        // URL de prueba
        $url = 'http://localhost/proyectoScrapping/MiProyecto/Vista/Action/autoScrapping.php';

        // Navega a la URL de prueba.
        $crawler = $this->client->request('GET', $url);

        // Verifica que la página se carga correctamente.
        $this->assertStringContainsString('status', $crawler->filter('body')->text(), 'La página no se cargó correctamente.');

        // Verifica que los datos se han guardado en la base de datos.
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM notebook');
        $count = $stmt->fetchColumn();

        // Verifica que se han insertado registros en la base de datos.
        $this->assertGreaterThan(0, $count, 'No se insertaron registros en la base de datos.');
    }
}