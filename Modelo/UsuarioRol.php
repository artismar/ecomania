<?php
class UsuarioRol{
    private $usuario; // Objeto del usuario
    private $rol; // Objeto del rol
    private $msjOperacion;

    public function __construct(){
        $this->usuario = '';
        $this->rol = '';
        $this->msjOperacion = '';
    }
    public function set($usuario, $rol){
        $this->usuario = $usuario;
        $this->rol = $rol;
    }

    public function getUsuario(){
        return $this->usuario;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    public function setRol($rol){
        $this->rol = $rol;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idusuario = ".$this->getUsuario()->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $usuario = null;
                    $rol = null;
                    if ($row['idusuario'] != null){
                        $usuario = new Usuario();
                        $usuario->setId($row['idusuario']);
                        $usuario->cargar();
                    }
                    if ($row['idrol'] != null){
                        $rol = new Rol();
                        $rol->setId($row['idrol']);
                        $rol->cargar();
                    }
                    $this->set($usuario, $rol);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("usuariorol->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol VALUES('".$this->getUsuario()->getId()."', '".$this->getRol()->getId()."')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) == -1) {
                $resp = true;
            } else {
                $this->setMsjOperacion("usuariorol->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuariorol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuariorol SET idrol = '".$this->getRol()->getId()."' WHERE idusuario = ". $this->getUsuario()->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("usuariorol->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuariorol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario = ".$this->getUsuario()->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("usuariorol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("usuariorol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new UsuarioRol();
                    $usuario = null;
                    $rol = null;
                    if ($row['idusuario'] != null){
                        $usuario = new Usuario();
                        $usuario->setId($row['idusuario']);
                        $usuario->cargar();
                    }
                    if ($row['idrol'] != null){
                        $rol = new Rol();
                        $rol->setId($row['idrol']);
                        $rol->cargar();
                    }
                    $obj->set($usuario, $rol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("compraitem->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>