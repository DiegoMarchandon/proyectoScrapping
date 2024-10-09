mis tests deben estar dentro de la carpeta tests, empezar con el nombre del archivo a testear y terminar en Test, porque así funciona PHPunit

TestCase es una clase que nos da PHPunit 


Symfony Panther no ofrece una función específica para realizar múltiples solicitudes simultáneas en lugar de hacer múltiples llamados a $driver->get(). 
Panther está diseñado para interactuar con un navegador a través del protocolo WebDriver, que emula las interacciones de un usuario real en una página web, lo que significa que trabaja de manera secuencial: abre una página, interactúa con ella y luego pasa a la siguiente.

### en la siguiente línea:
```php
$driver = RemoteWebDriver::create($msedgedriverURL, $capabilities);
```
Estás creando una instancia de la clase RemoteWebDriver. Esta instancia, almacenada en $driver, es un objeto que representa una conexión a un navegador (en tu caso, Microsoft Edge) a través de WebDriver. Este objeto te permitirá controlar el navegador de forma remota, como abrir páginas, interactuar con elementos de la interfaz, y más.

### en la siguiente línea:
```php
$driver->get('https://www.musimundo.com/informatica/notebook/c/98');
```
Estás utilizando el objeto $driver para navegar a la URL especificada. El método get() le indica al navegador que cargue la página web en la dirección proporcionada, lo que inicia la interacción con esa página para extraer o manipular su contenido.

# El tipo de dato de $driver es un objeto de la clase RemoteWebDriver.