<?php
    include_once '../../config.php';

    $sesion = new Session();
    $abmProducto = new AbmProducto();
    $rolActual = $sesion->getRolActual();

    if ($sesion->activa()){
        if ($rolActual->getId() == 3){
            $products = $sesion->getProducts();
            if ($abmProducto->verificoStockYRetiro($products)){
                if ($sesion->realizoCompra()){
                    header("Location:../compraRealizada.php");
                }
            } else {
                $msj = $abmProducto->getMsjOperacion();
                header("Location:../carrito.php?msjError=$msj");
            }
        } else {
            $msj = 'Debes cambiar tu rol a cliente para realizar tu pedido.';
            header("Location:../carrito.php?msjError=$msj");
        }
    } else{
        $msj = 'Debes iniciar sesion para realizar una compra.';
        header("Location:../login.php?msjError=$msj");
    }
?>