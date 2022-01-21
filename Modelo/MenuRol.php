<?php
class MenuRol{
    private $menu; // Objeto del menu
    private $rol; // Objeto del rol
    private $msjOperacion;

    public function __construct(){
        $this->menu = null;
        $this->rol = null;
        $this->msjOperacion = '';
    }
    public function set($menu, $rol){
        $this->menu = $menu;
        $this->rol = $rol;
    }

    public function getMenu(){
        return $this->menu;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setMenu($menu){
        $this->menu = $menu;
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
        $sql = "SELECT * FROM menurol WHERE idmenu = ".$this->getMenu()->getId()." AND idrol = ".$this->getRol()->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $menu = null;
                    $rol = null;;
                    if ($row['idmenu'] != null){
                        $menu = new Menu();
                        $menu->setId($row['idmenu']);
                        $menu->cargar();
                    }
                    if ($row['idrol'] != null){
                        $rol = new Rol();
                        $rol->setId($row['idrol']);
                        $rol->cargar();
                    }
                    $this->set($menu, $id);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("menurol->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol VALUES('".$this->getMenu()->getId()."', '".$this->getRol()->getId()."')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) == -1) {
                $resp = true;
            } else {
                $this->setMsjOperacion("menurol->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("menurol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menurol SET idrol = '".$this->getRol()->getId()."' WHERE idmenu = ". $this->getMenu()->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("menurol->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("menurol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menurol WHERE idmenu = ".$this->getMenu()->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("menurol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("menurol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new MenuRol();
                    $menu = null;
                    $rol = null;
                    if ($row['idmenu'] != null){
                        $menu = new Menu();
                        $menu->setId($row['idmenu']);
                        $menu->cargar();
                    }
                    if ($row['idrol'] != null){
                        $rol = new Rol();
                        $rol->setId($row['idrol']);
                        $rol->cargar();
                    }
                    $obj->set($menu, $rol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("menurol->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>