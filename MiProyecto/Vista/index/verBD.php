<?php

require '../Composer/vendor/autoload.php';
include '../estructura/header.php';
use Controlador\ABMNotebook;
$ABMNotebook = new ABMNotebook;  
$colNets = $ABMNotebook->buscarArray(null);

?>

        <div class="card bg-dark text-light">
                <div class="card-header">
                    <h4>Lista de notebooks</h4>
                </div>
                <div class="card-body">
                    <table id="tablaBD" class="table table-dark table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Marca</th>
                            <th>Procesador</th>
                            <th>Sitio</th>
                            <th>Precio</th>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($colNets) && count($colNets) > 0) {
                                foreach ($colNets as $key => $value) {
                                    echo '<tr>';
                                    echo '<td>' . $colNets[$key]['id'] . '</td>';
                                    echo '<td>' . $colNets[$key]['fullname'] . '</td>';
                                    echo '<td>' . $colNets[$key]['marca'] . '</td>';
                                    echo '<td>' . $colNets[$key]['procesador'] . '</td>';
                                    echo '<td>' . $colNets[$key]['sitio'] . '</td>';
                                    echo '<td>' . $colNets[$key]['precio'] . '</td>';
                                    echo '<tr>';
                                }
                            } else echo '<tr><td colspan="6">No hay notebooks cargadas.</td></tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" mb-5"></div>
    </body>
</html>
<?php 

include_once('../estructura/footer.php');
?>