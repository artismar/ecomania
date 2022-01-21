<?php
    include_once "../../config.php";
    $sesion = new Session();
    $sesion->cerrar();
    $msj = 'Sesion cerrada.';
    header("Location:../login.php?msj=$msj");
?>