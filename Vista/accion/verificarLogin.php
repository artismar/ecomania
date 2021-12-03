<?php
    include_once '../../config.php';
    $datos = data_submitted();
    $sesion = new Session();
    $sesion->iniciar($datos['usmail'], md5($datos['uspass']));
    if ($sesion->validar()){
        header("Location:../index.php");
    } else{
        $msj = $sesion->getMsjOperacion();
        $sesion->cerrar();
        header("Location:../login.php?msjError=$msj");
    }
?>