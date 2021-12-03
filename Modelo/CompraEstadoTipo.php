<?php
class CompraEstadoTipo{
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $msjOperacion;

    public function __construct(){
        $this->idCompraEstadoTipo = '';
        $this->cetDescripcion = '';
        $this->cetDetalle = '';
        $this->msjOperacion = '';
    }
    public function set($idCompraEstadoTipo, $cetDescripcion, $cetDetalle){
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
        $this->cetDescripcion = $cetDescripcion;
        $this->cetDetalle = $cetDetalle;
    }

    public function getId(){
        return $this->idCompraEstadoTipo;
    }
    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }
    public function getCetDetalle(){
        return $this->cetDetalle;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idCompraEstadoTipo = $id;
    }
    public function setCetDescripcion($cetDescripcion){
        $this->cetDescripcion = $cetDescripcion;
    }
    public function setCetDetalle($cetDetalle){
        $this->cetDetalle = $cetDetalle;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->set($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("compraestadotipo->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestadotipo VALUES('".$this->getId()."', '".$this->getCetDescripcion()."', '".$this->getCetDetalle()."')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) == -1) {
                $resp = true;
            } else {
                $this->setMsjOperacion("compraestadotipo->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraestadotipo->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestadotipo SET cetdescripcion = '".$this->getCetDescripcion()."', cetdetalle = '".$this->getCetDetalle()."' WHERE idcompraestadotipo = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("compraestadotipo->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraestadotipo->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("compraestadotipo->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraestadotipo->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new CompraEstadoTipo();
                    $obj->set($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("compraestadotipo->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>