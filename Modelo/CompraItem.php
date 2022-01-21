<?php
class CompraItem{
    private $idCompraItem;
    private $producto; // Objeto del producto
    private $compra; // Objeto de la compra
    private $ciCantidad;
    private $msjOperacion;

    public function __construct(){
        $this->idCompraItem = '';
        $this->producto = '';
        $this->compra = '';
        $this->ciCantidad = '';
        $this->msjOperacion = '';
    }
    public function set($idCompraItem, $producto, $compra, $ciCantidad){
        $this->idCompraItem = $idCompraItem;
        $this->producto = $producto;
        $this->compra = $compra;
        $this->ciCantidad = $ciCantidad;
    }

    public function getId(){
        return $this->idCompraItem;
    }
    public function getProducto(){
        return $this->producto;
    }
    public function getCompra(){
        return $this->compra;
    }
    public function getCiCantidad(){
        return $this->ciCantidad;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idCompraItem = $id;
    }
    public function setProducto($producto){
        $this->producto = $producto;
    }
    public function setCompra($compra){
        $this->compra = $compra;
    }
    public function setCiCantidad($ciCantidad){
        $this->ciCantidad = $ciCantidad;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $producto = null;
                    $compra = null;
                    if ($row['idproducto'] != null){
                        $producto = new Producto();
                        $producto->setId($row['idproducto']);
                        $producto->cargar();
                    }
                    if ($row['idcompra'] != null){
                        $compra = new Compra();
                        $compra->setId($row['idcompra']);
                        $compra->cargar();
                    }
                    $this->set($row['idcompraitem'], $producto, $compra, $row['cicantidad']);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("compraitem->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        echo $this->getId();
        $sql = "INSERT INTO compraitem VALUES('".$this->getId()."', '".$this->getProducto()->getId()."', '".$this->getCompra()->getId()."', '".$this->getCiCantidad()."')";
        if ($base->Iniciar()) {
            $id = $base->Ejecutar($sql);
            if ($id > 0) {
                $this->setId($id);
                $this->cargar();
                $resp = true;
            } else {
                $this->setMsjOperacion("compraitem->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraitem->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET idproducto = '".$this->getProducto()->getId()."', idcompra = '".$this->getCompra()->getId()."', cicantidad '".$this->getCiCantidad()."' WHERE idcompraestado = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("compraitem->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraitem->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("compraitem->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("compraitem->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new CompraItem();
                    $producto = null;
                    $compra = null;
                    if ($row['idproducto'] != null){
                        $producto = new Producto();
                        $producto->setId($row['idproducto']);
                        $producto->cargar();
                    }
                    if ($row['idcompra'] != null){
                        $compra = new Compra();
                        $compra->setId($row['idcompra']);
                        $compra->cargar();
                    }
                    $obj->set($row['idcompraitem'], $producto, $compra, $row['cicantidad']);
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