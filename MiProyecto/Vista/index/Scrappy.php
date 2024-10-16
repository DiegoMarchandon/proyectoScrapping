<?php
include_once('../estructura/header.php');

?>
    <div id="scrappingContainer">
        <h3 id="progressTitle">Scrapping en progreso</h3>
        <div class="loadingDots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div id="progressBar" class="progress-bar">
            <p id="progressText"></p>   
            </div>
        </div>
    </div>
    <div id="mainContainer">
    
        <div id="VisibleContent">
            <div id="titleContainer">
                <img src="../Assets/IMGs/scrappyLogo2.png" alt="scrappy logo" height="90">
                <h3>Scrappy</h3>
            </div>
            <div class="neon-form">
                <form action="../Action/buscarNet.php" method="get" name="formBuscarNet" id="formBuscarNet">
                    <div class="mb-3">
                        <label for="especificaciones" class="form-label text-light">ingrese las especificaciones deseadas</label>
                        <input type="text" class="form-control neon-input" name="busquedaInput" id="busquedaInput" placeholder="Ej: marca, modelo, procesador...">
                        
                        <ul id="suggestions">
                            
                        </ul> <!-- donde se mostrarán las sugerencias -->
                    </div>
                    
                    <button type="submit" class="btn neon-btn w-100">Buscar</button>
                </form>
            </div>
        
            <div class="pages">
                <h4>páginas consultadas</h4>
                <div class="pages-logos">
                    <div class="logoContainer">
                        <a href="https://www.fravega.com/l/informatica/notebooks/">
                            <img class="logoClass" src="../Assets/IMGs/marca-fravega.png" alt="logo Fravega">
                        </a>
                    </div>
                    <div class="logoContainer">
                        <a href="https://www.garbarino.com/celulares-notebooks-y-tecnologia/informatica/notebooks-y-pc/notebooks"></a>
                        <img class="logoClass" src="../Assets/IMGs/marca-garbarino.png" alt="logo Garbarino">
                    </div>
                    <div class="logoContainer">
                        <a href="https://listado.mercadolibre.com.ar/notebook#D[A:notebook]">
                            <img class="logoClass" src="../Assets/IMGs/marca-mercadolibre.png" alt="logo Mercadolibre">
                        </a>
                    </div>
                    <div class="logoContainer">
                        <a href="https://www.musimundo.com/informatica/notebook/c/98">
                            <img class="logoClass" src="../Assets/IMGs/marca-musimundo.png" alt="logo Musimundo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    
    $('#BTNautoScrapping').click(function(e) {
        e.preventDefault();
        const pseudoElemento = $('<div id=ventana></div>');
        
        $('#mainContainer').append(pseudoElemento);

        $('#ventana').css({
            position: 'absolute',
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            background: 'rgba(0, 0, 0, 0.05)',
            'backdrop-filter': 'blur(10px)',
            'z-index': 9998
        });
        

        $('#scrappingContainer').css('visibility','visible');
        
        $('#VisibleContent').css({
            'z-index' : 1,
            position: 'relative'
        });

    // Enviar la solicitud AJAX al servidor para iniciar el scraping
    fetch('../Action/autoScrapping.php')
    // luego de recibida la respuesta, se ejecuta la función en el método then()
    // response = Respuesta HTTP 
        .then(response => {
            // el código que se ejecuta solo si la respuesta HTTP es recibida 
            // (la solicitud se completó exitosamente)
            if (response.ok) { 

                // respuesta json devuelta por el script de autoScrapping.php al final de la ejecución.
                if(response.json()){
                    // escondemos el contenedor que muestra la carga del scrapping
                    
                    $('#ventana').css({
                        position: '',
                        top: '',
                        left: '',
                        right: '',
                        bottom: '',
                        background: '',
                        'backdrop-filter': '',
                        'z-index': ''
                    });

                    $('#scrappingContainer').css('visibility','hidden');
                    $('#VisibleContent').css('visibility','visible');
                }
            } else {
                alert("Hubo un problema al iniciar el scraping.");
            }
        })
        .catch(error => console.error('Error al iniciar el scraping:', error));
    });
    
        fetch('../Action/sugerencias.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
        
        $(document).ready(function() {
            
            // variable para almacenar las notebooks sugeridas
            var colNetsSugeridas = [];
            $('#busquedaInput').on('input', function() {

                const inputValue = $(this).val();
                // $(this) = elemento que disparó el evento (input con el id)
                // .val() = valor actual dle campo de texto.

                if (inputValue.length > 2) {
                    // método AJAX de jquery que realiza una solicitud asíncrona a un servidor. 
                        // acá se utiliza para enviar una solicitud al servidor en busca de sugerencias basadas en lo que el usuario escribió. 
                    $.ajax({
                        // ruta que procesará la solicitud del servidor.
                        url: '../Action/sugerencias.php', // Ruta al script en Action
                        // tipo de solicitud HTTP. GET implicará que los datos se enviarán en la URL
                        method: 'GET',
                        // tipo de datos que se espera recibir de la respuesta. Obj o Array de formato JSON
                        // dataType: 'json',
                        // datos que se envían al servidor. Se trata de un objeto que contiene la cadena ingresada por el usuario.  
                        // data: { search: inputValue },
                        success: function(data) {
                            
                            var notebooks = JSON.parse(data);
                            var sugerenciasFilter = notebooks.filter(function(notebook){
                                return notebook.fullname.toLowerCase().includes(inputValue.toLowerCase());
                            });

                            // Limpiar sugerencias anteriores
                            $('#suggestions').empty();

                            $('#suggestions').css('height','200px');
                            // Mostrar nuevas sugerencias
                            sugerenciasFilter.forEach(function(sugerencia) {
                                $('#suggestions').append('<li class="itemSugerido" style="color:#01c1c1">' + sugerencia.fullname + '</li>');
                                
                            });

                            // Agregar evento click a los elementos de sugerencia
                            $('.itemSugerido').on('click', function() {
                                
                                console.log("nets sugeridas: "+colNetsSugeridas + "total: "+colNetsSugeridas.length);
                                // limpiamos el arreglo para almacenar esta única sugerencia (puesto que nuestras li ahora no estarán)
                                colNetsSugeridas = [];
                                // Al hacer clic en una sugerencia, agregarla a las sugerencias seleccionadas
                                colNetsSugeridas.push($(this).text());
                                console.log("net sugerida: "+ colNetsSugeridas + "total: "+colNetsSugeridas.length);
                                // almaceno en el input text la sugerencia de la net almacenada en colNetsSugeridas
                                $('#busquedaInput').val(colNetsSugeridas);
                                // y al input oculto, le agrego el id de la net seleccionada.
                                $('#suggestions').css('height', '0px'); // Ocultar sugerencias
                                $('#suggestions').empty(); // Limpiar las sugerencias
                            });

                        }
                    });
                } else {
                    $('#suggestions').css('height','0px');
                    $('#suggestions').empty(); // Limpiar sugerencias si no hay entrada
                }


            });
            
        });
    </script>
</body>
</html>
<?php
include ('../estructura/footer.php');
?>