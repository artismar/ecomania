<?php
    $title = 'Productos';
    include_once 'estructura/cabecera.php';
    include_once 'accion/listarProductos.php';
    $datos = data_submitted();
?>

<!-- PRODUCTOS -->
<div class="container">
    <div class="row m-5 text-center">
        <div class="col">
            <?php 
            if ($sesion->activa()){
                echo '<h5><span style="color: green;">'.$usuario->getUsNombre().'</span>, estos son todos nuestros productos.</h5>';
            } else{
                echo '<h5>Estos son todos nuestros productos.</h5>';
            }
            ?>
        </div>
    </div>
    <?php
        if (isset($datos['msjError'])){
            $msj = $datos['msjError'];
            echo '<div class="row text-center pt-2">
                <div class="col">
                <div class="alert alert-danger" role="alert">'.$msj.'</div class>
                </div>
                </div>';
        } elseif (isset($datos['msj'])){
            $msj = $datos['msj'];
            echo '<div class="row text-center pt-2">
                <div class="col">
                <div class="alert alert-success" role="alert">'.$msj.'</div class>
                </div>
                </div>';
        }
    ?>
    <hr>
    <div class="row m-5 row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php 
        listarProductos();
        ?>
    </div>
</div>






<?php
    include_once 'estructura/pie.php';
?>