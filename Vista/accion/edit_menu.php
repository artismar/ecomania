<?php
include_once "../../config.php";
$data = data_submitted();

$respuesta = false;
if (isset($_GET['idmenu'])){
    $data['idmenu'] = $_GET['idmenu'];
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
    $respuesta = $objC->modificacion($data);
    
    if (!$respuesta){

        $sms_error = " La accion MODIFICACION No pudo concretarse";
        
    }else $respuesta =true;
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>