<?php
class Menu{
    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $menuPadre; // Objeto del menu
    private $meDeshabilitado;
    private $msjOperacion;

    public function __construct(){
        $this->idMenu = '';
        $this->meNombre = '';
        $this->meDescripcion = '';
        $this->menuPadre = '';
        $this->meDeshabilitado = '';
        $this->msjOperacion = '';
    }
    public function set($idMenu, $meNombre, $meDescripcion, $menuPadre, $meDeshabilitado){
        $this->idMenu = $idMenu;
        $this->meNombre = $meNombre;
        $this->meDescripcion = $meDescripcion;
        $this->menuPadre = $menuPadre;
        $this->meDeshabilitado = $meDeshabilitado;
    }

    public function getId(){
        return $this->idMenu;
    }
    public function getMeNombre(){
        return $this->meNombre;
    }
    public function getMeDescripcion(){
        return $this->meDescripcion;
    }
    public function getMenuPadre(){
        return $this->menuPadre;
    }
    public function getMeDeshabilitado(){
        return $this->meDeshabilitado;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idMenu = $id;
    }
    public function setMeNombre($meNombre){
        $this->meNombre = $meNombre;
    }
    public function setMeDescripcion($meDescripcion){
        $this->meDescripcion = $meDescripcion;
    }
    public function setMenuPadre($menuPadre){
        $this->menuPadre = $menuPadre;
    }
    public function setMeDeshabilitado($meDeshabilitado){
        $this->meDeshabilitado = $meDeshabilitado;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idmenu = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $menuPadre = null;
                    if ($row['idpadre'] != null){
                        $menuPadre = new Menu();
                        $menuPadre->setId($row['idpadre']);
                        $menuPadre->cargar();
                    }
                    $this->set($row['idmenu'], $row['menombre'], $row['medescripcion'], $menuPadre, $row['medeshabilitado']);
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
        $menuPadre = 'null';
        if ($this->getMenuPadre() != null){
            $menuPadre = $this->getMenuPadre()->getId();
        }
        $sql = "INSERT INTO menu VALUES(".$this->getId().", '".$this->getMeNombre()."', '".$this->getMeDescripcion()."', ".$menuPadre.", '".$this->getMeDeshabilitado()."')";
        if ($base->Iniciar()) {
            $id = $base->Ejecutar($sql);
            if ($id > 0) {
                $this->setId($id);
                $this->cargar();
                $resp = true;
            } else {
                $this->setMsjOperacion("menu->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("menu->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $menuPadre = 'null';
        if ($this->getMenuPadre() != null){
            $menuPadre = $this->getMenuPadre()->getId();
        }
        $sql = "UPDATE menu SET menombre = '".$this->getMeNombre()."', medescripcion = '".$this->getMeDescripcion()."', idpadre = '".$menuPadre."', medeshabilitado = '".$this->getMeDeshabilitado()."' WHERE idmenu = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("menu->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("menu->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menu WHERE idmenu = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("menu->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new Menu();
                    // $menuPadre = null;
                    if ($row['idpadre'] != null){
                        $menuPadre = new Menu();
                        $menuPadre->setId($row['idpadre']);
                        $menuPadre->cargar();
                    } else{
                        $menuPadre = null;
                    }
                    $obj->set($row['idmenu'], $row['menombre'], $row['medescripcion'], $menuPadre, $row['medeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("menu->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>