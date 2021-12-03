<?php 
include_once '../../config.php';
$datos = data_submitted();
$abmMenu = new AbmMenu();
$menus = $abmMenu->menusPadres();
$arreglo_salida =  array();
foreach ($menus as $elem){
    $nuevoElem["idmenu"] = $elem->getId();
    $nuevoElem["menombre"] = $elem->getMeNombre();
    $nuevoElem["medescripcion"] = $elem->getMeDescripcion();
    if($elem->getMenuPadre() != null){
        $nuevoElem["idpadre"] = $elem->getMenuPadre()->getMeNombre();
    } else {
        $nuevoElem["idpadre"] = $elem->getMenuPadre();
    }
    array_push($arreglo_salida, $nuevoElem);
}

echo json_encode($arreglo_salida, null, 2);
?>