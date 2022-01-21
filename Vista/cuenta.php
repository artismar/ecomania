<?php
    $segura = true;
    $title = 'Mi Cuenta';
    include_once 'estructura/cabecera.php';

    $id = 6; // id del menu cuenta
    include_once 'estructura/lateral.php';
?>

<!-- PRESENTACION DE LA SECCION 'CUENTA' -->
<div class="row">
    <div class="col">
        <h5>¡Hola <span style="color: green;"><?php echo $usuario->getUsNombre()?></span>!</h5>
        <p>
            En este menú puedes confirgurar tu cuenta y muchas cosas más. Cualquier consulta no dudes en contactarnos.
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