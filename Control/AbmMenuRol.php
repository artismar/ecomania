<?php
class AbmMenuRol{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        if (!isset($datos['idmenu'])){
            $datos['idmenu'] = null;
        }
        // Creamos objeto Menu
        $abmMenu = new AbmMenu;
        $buscaMenu['idmenu'] = $datos['idmenu'];
        $menu = $abmMenu->buscar($buscaMenu);
        // Creamos objeto Rol
        $abmRol = new AbmRol;
        $buscaRol['idrol'] = $datos['idrol'];
        $rol = $abmRol->buscar($buscaRol);

        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (count($menu)>0 and count($rol)>0){
            if (array_key_exists('idmenu', $datos) and array_key_exists('idrol', $datos)){
                $objeto = new MenuRol();
                $objeto->set($menu, $rol);
            }
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idmenu']) ){
            $objeto = new MenuRol();
            $objeto->set($datos['idmenu'], null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idmenu'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idmenu']))
                $where .= " and idmenu = ".$datos['idmenu'];
            if  (isset($datos['idrol']))
                 $where .= " and idrol = ".$datos['idrol'];
        }
        $objetos = MenuRol::listar($where);
        return $objetos;
    }

    /** Permite ingresar un registro.
     * @param array $datos
     * @return boolean */
    public function alta($datos){
        $alta = false;
        $objeto = $this->cargarObjeto($datos);
        if (array_key_exists($datos['idmenu'])){
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
        $array['idmenu'] = $obj->getMenu()->getId();
        $array['idrol'] = $obj->getRol()->getId();
        return $array;
    }
}
?>