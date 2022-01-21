<?php
    include_once '../../config.php';
    $accion = true;
    $datos = data_submitted();
    $sesion = new Session();
    $seRealizo = false;
    
    if (isset($datos['accion'])){
        $abmProducto = new AbmProducto();
        $producto = $abmProducto->buscar($datos);
        if ($datos['accion'] == 'agregar' and isset($datos['cantidad']) and isset($datos['idproducto'])){
            if ($sesion->agregarProducts($datos['idproducto'], $datos['cantidad'])){
                $seRealizo = true;
            }
        } elseif ($datos['accion'] == 'eliminar' and isset($datos['idproducto'])){
            if ($sesion->eliminarProducts($datos['idproducto'])){
                $seRealizo = true;
            }
        } elseif ($datos['accion'] == 'vaciar'){
            $sesion->vaciarCarrito();
            $seRealizo = true;
        }

        if ($datos['accion'] == 'agregar'){
            if ($seRealizo){
                $msj = 'Agregamos '.$datos['cantidad'].' '.$producto[0]->getProNombre().'.';
                header("Location:../productos.php?msj=$msj");
            } else {
                $msj = 'No pudimos agregar el producto al carrito, intente de nuevo.';
                header("Location:../productos.php?msjError=$msj");
            }
        } elseif ($datos['accion'] == 'eliminar'){
            if ($seRealizo){
                $msj = 'Eliminamos '.$producto[0]->getProNombre().' del carrito.';
                header("Location:../carrito.php?msj=$msj");
            } else {
                $msj = 'No pudimos eliminar el producto, intente de nuevo.';
                header("Location:../carrito.php?msjError=$msj");
            }
        } elseif ($datos['accion'] == 'vaciar'){
            if ($seRealizo){
                $msj = 'Eliminamos todos los productos del carrito.';
                header("Location:../carrito.php?msj=$msj");
            } else {
                $msj = 'No pudimos vaciar el carrito, intenta de nuevo.';
                header("Location:../carrito.php?msjError=$msj");
            }
        }
    }
?>