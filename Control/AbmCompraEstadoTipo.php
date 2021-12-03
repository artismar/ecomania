<?php
class AbmCompraEstadoTipo{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        if (!isset($datos['idcompraestadotipo'])){
            $datos['idcompraestadotipo'] = null;
        }
        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
            if (array_key_exists('idcompraestadotipo', $datos) and array_key_exists('cetdescripcion', $datos) and array_key_exists('cetdetalle', $datos)){
                $objeto = new CompraEstadoTipo();
                $objeto->set($datos['idcompraestadotipo'], $datos['cetdescripcion'], $datos['cetdetalle']);
            }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idcompraestadotipo']) ){
            $objeto = new CompraEstadoTipo();
            $objeto->set($datos['idcompraestadotipo'], null, null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idcompraestadotipo'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idcompraestadotipo']))
                $where .= " and idcompraestadotipo = ".$datos['idcompraestadotipo'];
            if  (isset($datos['cetdescripcion']))
                 $where .= " and cetdescripcion = '".$datos['cetdescripcion']."'";
            if  (isset($datos['cetdetalle']))
                $where .= " and cetdetalle = '".$datos['cetdetalle']."'";
        }
        $objetos = CompraEstadoTipo::listar($where);
        return $objetos;
    }

    /** Permite ingresar un registro.
     * @param array $datos
     * @return boolean */
    public function alta($datos){
        $alta = false;
        $objeto = $this->cargarObjeto($datos);
        if (array_key_exists($datos['idcompraestadotipo'])){
            if ($objeto != null and $objeto->insertar()){
                $alta = true;
            }
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
                $baja = true;
            }
        }
        return $baja;
    }

    /** Permite modificar un registro.
     * @param array $datos
     * @return boolean */
    public function modificacion($datos){
        $modificar = false;
        if ($this->seteadosCamposClaves($datos)){
            $objeto = $this->cargarObjeto($datos);
            if($objeto != null and $objeto->modificar()){
                $modificar = true;
            }
        }
        return $modificar;
    }

    public function convertirObjArray($obj){
        $array = array();
        $array['idcompraestadotipo'] = $obj->getId();
        $array['cetdescripcion'] = $obj->getCetDescripcion();
        $array['cetdetalle'] = $obj->getCetDetalle();
        return $array;
    }
}
?>