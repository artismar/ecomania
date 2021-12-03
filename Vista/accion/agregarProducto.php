<?php
    include_once '../../config.php';
    $accion = true;
    $datos = data_submitted();
    $buscaNombre['pronombre'] = $datos['pronombre'];
    $abmProducto = new AbmProducto();

    if (count($abmProducto->buscar($buscaNombre)) > 0){
        $msj = 'Ya existe un poducto con este nombre.';
        header("Location:../agregarProducto.php?msjError=$msj");
    } else {
        if ($abmProducto->alta($datos, $_FILES)){
            $msj = 'El producto fue agregado con exito.';
            header("Location:../listaProductos.php?msj=$msj");
        } else {
            $msj = 'No pudimos agregar el producto.';
            header("Location:../agregarProducto.php?msjError=$msj");
        }
    }
?>