<?php
class Usuario{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $msjOperacion;

    public function __construct(){
        $this->idUsuario = null;
        $this->usNombre = '';
        $this->usPass = '';
        $this->usMail = '';
        $this->usDeshabilitado = null;
        $this->msjOperacion = '';
    }
    public function set($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado){
        $this->idUsuario = $idUsuario;
        $this->usNombre = $usNombre;
        $this->usPass = $usPass;
        $this->usMail = $usMail;
        $this->usDeshabilitado = $usDeshabilitado;
    }

    public function getId(){
        return $this->idUsuario;
    }
    public function getUsNombre(){
        return $this->usNombre;
    }
    public function getUsPass(){
        return $this->usPass;
    }
    public function getUsMail(){
        return $this->usMail;
    }
    public function getUsDeshabilitado(){
        return $this->usDeshabilitado;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idUsuario = $id;
    }
    public function setUsNombre($usNombre){
        $this->usNombre = $usNombre;
    }
    public function setUsPass($usPass){
        $this->usPass = $usPass;
    }
    public function setUsMail($usMail){
        $this->usMail = $usMail;
    }
    public function setUsDeshabilitado($usDeshabilitado){
        $this->usDeshabilitado = $usDeshabilitado;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->set($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("usuario->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario VALUES('".$this->getId()."', '".$this->getUsNombre()."', '".$this->getUsPass()."', '".$this->getUsMail()."', '".$this->getUsDeshabilitado()."')";
        if ($base->Iniciar()) {
            $id = $base->Ejecutar($sql);
            if ($id > 0) {
                $this->setId($id);
                $this->cargar();
                $resp = true;
            } else {
                $this->setMsjOperacion("usuario->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuario->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usnombre = '".$this->getUsNombre()."', usmail = '".$this->getUsMail()."', usdeshabilitado = '".$this->getUsDeshabilitado()."' WHERE idusuario = ".$this->getId();
        echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("usuario->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuario->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function modificarPass(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET uspass = '".$this->getUsPass()."' WHERE idusuario = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("usuario->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuario->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("usuario->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuario->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new Usuario();
                    $obj->set($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("usuario->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>