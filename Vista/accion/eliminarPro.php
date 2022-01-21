<?php
    include_once '../../config.php';
    $accion = true;
    $datos = data_submitted();
    if (isset($datos['idproducto'])){
        $buscaId['idproducto'] = $datos['idproducto'];
        $abmProducto = new AbmProducto();
        $producto = $abmProducto->buscar($buscaId);
    
        if (count($producto)>0){
            if ($abmProducto->baja($datos)){
                $msj = 'El producto se elimino con exito.';
                header("Location:../listaProductos.php?msj=$msj");
            } else {
                $msj = 'no se pudo eliminar el producto, intente de nuevo.';
                header("Location:../listaProductos.php?msjError=$msj");
            }
        } else{
            $msj = 'El producto a eliminar no existe, seleccione uno de la lista de productos.';
            header("Location:../listaProductos.php?msjError=$msj");
        }
    } else {
        $msj = 'El producto a eliminar no existe, seleccione uno de la lista de productos.';
        header("Location:../listaProductos.php?msjError=$msj");
    }
?>