<?php
class CompraEstado{
    private $idCompraEstado;
    private $compra; // Objeto de la compra
    private $compraEstadoTipo; // Objeto del tipo de estado de la compra
    private $ceFechaIni;
    private $ceFechaFin;
    private $msjOperacion;

    public function __construct(){
        $this->idCompraEstado = '';
        $this->compra = '';
        $this->compraEstadoTipo = '';
        $this->ceFechaIni = '';
        $this->ceFechaFin = '';
        $this->msjOperacion = '';
    }
    public function set($idCompraEstado, $compra, $compraEstadoTipo, $ceFechaIni, $ceFechaFin){
        $this->idCompraEstado = $idCompraEstado;
        $this->compra = $compra;
        $this->compraEstadoTipo = $compraEstadoTipo;
        $this->ceFechaIni = $ceFechaIni;
        $this->ceFechaFin = $ceFechaFin;
    }

    public function getId(){
        return $this->idCompraEstado;
    }
    public function getCompra(){
        return $this->compra;
    }
    public function getCompraEstadoTipo(){
        return $this->compraEstadoTipo;
    }
    public function getCeFechaIni(){
        return $this->ceFechaIni;
    }
    public function getCeFechaFin(){
        return $this->ceFechaFin;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idCompraEstado = $id;
    }
    public function setCompra($compra){
        $this->compra = $compra;
    }
    public function setCompraEstadoTipo($compraEstadoTipo){
        $this->compraEstadoTipo = $compraEstadoTipo;
    }
    public function setCeFechaIni($ceFechaIni){
        $this->ceFechaIni = $ceFechaIni;
    }
    public function setCeFechaFin($ceFechaFin){
        $this->ceFechaFin = $ceFechaFin;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $compra = new Compra();
                    $compra->setId($row['idcompra']);
                    $compra->cargar();
                    $compraEstadoTipo = new CompraEstadoTipo();
                    $compraEstadoTipo->setId($row['idcompraestadotipo']);
                    $compraEstadoTipo->cargar();
                    $this->set($row['idcompraestado'], $compra, $compraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("compraestado->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestado VALUES('".$this->getId()."', '".$this->getCompra()->getId()."', '".$this->getCompraEstadoTipo()->getId()."', '".$this->getCeFechaIni()."', '".$this->getCeFechaFin()."')";
        if ($base->Iniciar()) {
            $id = $base->Ejecutar($sql);
            if ($id > 0) {
                $this->setId($id);
                $this->cargar();
                $resp = true;
            } else {
                $this->setMsjOperacion("compraestado->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraestado->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestado SET idcompra = '".$this->getCompra()->getId()."', idcompraestadotipo = '".$this->getCompraEstadoTipo()->getId()."', cefechaini = '".$this->getCeFechaIni()."', cefechafin = '".$this->getCeFechaFin()."' WHERE idcompraestado = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("compraestado->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraestado->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestado WHERE idcompraestado = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("compraestado->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraestado->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new CompraEstado();
                    $compra = null;
                    $compraEstadoTipo = null;
                    if ($row['idcompra'] != null){
                        $compra = new Compra();
                        $compra->setId($row['idcompra']);
                        $compra->cargar();
                    }
                    if ($row['idcompraestadotipo'] != null){
                        $compraEstadoTipo = new CompraEstadoTipo();
                        $compraEstadoTipo->setId($row['idcompraestadotipo']);
                        $compraEstadoTipo->cargar();
                    }
                    $obj->set($row['idcompraestado'], $compra, $compraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("compraestado->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>