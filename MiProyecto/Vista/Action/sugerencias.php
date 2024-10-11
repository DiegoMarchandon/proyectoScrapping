<?php 
require '../Composer/vendor/autoload.php';
require '../../Utils/funciones.php';
use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
$colNets = $ABMNotebook->buscar(null);
?>
<script>
    $(document).ready(function() {
        <?php 
           
        ?>
        
        $('#busquedaInput').on('input', function() {

            const inputValue = $(this).val();
    
            if (inputValue.length > 0) {
                $.ajax({
                    url: 'path/to/your/action/script.php', // Ruta al script en Action
                    method: 'GET',
                    data: { search: inputValue },
                    success: function(data) {
                        // Aquí deberías procesar y mostrar las sugerencias
                        $('#suggestions').html(data);
                    }
                });
            } else {
                $('#suggestions').empty(); // Limpiar sugerencias si no hay entrada
            }
        });
    });
</script>
