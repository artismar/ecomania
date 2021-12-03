<?php 
include_once "../../config.php";
$data = data_submitted();
$objControl = new AbmMenu();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idmenu'] = $elem->getId();
    $nuevoElem["menombre"] = $elem->getMeNombre();
    $nuevoElem["medescripcion"] = $elem->getMeDescripcion();
    $nuevoElem["idpadre"] = $elem->getMenuPadre();
    if($elem->getMenuPadre() != null){
        $nuevoElem["idpadre"] = $elem->getMenuPadre()->getMeNombre();
    }
    $nuevoElem["medeshabilitado"]=$elem->getMeDeshabilitado();
   
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida, null, 2);

?>