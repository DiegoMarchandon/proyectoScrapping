<?php

/**
 * recupera los datos enviados ya sea por GET o POST, manteniendo el arreglo asociativo
 * @return array
 */
function darDatosSubmitted() {
    $datos = [];

    // Recogemos datos de POST y GET
    foreach ($_GET as $key => $value) {
        $datos[$key] = $value;
    }
    foreach ($_POST as $key => $value) {
        $datos[$key] = $value;
    }
    // Añadimos los datos del archivo
    if (array_key_exists('imagen',$_FILES) ) {
        $datos['imagen'] = $_FILES['imagen'];
    }
    return $datos;
}

/**
 * Recibe un objeto y convierte sus propiedades a un arreglo asociativo.
 * @param object $object
 * @return array  
 */
function dismount($object) {
    // con get_class obtenemos el nombre de la clase y reflectionClass obtenemos y manipulamos información sobre el $object
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();
    // recorremos la lista de propiedades de $reflectionClass (adquiridas de $object),
    foreach ($reflectionClass->getProperties() as $property) {
        // cambiamos la visibilidad de la propiedad a Accesible (en caso de que fuera private o protected), para poder acceder a sus valores.
        $property->setAccessible(true);
        // ingresamos el nombre de la propiedad como una clave en el arreglo asociativo creado, con su respectivo valor.
        $array[$property->getName()] = $property->getValue($object);
        // reestablecemos la visibilidad de la propiedad a su estado original. 
        $property->setAccessible(false);
    }
    return $array;
}

/**
 * Recibe un arreglo de objetos y devuelve un arreglo con arreglos asociativos.
 * @param array
 */
function convert_array($param) {
    $_AAux= array();
    if (!empty($param)) {
        if (count($param)){
            foreach($param as $obj) {
                // itera sobre el arreglo de objetos y los convierte a arreglos asociativos
                array_push($_AAux,dismount($obj));    
            }
        }
    }
    return $_AAux;
}
/* 
spl_autoload_register(function ($clase) {
    // echo "Cargamos la clase  ".$clase."<br>" ;

     $directorys = array(
         $GLOBALS['ROOT'].'Modelo/',
         $GLOBALS['ROOT'].'Control/',
         $GLOBALS['ROOT'].'Modelo/Conector/',
     );
     $found = false;
     $i = 0;
     while ($i < count($directorys) && !$found){
        if (file_exists($directorys[$i].$clase.'.php')){
            require_once($directorys[$i].$clase.'.php');
            $found = true;
        }
        $i++;
     }
 }); */

 

function SubirArchivoSubmitted() {
    $dir = '../../Archivos/'; // Definimos el Directorio donde se guarda el archivo
    $mensaje = ""; // Inicializamos la variable para almacenar el mensaje

    // Comprobamos que no se hayan producido errores
    if ($_FILES['archivo']["error"] <= 0) {
        $mensaje .= "Nombre: " . $_FILES['archivo']['name'] . "<br />";
        $mensaje .= "Tipo: " . $_FILES['archivo']['type'] . "<br />";
        $mensaje .= "Tamaño: " . ($_FILES['archivo']["size"] / 1024) . " kB<br />";
        $mensaje .= "Carpeta temporal: " . $_FILES['archivo']['tmp_name'] . "<br />";

        // Intentamos copiar el archivo al servidor.
        if (!copy($_FILES['archivo']['tmp_name'], $dir . $_FILES['archivo']['name'])) {
            $mensaje .= "ERROR: no se pudo cargar el archivo.";
        } else {
            $mensaje .= "El archivo " . $_FILES['archivo']['name'] . " se ha copiado con Éxito.<br />";
        }
    } else {
        $mensaje .= "ERROR: no se pudo cargar el archivo. No se pudo acceder al archivo Temporal.";
    }

    return $mensaje; // Devolvemos el mensaje
}

function SubirImagenSubmitted() {
    $dir = '../../Archivos/Imagenes/'; // Definimos el Directorio donde se guarda el archivo
    $mensaje = ""; // Inicializamos la variable para almacenar el mensaje

    // Comprobamos que no se hayan producido errores
    if ($_FILES['imagen']["error"] <= 0) {
        $mensaje .= "Nombre: " . $_FILES['imagen']['name'] . "<br />";
        $mensaje .= "Tipo: " . $_FILES['imagen']['type'] . "<br />";
        $mensaje .= "Tamaño: " . ($_FILES['imagen']["size"] / 1024) . " kB<br />";
        $mensaje .= "Carpeta temporal: " . $_FILES['imagen']['tmp_name'] . "<br />";

        // Intentamos copiar el archivo al servidor.
        if (!copy($_FILES['imagen']['tmp_name'], $dir . $_FILES['imagen']['name'])) {
            $mensaje .= "ERROR: no se pudo cargar el archivo.";
        } else {
            $mensaje .= "El archivo " . $_FILES['imagen']['name'] . " se ha copiado con Éxito.<br />";
        }
    } else {
        $mensaje .= "ERROR: no se pudo cargar el archivo. No se pudo acceder al archivo Temporal.";
    }

    return $mensaje; // Devolvemos el mensaje
}

