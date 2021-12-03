<?php
class Rol{
    private $idRol;
    private $roDescripcion;
    private $msjOperacion;

    public function __construct(){
        $this->idRol = '';
        $this->roDescripcion = '';
        $this->msjOperacion = '';
    }
    public function set($idRol, $roDescripcion){
        $this->idRol = $idRol;
        $this->roDescripcion = $roDescripcion;
    }

    public function getId(){
        return $this->idRol;
    }
    public function getRoDescripcion(){
        return $this->roDescripcion;
    }
    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setId($id){
        $this->idRol = $id;
    }
    public function setRoDescripcion($roDescripcion){
        $this->roDescripcion = $roDescripcion;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Busca en la bd los datos con ese id y los carga en el objeto
     * @return bool */
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol WHERE idrol = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->set($row['idrol'], $row['rodescripcion']);
                    $resp = true;
                }
            }
        } else {
            $this->setMsjOperacion("rol->listar: ".$base->getError());
        }
        return $resp;
    }
    
    /** Si el registro se inserta en la bd retorna true, caso contrario false.
     * @return bool */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO rol VALUES('".$this->getId()."', '".$this->getRoDescripcion()."')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) == -1) {
                $resp = true;
            } else {
                $this->setMsjOperacion("rol->insertar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("rol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE rol SET rodescripcion = '".$this->getRoDescripcion()."' WHERE idrol = ". $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMsjOperacion("rol->modificar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("rol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM rol WHERE idrol = ".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMsjOperacion("rol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMsjOperacion("rol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol";
        if ($parametro != "") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new Rol();
                    $obj->set($row['idrol'], $row['rodescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMsjOperacion("rol->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
?>