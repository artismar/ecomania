<?php
class AbmCompraEstado{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        // Creamos objeto Compra
        $abmCompra = new AbmCompra;
        $buscaCompra['idcompra'] = $datos['idcompra'];
        $compra = $abmCompra->buscar($buscaCompra);
        // Creamos objeto CompraEstadoTipo
        $abmCompraEstadoTipo = new AbmCompraEstadoTipo;
        $buscaCompraEstadoTipo['idcompraestadotipo'] = $datos['idcompraestadotipo'];
        $compraEstadoTipo = $abmCompraEstadoTipo->buscar($buscaCompraEstadoTipo);


        if (!isset($datos['idcompraestado'])){
            $datos['idcompraestado'] = null;
        }
        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (count($compra)>0 and count($compraEstadoTipo)>0){
            if (array_key_exists('idcompraestado', $datos) and array_key_exists('idcompra', $datos) and array_key_exists('idcompraestadotipo', $datos) and array_key_exists('cefechaini', $datos) and array_key_exists('cefechafin', $datos)){
                $objeto = new CompraEstado();
                $objeto->set($datos['idcompraestado'], $compra[0], $compraEstadoTipo[0], $datos['cefechaini'], $datos['cefechafin']);
            }
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idcompraestado']) ){
            $objeto = new CompraEstado();
            $objeto->set($datos['idcompraestado'], null, null, null, null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idcompraestado'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idcompraestado']))
                $where .= " and idcompraestado = ".$datos['idcompraestado'];
            if  (isset($datos['idcompra']))
                 $where .= " and idcompra = ".$datos['idcompra'];
            if  (isset($datos['idcompraestadotipo']))
                $where .= " and idcompraestadotipo = ".$datos['idcompraestadotipo'];
            if  (isset($datos['cefechaini']))
            $where .= " and cefechaini = '".$datos['cefechaini']."'";
            if  (isset($datos['cefechafin']))
            $where .= " and cefechafin = '".$datos['cefechafin']."'";
        }
        $objetos = CompraEstado::listar($where);
        return $objetos;
    }

    /** Permite ingresar un registro.
     * @param array $datos
     * @return boolean */
    public function alta($datos){
        $alta = false;
        $objeto = $this->cargarObjeto($datos);
        if ($objeto != null and $objeto->insertar()){
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

    public function cancelar($id){
        date_default_timezone_set('America/Argentina/Buenos_Aires'); // Obtener fecha actual en argentina
        $datos['idcompra'] = $id;
        $compraEstado = $this->buscar($datos);
        $seRealizo = false;
        if (count($compraEstado)>0){
            $datos['cefechaini'] = $compraEstado[0]->getCeFechaIni();
            $datos['idcompraestado'] = $compraEstado[0]->getId();
            $datos['idcompraestadotipo'] = 4;
            $hoy = getdate();
            $datos['cefechafin'] = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];
            if ($compraEstado[0]->getCompraEstadoTipo()->getId() == 1 || $compraEstado[0]->getCompraEstadoTipo()->getId() == 2){
                if ($this->modificacion($datos)){
                    // Una vez cancelado el pedido, reponemos el stock.
                    $abmCompraItem = new AbmCompraItem();
                    $abmCompraItem->reponerStockProductos($id);
                    $seRealizo = true;
                }
            }
        }
        return $seRealizo;
    }

    public function aceptar($id){
        $datos['idcompra'] = $id;
        $compraEstado = $this->buscar($datos);
        $seRealizo = false;
        if (count($compraEstado)>0){
            if ($compraEstado[0]->getCompraEstadoTipo()->getId() == 1){
                $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
                $data['idcompraestadotipo'] = 2;
                $compraEstadoTipo = $abmCompraEstadoTipo->buscar($data);
                $compraEstado[0]->setCompraEstadoTipo($compraEstadoTipo[0]);
                $arr = $this->convertirObjArray($compraEstado[0]);
                if ($this->modificacion($arr)){
                    $seRealizo = true;
                }
            }
        }
        return $seRealizo;
    }

    public function enviar($id){
        date_default_timezone_set('America/Argentina/Buenos_Aires'); // Obtener fecha actual en argentina
        $datos['idcompra'] = $id;
        $compraEstado = $this->buscar($datos);
        $seRealizo = false;
        if (count($compraEstado)>0){
            if ($compraEstado[0]->getCompraEstadoTipo()->getId() == 2){
                $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
                $data['idcompraestadotipo'] = 3;
                $compraEstadoTipo = $abmCompraEstadoTipo->buscar($data);
                $compraEstado[0]->setCompraEstadoTipo($compraEstadoTipo[0]);
                $hoy = getdate();
                $fechaFin = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];
                $compraEstado[0]->setCeFechaFin($fechaFin);
                $arr = $this->convertirObjArray($compraEstado[0]);
                if ($this->modificacion($arr)){
                    $seRealizo = true;
                }
            }
        }
        return $seRealizo;
    }

    public function convertirObjArray($obj){
        $array = array();
        $array['idcompraestado'] = $obj->getId();
        $array['idcompra'] = $obj->getCompra()->getId();
        $array['idcompraestadotipo'] = $obj->getCompraEstadoTipo()->getId();
        $array['cefechaini'] = $obj->getCeFechaIni();
        $array['cefechafin'] = $obj->getCeFechaFin();
        return $array;
    }
}
?>