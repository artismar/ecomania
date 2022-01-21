<?php 
date_default_timezone_set('America/Argentina/Buenos_Aires'); // Obtener fecha actual en argentina
include_once "../../config.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['menombre'])){
    $objC = new AbmMenu();
    if (!isset($data['idpadre'])){
        $data['idpadre'] = null;
    }
    if (!isset($data['medeshabilitado'])){
        $data['medeshabilitado'] = 'null';
    } else {
        $hoy = getdate();
        $data['medeshabilitado'] = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];
    }
    $respuesta = $objC->alta($data);
    if (!$respuesta){
        $mensaje = " La accion  ALTA No pudo concretarse";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>