<script>
    $(document).ready(function() {
        $('#sugerencias').on('input', function() {
            const query = $(this).val();
    
            if (query.length > 0) {
                $.ajax({
                    url: 'path/to/your/action/script.php', // Ruta al script en Action
                    method: 'GET',
                    data: { search: query },
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
