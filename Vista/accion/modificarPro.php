<?php
    include_once '../../config.php';
    $accion = true;
    $datos = data_submitted();
    if (isset($datos['idproducto'])){
        $buscaId['idproducto'] = $datos['idproducto'];
        $buscaNombre['pronombre'] = $datos['pronombre'];
        $abmProducto = new AbmProducto();
        $productoSinAct = $abmProducto->buscar($buscaId);
        $mismoNombre = $abmProducto->buscar($buscaNombre);
    
        if (count($mismoNombre) > 0 and $mismoNombre[0]->getId() != $productoSinAct[0]->getId()){
            $msj = 'Ya existe otro poducto con este mismo nombre.';
            header("Location:../modificarProducto.php?idproducto=".$datos['idproducto']."&msjError=$msj");
        } else {
            if ($abmProducto->modificacion($datos, $_FILES)){
                $msj = 'El producto fue modificado con exito.';
                header("Location:../listaProductos.php?msj=$msj");
            } else {
                $msj = 'No pudimos modificar el producto, intente de nuevo.';
                header("Location:../listaProductos.php?msjError=$msj");
            }
        }
    }
?>