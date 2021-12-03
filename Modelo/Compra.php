<?php
class Compra{
    private $idcompra;
    private $cofecha;
    private $usuario; // Object
    private $msjOperacion;

    public function __construct(){
        $this->idcompra = '';
        $this->cofecha = '';
        $this->usuario = '';
        $this->msjOperacion = '';
    }
    public function set($idcompra, $cofecha, $usuario){
        $this->idcompra = $idcompra;
        $this->cofecha = $cofecha;
        $this->usuario = $usuario;
    }

    public function getId(){
        return $this->idcompra;
    }
    public function getCofecha(){
        return $this->cofecha;
    }
    public function getUsuario(){
        return $this->usuario;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idcompra = $id;
    }
    public function setCoFecha($coFecha){
        $this->coFecha = $coFecha;
    }
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $usuario = new Usuario();
                    $usuario->setId($row['idusuario']);
                    $usuario->cargar();
                    $this->set($row['idcompra'], $row['cofecha'], $usuario);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("compra->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra VALUES('".$this->getId()."', '".$this->getCoFecha()."', '".$this->getUsuario()->getId()."')";
        if ($base->Iniciar()) {
            $id = $base->Ejecutar($sql);
            if ($id > 0) {
                $this->setId($id);
                $this->cargar();
                $resp = true;
            } else {
                $this->setMsjOperacion("compra->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compra->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha = '".$this->getCoFecha()."', idusuario= '".$this->getUsuario()->getId()."' WHERE idcompra = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("compra->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compra->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("compra->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compra->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new Compra();
                    $usuario = null;
                    if ($row['idusuario'] != null){
                        $usuario = new Usuario();
                        $usuario->setId($row['idusuario']);
                        $usuario->cargar();
                    }
                    $obj->set($row['idcompra'], $row['cofecha'], $usuario);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("compra->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>