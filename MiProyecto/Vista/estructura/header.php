<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php $Titulo ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Incluir jQuery -->
    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script defer>
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
    <style>
        .input-hover:hover {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>

<!-- bg-light un fondo claro-->

<body class="bg-light" style="margin-bottom: 60px;">

    <nav class="navbar navbar-expand-lg bg-gradient shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-primary m-2 h1" href="../../../index.php">MENÚ PRINCIPAL</a>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="dropdown px-2">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            TP1
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="">Home</a></li>
                            <li><a class="dropdown-item" href="">Ver BD</a></li>
                            

                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            TP2
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="../../../TP2-PWD/Vista/index/ejercicio2.php">Ejercicio 2</a></li>                            
                            <li><a class="dropdown-item" href="../../../TP2-PWD/Vista/index/ejercicio3.php">Ejercicio 3</a></li>
                            <li><a class="dropdown-item" href="../../../TP2-PWD/Vista/index/ejercicio4.php">Ejercicio 4</a></li>
                        </ul>
                    </div>
                    <div class="dropdown px-2">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            TP3
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="../../../TP3-PWD/Vista/index/ejercicio1.php">Ejercicio 1</a></li>
                            <li><a class="dropdown-item" href="../../../TP3-PWD/Vista/index/ejercicio2.php">Ejercicio 2</a></li>
                            <li><a class="dropdown-item" href="../../../TP3-PWD/Vista/index/ejercicio3.php">Ejercicio 3</a></li>
                        </ul>
                    </div>
            </div>

            <header class="d-flex justify-content-center py-3">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="../index/buscarAuto.php" class="nav-link" data-bs-toggle="tooltip" 
                    title="Crear una pagina 'buscarAuto.php' que contenga un formulario en donde se solicite el numero
                    de patente de un auto, estos datos deberán ser enviados a una pagina 'accionBuscarAuto.php' en donde
                    usando la clase de control correspondiente, se soliciten los datos completos del auto que se corresponda con
                    la patente ingresada y mostrar los datos en una tabla. También deberán mostrar los carteles que crean
                    convenientes en caso de que no se encuentre ningún auto con la patente ingresada">Buscar un auto</a></li>

                    <li class="nav-item"><a href="../index/BuscarPersona.php" class="nav-link" data-bs-toggle="tooltip" 
                    title="Crear una página 'BuscarPersona.html' que contenga un formulario que permita cargar un
                    numero de documento de una persona. Estos datos serán enviados a una página 'accionBuscarPersona.php'
                    busque los datos de la persona cuyo documento sea el ingresado en el formulario los muestre en un nuevo
                    formulario; a su vez este nuevo formulario deberá permitir modificar los datos mostrados (excepto el nro de
                    documento) y estos serán enviados a otra página “ActualizarDatosPersona.php” que actualiza los datos de la
                    persona">Buscar una persona</a></li>

                    <li class="nav-item"><a href="../index/listaPersonas.php" class="nav-link" data-bs-toggle="tooltip" 
                    title="Crear una página 'listaPersonas.php' que muestre un listado con las personas que se
                    encuentran cargadas y un link a otra página “autosPersona.php” que recibe un dni de una persona y muestra
                    los datos de la persona y un listado de los autos que tiene asociados">Ver personas</a></li>

                    <li class="nav-item"><a href="../index/VerAutos.php" class="nav-link" data-bs-toggle="tooltip" 
                    title="Crear una pagina php “VerAutos.php”, en ella usando la capa de control correspondiente 
                    mostrar todos los datos de los autos que se encuentran cargados, de los dueños mostrar nombre y apellido.
                    En caso de que no se encuentre ningún auto cargado en la base mostrar un mensaje indicando que no hay
                    autos cargados">Ver autos</a></li>

                    <li class="nav-item"><a href="../index/NuevaPersona.php" class="nav-link" data-bs-toggle="tooltip" 
                    title=" Crear una página 'NuevaPersona.php' que contenga un formulario que permita solicitar todos
                    los datos de una persona. Estos datos serán enviados a una página 'accionNuevaPersona.php' que cargue
                    un nuevo registro en la tabla persona de la base de datos. Se debe mostrar un mensaje que indique si se
                    pudo o no cargar los datos de la persona">Añadir persona</a></li>

                    <li class="nav-item"><a href="../index/NuevoAuto.php" class="nav-link" data-bs-toggle="tooltip" 
                    title="Crear una página 'NuevoAuto.php' que contenga un formulario en el que se permita cargar
                    todos los datos de un auto (incluso su dueño). Estos datos serán enviados a una página
                    'accionNuevoAuto.php' que cargue un nuevo registro en la tabla auto de la base de datos. Se debe chequear
                    antes que la persona dueña del auto ya se encuentre cargada en la base de datos, de no ser así mostrar un
                    link a la página que permite carga una nueva persona. Se debe mostrar un mensaje que indique si se pudo o
                    no cargar los datos">Añadir auto</a></li>

                    <li class="nav-item"><a href="../index/CambioDuenio.php" class="nav-link" data-bs-toggle="tooltip" 
                    title="Crear una página “CambioDuenio.php” que contenga un formulario en donde se solicite el
                    numero de patente de un auto y un numero de documento de una persona, estos datos deberán ser enviados
                    a una página “accionCambioDuenio.php” en donde se realice cambio del dueño del auto de la patente
                    ingresada en el formulario. Mostrar mensajes de error en caso de que el auto o la persona no se encuentren
                    cargados">Cambiar titular de auto</a></li>
                </ul>
                <style>
                    .tooltip-inner {
                       background-color: #3498db; /* Cambia este valor al color que desees */
                        color: white; /* Cambia el color del texto si es necesario */
                    }
                </style>
            </header>


            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="dropdown px-2">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            TP1
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio1.php">Ejercicio 1</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio2.php">Ejercicio 2</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio3.php">Ejercicio 3</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio4.php">Ejercicio 4</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio5.php">Ejercicio 5</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio6.php">Ejercicio 6</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio7.php">Ejercicio 7</a></li>
                            <li><a class="dropdown-item" href="../../TP1-PWD/Vista/ejercicio8.php">Ejercicio 8</a></li>

                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            TP2
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="../../TP2-PWD/Vista/ejercicio2.php">Ejercicio 2</a></li>                            
                            <li><a class="dropdown-item" href="../../TP2-PWD/Vista/ejercicio3.php">Ejercicio 3</a></li>
                            <li><a class="dropdown-item" href="../../TP2-PWD/Vista/ejercicio4.php">Ejercicio 4</a></li>
                        </ul>
                    </div>
                    <div class="dropdown px-2">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            TP3
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="ejercicio1.php">Ejercicio 1</a></li>
                            <li><a class="dropdown-item" href="ejercicio2.php">Ejercicio 2</a></li>
                            <li><a class="dropdown-item" href="ejercicio3.php">Ejercicio 3</a></li>
                        </ul>
                    </div> -->
        </div>

        </div>
    </nav>
