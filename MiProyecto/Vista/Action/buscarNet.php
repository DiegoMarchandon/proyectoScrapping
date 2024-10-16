
<?php
require '../Composer/vendor/autoload.php';
include '../estructura/header.php';
use Controlador\ABMNotebook;

$ABMNotebook = new ABMNotebook;
$datos = darDatosSubmitted();
$especificaciones = $datos['busquedaInput'];
$coincidenciasNet = null;
$coincidenciasNet = $ABMNotebook->returnMatches($especificaciones);

?>

    <div class="container mt-5">
        <div class="row">
            <?php if (empty($datos['busquedaInput']) || empty($coincidenciasNet)): ?>
                <h1>No hubo búsquedas relacionadas.</h1>
            <?php else: ?>
                <?php foreach($coincidenciasNet as $net): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $net['fullname']; ?></h5>
                                <p class="card-text">
                                    <strong>Marca:</strong> <?php echo $net['marca']; ?><br>
                                    <strong>Procesador:</strong> <?php echo $net['procesador']; ?><br>
                                    <strong>Sitio:</strong> <?php echo $net['sitio']; ?><br>
                                    <strong>Precio:</strong> <?php echo $net['precio']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
include ('../estructura/footer.php');
?>