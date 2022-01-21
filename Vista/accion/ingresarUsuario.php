<?php
    include_once '../../config.php';
    $accion = true;
    $datos = data_submitted();
    $buscaEmail['usmail'] = $datos['usmail'];
    $abmUsuario = new AbmUsuario();
    $datos['uspass'] = md5($datos['uspass']); // encriptamos la pw

    if (count($abmUsuario->buscar($buscaEmail)) > 0){
        $msj = 'Ya existe un usuario con este email.';
        header("Location:../login.php?msjError=$msj");
    } else {
        if ($abmUsuario->alta($datos)){
            $msj = 'Usuario registrado.';
            header("Location:../login.php?msj=$msj");
        } else {
            $msj = 'No pudimos registrar el usuario.';
            header("Location:../login.php?msjError=$msj");
        }
    }
?>