/**
 * convierte decimales y/o floats a enteros y los retorna.
 * @param mixed
 * @return int
 */
function digitsOnly($number){

    // si la expresión "strstr($number, ',', true)" es verdadera (Existe una coma en el número) se devuelve el valor de esa expresion. Sino, devuelve $number.
    // después, al valor devuelto por el ternario de arriba le aplico la expresión regular preg_replace para eliminar todo caracter que no sea digito.
    // finalmente, convierto todo eso en intval, el cual retorna 0 si el valor no se pudo convertir. Caso contrario el dato convertido a Entero. 
    return intval(preg_replace('/\D/', '', strstr($number, ',', true) ?: $number));
}

/**
 * extrae de la cadena de texto enviada por parámetro el procesador y lo retorna si lo encuentra. 
 * el string por defecto "otro" en caso contrario.
 * @param string
 * @return string
 */
function extractProcessor($input){

    // aguja
    $needle = "otro";

    $colProcesadoresMercadoLibre = 
    [
        'A10','A12-Series','A4','A4-Series','A6','A6-Series','A8','A8-Series','A9',
        'A9-Series','Amd','Amd ryzen 5','AMD Ryzen 3','Apollo','Apple','Apple M2 Max','Apple M2 Pro','Athlon',
        'Athlon Gold','Athlon II','Athlon Silver','Athlon X2','Atom','C-Series','Celeron','Celeron Dual Core',
        'Centrino','Core','Core 2 Duo','Core Duo','Core i3','Core i4','Core i5','Core i6','Core i7','Core i9',
        'Core M','Core M3','E1','Exynos','i3','I5','i7','i7 11va','i7-1360P','I9','Inspiron','Intel','Intel Core',
        'Intel Core i5', 'Intel Core i7','Ios','M1','M2','M2 Pro','Mobile','Pentium','Pentium 4','Pentium Silver',
        'Pro','R7','Radeon','Ryzen','Ryzen 3','Ryzen 5','Ryzen 5 PRO','Ryzen 7','Ryzen 7 PRO','Ryzen 9','Snapdragon',
        'Turion','Turion 64 X2','Vision','Xeon'
    ];

    $colProcesadoresFravega = 
    [
        'Intel Core i5', 
        'AMD Ryzen 5', 
        'Intel Core i7',
        'Intel Core i3', 
        'AMD Ryzen 7', 
        'Apple M2',
        'Intel Celeron', 
        'AMD Ryzen 3', 
        'AMD', 
        'Intel Core Ultra 7', 
        'Apple M1', 
        'Apple M2 Pro', 
        'Intel Core Ultra 5', 
        'AMD Athlon', 
        'AMD Ryzen 9', 
        'CHIP M2', 
        'Intel Core Ultra 9', 
        'Intel Core i9', 
        'Intel Pentium'
    ];

    // los de musimundo
    $colProcesadoresMusimundo = 
    ['AMD Ryzen 5 5500U','Intel Core i5 13420H',
        'Intel N4020C',
        'Intel Celeron',
        'Intel Core i3 1215U',
        'AMD Ryzen 7 5700U',
        'Intel Core i3 N305',
        'AMD Ryzen 7 6800H',
        'Intel Core i7 1255U',
        'Intel Pentium Silver N5030',
        'Intel Celeron N4020',
        'AMD Ryzen 5 7520U',
        'Intel Core i5 1235U',
        'Intel Core i7 12700H',
        'Intel Core i7 M1 (Apple Chip)',
        'Intel Celeron N5100',
        'Intel Core i3 1025G1',
        'AMD Ryzen 5 5560U',
        'Intel Core i7 1165G7',
        'Intel Core i5-12450H',
        'Intel Core i7 11va Gen',
        'AMD Ryzen 5 5500U',
        'Intel Core i3 10ma Gen',
        'Intel Core i5 10ma Gen',
        'Intel Core i5 11va Gen',
        'AMD Ryzen 5 5700U',
        'Intel Core i7'
    ];

    $colProcesadores = array_merge($colProcesadoresFravega,$colProcesadoresMusimundo,$colProcesadoresMercadoLibre);    
    // coleccion de procesadores en un solo string y en mayúsculas.
    // $procesadoresString = strtoupper(implode(" ",$colProcesadores));
    // convierto el input a mayúsculas
    $upperInput = strtoupper($input);

    $bandera = false;
    $i = 0;
    do{
        if(str_contains($upperInput, strtoupper($colProcesadores[$i]))){
            $bandera = true;
            $needle = strtoupper($colProcesadores[$i]);
        }
        $i++;
    }while(!$bandera && $i < count($colProcesadores));

    return $needle;
}

