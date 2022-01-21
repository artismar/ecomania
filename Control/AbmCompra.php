<?php
class AbmCompra{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        $abmUsuario = new AbmUsuario;
        $buscaUsuario['idusuario'] = $datos['idusuario'];
        $usuario = $abmUsuario->buscar($buscaUsuario);

        if (!isset($datos['idcompra'])){
            $datos['idcompra'] = null;
        }
        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (count($usuario)>0){
            if (array_key_exists('idcompra', $datos) and array_key_exists('cofecha', $datos) and array_key_exists('idusuario', $datos)){
                $objeto = new Compra();
                $objeto->set($datos['idcompra'], $datos['cofecha'], $usuario[0]);
            }
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idcompra']) ){
            $objeto = new Compra();
            $objeto->set($datos['idcompra'], null, null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idcompra'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idcompra']))
                $where .= " and idcompra = ".$datos['idcompra'];
            if  (isset($datos['cofecha']))
                 $where .= " and cofecha = '".$datos['cofecha']."'";
            if  (isset($datos['idusuario']))
                $where .= " and idusuario = ".$datos['idusuario'];
        }
        $objetos = Compra::listar($where);
        return $objetos;
    }

    /** Permite ingresar un registro.
     * @param array $datos
     * @return boolean */
    public function alta($datos, $products){
        $alta = false;
        $objeto = $this->cargarObjeto($datos);
        if ($objeto != null and $objeto->insertar()){
            $this->registrarItems($objeto->getId(), $products);
            $this->iniciarEstado($objeto, );
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
        $array['idcompra'] = $obj->getId();
        $array['cofecha'] = $obj->getCoFecha();
        $array['idusuario'] = $obj->getUsuario()->getId();
        return $array;
    }

    public function registrarItems($idCompra, $products){
        $abmCompraItem = new AbmCompraItem();
        $seRealizo = true;
        for ($i=0;$i<count($products);$i++){
            $compraItems = array('idproducto' => $products[$i]['producto']->getId(), 'idcompra' => $idCompra, 'cicantidad' => $products[$i]['cantidad']);
            if (!$abmCompraItem->alta($compraItems)){
                $seRealizo = false;
            }
        }
        return $seRealizo;
    }

    public function iniciarEstado($compra){
        $abmCompraEstado = new AbmCompraEstado();
        $seRealizo = false;
        $compraEstado = array('idcompra' => $compra->getId(), 'idcompraestadotipo' => 1, 'cefechaini' => $compra->getCoFecha(), 'cefechafin' => null);
        if ($abmCompraEstado->alta($compraEstado)){
            $seRealizo = true;
        }
        return $seRealizo;
    }
}
?>