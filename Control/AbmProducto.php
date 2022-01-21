<?php
class AbmProducto{
    private $msjOperacion;


    public function getMsjOperacion(){
        return $this->msjOperacion;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        if (!isset($datos['idproducto'])){
            $datos['idproducto'] = null;
        }
        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (array_key_exists('idproducto', $datos) and array_key_exists('pronombre', $datos) and array_key_exists('prodetalle', $datos) and array_key_exists('proprecio', $datos) and array_key_exists('procantstock', $datos)){
            $objeto = new Producto();
            $objeto->set($datos['idproducto'], $datos['pronombre'], $datos['prodetalle'], $datos['procantstock'], $datos['proprecio']);
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idproducto']) ){
            $objeto = new Producto();
            $objeto->set($datos['idproducto'], null, null, null, null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idproducto'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idproducto']))
                $where .= " and idproducto = ".$datos['idproducto'];
            if  (isset($datos['pronombre']))
                 $where .= " and pronombre = '".$datos['pronombre']."'";
            if  (isset($datos['prodetalle']))
                $where .= " and prodetalle = '".$datos['prodetalle']."'";
            if  (isset($datos['procantstock']))
                $where .= " and procantstock = ".$datos['procantstock'];
            if  (isset($datos['proprecio']))
            $where .= " and proprecio = ".$datos['proprecio'];
        }
        $objetos = Producto::listar($where);
        return $objetos;
    }

    /** Permite ingresar un registro.
     * @param array $datos
     * @return boolean */
    public function alta($datos, $imagen){
        $alta = false;
        $objeto = $this->cargarObjeto($datos);
            if ($objeto != null and $objeto->insertar()){
                $this->cargarImagen($imagen, $objeto->getId());
                $alta = true;
            }
        return $alta;
    }

    /** Permite eliminar un registro.
     * @param array $datos
     * @return boolean */
    public function baja($datos){
        $baja = false;
        if ($this->seteadosCamposClaves($datos)){
            $objeto = $this->cargarObjetoConClave($datos);
            if ($objeto!=null and $objeto->eliminar()){
                $this->deleteImagen($objeto->getId());
                $baja = true;
            }
        }
        return $baja;
    }

    /** Permite modificar un registro.
     * @param array $datos
     * @return boolean */
    public function modificacion($datos, $imagen){
        $modificar = false;
        if ($this->seteadosCamposClaves($datos)){
            $objeto = $this->cargarObjeto($datos);
            if($objeto != null and $objeto->modificar()){
                $this->cargarImagen($imagen, $objeto->getId());
                $modificar = true;
            }
        }
        return $modificar;
    }

    public function convertirObjArray($obj){
        $array = array();
        $array['idproducto'] = $obj->getId();
        $array['pronombre'] = $obj->getProNombre();
        $array['prodetalle'] = $obj->getProDetalle();
        $array['procantstock'] = $obj->getProCantStock();
        $array['proprecio'] = $obj->getProPrecio();
        return $array;
    }

    public function cargarImagen($imagen, $id){
        $carpeta = "../../image/";
        $ext = strtolower(pathinfo($imagen['proimagen']['name'], PATHINFO_EXTENSION));
        $url = $carpeta."productoid_".$id.'.'.$ext;
        $seCargo = false;
        if ($imagen['proimagen']['error']<=0){
            if (($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') and $imagen["proimagen"]["size"] < 1e+7){ // restricciones = que coincida con estos formatos y que pese menos de 10 MB
                if (move_uploaded_file($imagen["proimagen"]["tmp_name"], $url)){
                    if ($ext == "jpg" || $ext == "jpeg"){
                        $newImagen = imagecreatefromjpeg($url);
                        imagejpeg($newImagen, '../../image/comproductoid_'.$id.'.jpg', 50);
                    } else{
                        $newImagen = imagecreatefrompng($url);
                        imagepng($newImagen, '../../image/comproductoid_'.$id.'.png', 50);
                    }
                    $seCargo = true;
                }
            }
        }
    }

    public function deleteImagen($id){
        $path = "../../image/";
        $dir = opendir($path); // abrimos el directorio
        $buscaId = strval($id); // convertimos int a array
        while ($imagen = readdir($dir)){ // Recorremos los archivos del dir
            if ($imagen != '.' and $imagen != '..'){ // Todas las carpetas tienen . y ..
                $nombreImagen = pathinfo($imagen, PATHINFO_FILENAME);
                $coincidencia = strpos($nombreImagen, $buscaId);
                if ($coincidencia != false){
                    echo $nombreImagen.'<br>';
                    unlink($path.$imagen);
                }
            }
        }
    }

    public function buscaImagen($id, $accion = 1){ // si es 1 llamamos la funcion desde accion, si es 0 desde vista.
        if ($accion == 1){
            $path = "../../image/";
        } else{
            $path = "../image/";
        }
        $dir = opendir($path); // abrimos el directorio
        $buscaId = strval($id); // convertimos int a array
        $buscaCom = 'com';
        $imagen = array();
        while ($nombreImagen = readdir($dir)){ // Recorremos los archivos del dir
            if ($nombreImagen != '.' and $nombreImagen != '..'){ // Todas las carpetas tienen . y ..
                $coincidencia = strpos($nombreImagen, $buscaId);
                $coincidenciaCom = strpos($nombreImagen, $buscaCom);
                if ($coincidencia != false and $coincidenciaCom != false){
                    array_push($imagen, $nombreImagen);
                }
                if ($coincidencia != false and $coincidenciaCom == false){
                    array_push($imagen, $nombreImagen);
                }
            }
        }
        return $imagen;
    }

    public function verificoStockYRetiro($products){
        $seRealizo = true;
        $hayStock = true;
        if (count($products)>0){
            for ($i=0;$i<count($products);$i++) {
                if ($products[$i]['producto']->getProCantStock() < $products[$i]['cantidad']){
                    $hayStock = false;
                    $seRealizo = false;
                    $this->setMsjOperacion('Nos quedamos sin stock de '.$products[$i]['producto']->getProNombre().'. Stock actual: '.$products[$i]['producto']->getProCantStock());
                }
            }
            if ($hayStock){
                for ($i=0;$i<count($products);$i++){
                    $datos = $this->convertirObjArray($products[$i]['producto']);
                    $datos['procantstock'] = $datos['procantstock'] - $products[$i]['cantidad'];
                    if (!$this->modificacion($datos, null)){
                        $seRealizo = false;
                    }
                }
            }
        }
        return $seRealizo;
    }
}
?>