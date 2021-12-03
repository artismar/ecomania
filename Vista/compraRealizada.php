<?php
    $title = 'Carrito';
    include_once 'estructura/cabecera.php';
    $datos = data_submitted();
?>

<div class="container m-5">
    <div class="row">
        <div class="col">
            <h4>La compra se realizo con exito!</h4>
            <a href="index.php" class='btn btn-primary'>Volver</a>
        </div>
    </div>
</div>




<?php
    include_once 'estructura/pie.php';
?>