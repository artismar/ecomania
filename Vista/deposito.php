<?php
    $segura = true;
    $title = 'Deposito';
    include_once 'estructura/cabecera.php';

    $id = 5; // id del menu deposito
    include_once 'estructura/lateral.php';
?>

<!-- PRESENTACION DE LA SECCION 'DEPOSITO' -->
<div class="row">
    <div class="col">
        <h5>¡Hola <span style="color: green;"><?php echo $usuario->getUsNombre()?></span>!</h5>
        <p>
            En este menú puedes gestionar los productos de la tienda.
            <br><br>
            <span class="blockquote-footer">Pequeños habitos, grandes cambios. &#128154</span>
        </p>
    </div>
</div>







<!-- 3 cierres de div completando la estructura del menu lateral -->
</div>
</div>
</div>


<?php
    include_once 'estructura/pie.php';
?>