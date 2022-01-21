<?php
    include_once '../../config.php';
    $accion = true;
    $sesion = new Session();
    $rolActual = $sesion->getRolActual();
    $datos = data_submitted();
    $seRealizo = false;
    if (isset($datos['accion'])){
        $abmCompraEstado = new AbmCompraEstado();
        // $compraEstado = $abmCompraEstado->buscar($datos);
        if ($datos['accion'] == 'cancelar' and isset($datos['idcompra'])){
            if ($abmCompraEstado->cancelar($datos['idcompra'])){
                $seRealizo = true;
            }
        } elseif ($datos['accion'] == 'aceptar' and isset($datos['idcompra'])){
            if ($abmCompraEstado->aceptar($datos['idcompra'])){
                $seRealizo = true;
            }
        } elseif ($datos['accion'] == 'enviar' and isset($datos['idcompra'])){
            if ($abmCompraEstado->enviar($datos['idcompra'])){
                $seRealizo = true;
            }
        }

        if ($datos['accion'] == 'cancelar'){
            if ($rolActual->getId() == 3){
                if ($seRealizo){
                    $msj = 'Tu compra fue cancelada con exito!';
                    header("Location:../verPedidos.php?msj=$msj");
                } else {
                    $msj = 'No pudimos cancelar tu compra, intente de nuevo.';
                    header("Location:../verPedidos.php?msjError=$msj");
                }
            } else {
                if ($seRealizo){
                    $msj = 'La compra fue cancelada con exito!';
                    header("Location:../gestionarPedidos.php?msj=$msj");
                } else {
                    $msj = 'No pudimos cancelar tu compra, intente de nuevo.';
                    header("Location:../gestionarPedidos.php?msjError=$msj");
                }
            }
        } elseif ($datos['accion'] == 'aceptar'){
            if ($seRealizo){
                $msj = 'La compra fue aceptada con exito.';
                header("Location:../gestionarPedidos.php?msj=$msj");
            } else {
                $msj = 'No pudimos aceptar la compra, intente de nuevo.';
                header("Location:../gestionarPedidos.php?msjError=$msj");
            }
        } elseif ($datos['accion'] == 'enviar'){
            if ($seRealizo){
                $msj = 'La compra fue enviada con exito.';
                header("Location:../gestionarPedidos.php?msj=$msj");
            } else {
                $msj = 'No pudimos enviar la compra, intente de nuevo.';
                header("Location:../gestionarPedidos.php?msjError=$msj");
            }
        }
    }
?>