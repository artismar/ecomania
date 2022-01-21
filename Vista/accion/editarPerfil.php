<?php
    include_once '../../config.php';
    $accion = true;

    $datos = data_submitted();
    if (isset($datos['usnombre'])){
        $buscaEmail['usmail'] = $datos['usmail'];
        $abmUsuario = new AbmUsuario();
        $existe = $abmUsuario->buscar($buscaEmail);
        if (count($existe) > 0 and $existe[0]->getId() != $datos['idusuario']){
            $msj = 'Ya existe un usuario con este email.';
            header("Location:../editPerfil.php?msjError=$msj");
        } else {
            if ($abmUsuario->modificacion($datos)){
                $msj = 'Tus datos fueron actualizados.';
                header("Location:../editPerfil.php?msj=$msj");
            } else {
                $msj = 'No pudimos actualizar tus datos.';
                header("Location:../editPerfil.php?msjError=$msj");
            }
        }
    } elseif (isset($datos['uspass'])){
        $abmUsuario = new AbmUsuario();

        if ($abmUsuario->modificacion($datos)){
            $msj = 'Tu contraseña fue actualizada.';
            header("Location:../login.php?msj=$msj");
        } else {
            $msj = 'No pudimos actualizar tu contraseña.';
            header("Location:../login.php?msjError=$msj");
        }
    }
    
    // $datos['uspass'] = md5($datos['uspass']); // encriptamos la pw
?>