<?php
class AbmCompraItem{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        if (!isset($datos['idcompraitem'])){
            $datos['idcompraitem'] = null;
        }
        // Creamos objeto Producto
        $abmProducto = new AbmProducto;
        $buscaProducto['idproducto'] = $datos['idproducto'];
        $producto = $abmProducto->buscar($buscaProducto);
        // Creamos objeto Compra
        $abmCompra = new AbmCompra;
        $buscaCompra['idcompra'] = $datos['idcompra'];
        $compra = $abmCompra->buscar($buscaCompra);

        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (count($producto)>0 and count($compra)>0){
            if (array_key_exists('idcompraitem', $datos) and array_key_exists('idproducto', $datos) and array_key_exists('idcompra', $datos) and array_key_exists('cicantidad', $datos)){
                $objeto = new CompraItem();
                $objeto->set($datos['idcompraitem'], $producto[0], $compra[0], $datos['cicantidad']);
            }
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idcompraitem']) ){
            $objeto = new CompraItem();
            $objeto->set($datos['idcompraitem'], null, null, null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idcompraitem'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idcompraitem']))
                $where .= " and idcompraitem = ".$datos['idcompraitem'];
            if  (isset($datos['idproducto']))
                 $where .= " and idproducto = ".$datos['idproducto'];
            if  (isset($datos['idcompra']))
                $where .= " and idcompra = ".$datos['idcompra'];
            if  (isset($datos['cicantidad']))
                $where .= " and cicantidad = ".$datos['cicantidad'];
        }
        $objetos = CompraItem::listar($where);
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

    public function reponerStockProductos($idcompra){
        $datos['idcompra'] = $idcompra;
        $compraItems = $this->buscar($datos);
        $seRealizo = true;
        if (count($compraItems)>0){
            $abmProducto = new AbmProducto();
            foreach ($compraItems as $items){
                $cant = $items->getProducto()->getProCantStock() + $items->getCiCantidad();
                $items->getProducto()->setProCantStock($cant);
                $data = $abmProducto->convertirObjArray($items->getProducto());
                if (!$abmProducto->modificacion($data, null)){
                    $seRealizo = false;
                }
            }
        }
        return $seRealizo;
    }

    public function convertirObjArray($obj){
        $array = array();
        $array['idcompraitem'] = $obj->getId();
        $array['idproducto'] = $obj->getProducto()->getId();
        $array['idcompra'] = $obj->getCompra()->getId();
        $array['cicantidad'] = $obj->getCiCantidad();
        return $array;
    }
}
?>