/**
 * extrae de la cadena de texto enviada por parámetro la marca y la retorna.
 * el string por defecto "otro" en caso contrario.
 * @param string
 * @return string
 */
function extractBrand($input){
    
    $needle = "otra";

    // las de garbarino
    $colMarcasGarbarino = [
        'A4TECH', 'ACER', 'ASUS', 'DELL', 'HP', 'LENOVO', 'PCBOX', 'ENOVA'
    ];

    // las de fravega
    $colMarcasFravega = [
        'Acer','Aiwa','Amazfit' /* acer */,'Aorus','Apple','Asus','Bangho','BGH','Big Ninja' /* daewoo */,
        'Daewoo','Dell','Drax','eNova','Exo','Gateway','Gfast','Gigabyte' /* Aorus (solo acá) */,'HP',
        'Huawei','Lenovo','MSI','Nixvision','Noblex','NSX','Oasis','PCBox','Pixart',
        'Positivo BGH' /* BGH */,'Samsung'
    ];

    // las de mercadolibre
    $ColMarcasMercadolibre = [
        'Acer', 'Alienware', 'Apple', 'Asus', 'Bangho', 'BGH', 'Chuwi', 'Compaq', 'Coradir', 'CX', 
        'Daewoo', 'Dell', 'eMachines', 'EXO', 'Gateway', 'Gigabyte', 'Haier', 'HP', 'Huawei', 
        'Hyundai', 'IBM', 'Ken Brown', 'Lenovo', 'LG', 'Macbook', 'Medion', 'Microsoft', 'MSI', 
        'Noblex', 'Packard Bell', 'Philco', 'Positivo', 'Positivo BGH' /* BGH */, 'Razer', 'Samsung',
        'Sony', 'Sony VAIO', 'TCL', 'Toshiba','VAIO','ViewSonic','X-View'
    ];
    
    // las de musimundo
    $colMarcasMusimundo = [
        'ACER','ASUS','DAEWOO','E-NOVA','ENOVA','EXO','GFAST','HDC','HP','KANJI','LENOVO','NSX','PANACOM','SAMSUNG'
    ];
    
    // coleccion de marcas unidas y en mayúsculas.
    $colMarcas = array_merge($colMarcasGarbarino,$colMarcasFravega,$ColMarcasMercadolibre,$colMarcasMusimundo);
    // $marcasString = strtoupper(implode(" ",$colMarcas));

    // convierto el input a mayúsculas
    $upperInput = strtoupper($input);
    
    $bandera = false;
    $i = 0;
    do{
        if(str_contains($upperInput, strtoupper($colMarcas[$i]))){
            $bandera = true;
            $needle = strtoupper($colMarcas[$i]);
        }
        $i++;
    }while(!$bandera && $i < count($colMarcas));
    

    /* if(str_contains($marcasString,$upperInput)){
        $needle = $upperInput; 
    } */
    return $needle;
}

/**
 * recibe un arreglo indexado con el nombre + el precio
 * llama a las funciones de extracción / formateo y retorna un arreglo con los datos limpios y listos para insertar
 * @param string
 * @return array
 */
function dataFormatted($nombreNet,$precioNet, $URL){
    $arrFormat = [];
    $arrFormat['Marca'] = extractBrand($nombreNet);
    $arrFormat['Procesador'] = extractProcessor($nombreNet);
    $arrFormat['Precio'] = digitsOnly($precioNet);
    $arrFormat['Fullname'] = str_replace(['"',"'"],"", $nombreNet);
    if($URL == 'https://listado.mercadolibre.com.ar/notebook#D[A:notebook]'){
        $arrFormat['Sitio'] = 'Mercado Libre';
    }else if ($URL == 'https://www.garbarino.com/celulares-notebooks-y-tecnologia/informatica/notebooks-y-pc/notebooks'){
        $arrFormat['Sitio'] = 'Garbarino';
    }else if($URL == 'https://www.fravega.com/l/informatica/notebooks/'){
        $arrFormat['Sitio'] = 'Fravega';
    }else if($URL == 'https://www.musimundo.com/informatica/notebook/c/98'){
        $arrFormat['Sitio'] = 'Musimundo';
    }else{
        $arrFormat['Sitio'] = 'otro';
    }
    return $arrFormat;
} 
?>