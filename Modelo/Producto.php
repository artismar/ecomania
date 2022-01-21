<?php
class Producto{
    private $idProducto;
    private $proNombre;
    private $proDetalle;
    private $proCantStock;
    private $proPrecio;
    private $msjOperacion;

    public function __construct(){
        $this->idProducto = '';
        $this->proNombre = '';
        $this->proDetalle = '';
        $this->proCantStock = '';
        $this->proPrecio = '';
        $this->msjOperacion = '';
    }
    public function set($idProducto, $proNombre, $proDetalle, $proCantStock, $proPrecio){
        $this->idProducto = $idProducto;
        $this->proNombre = $proNombre;
        $this->proDetalle = $proDetalle;
        $this->proCantStock = $proCantStock;
        $this->proPrecio = $proPrecio;
    }

    public function getId(){
        return $this->idProducto;
    }
    public function getProNombre(){
        return $this->proNombre;
    }
    public function getProDetalle(){
        return $this->proDetalle;
    }
    public function getProCantStock(){
        return $this->proCantStock;
    }
    public function getProPrecio(){
        return $this->proPrecio;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idProducto = $id;
    }
    public function setProNombre($proNombre){
        $this->proNombre = $proNombre;
    }
    public function setProDetalle($proDetalle){
        $this->proDetalle = $proDetalle;
    }
    public function setProCantStock($proCantStock){
        $this->proCantStock = $proCantStock;
    }
    public function setProPrecio($proPrecio){
        $this->proPrecio = $proPrecio;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idproducto = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->set($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['proprecio']);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("producto->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO producto VALUES('".$this->getId()."', '".$this->getProNombre()."', '".$this->getProDetalle()."', ".$this->getProCantStock().", ".$this->getProPrecio().")";
        if ($base->Iniciar()) {
            $id = $base->Ejecutar($sql);
            if ($id > 0) {
                $resp = true;
                $this->setId($id);
            } else {
                $this->setMsjOperacion("producto->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("producto->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET pronombre = '".$this->getProNombre()."', prodetalle = '".$this->getProDetalle()."', procantstock = ".$this->getProCantStock().", proprecio = ".$this->getProPrecio()." WHERE idproducto = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("producto->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("producto->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("producto->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new Producto();
                    $obj->set($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['proprecio']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("producto->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>