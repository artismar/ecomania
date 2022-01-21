<?php
    include_once '../../config.php';
    $datos = data_submitted();
    $sesion = new Session();
    if ($sesion->activa()){
        $sesion->cambiarRolActual($datos['id']);
        header("Location:../index.php");
    } else{
        header("Location:../index.php");
    }
?>