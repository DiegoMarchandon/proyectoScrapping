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

# Notas sobre la estructura MVC 
## Clase BaseDeDatos:
 tiene las funciones relacionadas directamente con la conexión y ejecución de consultas en la base de datos (como insertar, actualizar, eliminar, etc.). Esta clase no debe conocer los detalles del modelo de negocio (por ejemplo, que estás manejando notebooks).

## Clase Notebook: 
 Esta es la representación del modelo de datos (una notebook). Contiene los atributos y métodos que describen a una notebook, pero no maneja la lógica de actualización.

## Clase ABMNotebook (Alta, Baja, Modificación): 
 se colocan las funciones que interactúan con la clase BaseDeDatos para actualizar los registros de notebooks en la base de datos. Esta clase se encarga de coordinar el trabajo entre el modelo Notebook y la base de datos, y es donde aplicarás las reglas de negocio. Acá es donde mejor quedaría la función 'Actualizar'.