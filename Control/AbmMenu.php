<?php
class AbmMenu{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        if (!isset($datos['idmenu'])){
            $datos['idmenu'] = 'null';
        }
        // Creamos objeto Menu (Padre)
        $menuPadre = null;
        if ($datos['idpadre'] != null){
            $abmMenu = new AbmMenu;
            $buscaMenu['idmenu'] = $datos['idpadre'];
            $menuEncontrado = $abmMenu->buscar($buscaMenu);
            if (count($menuEncontrado)>0){
                $menuPadre = $menuEncontrado[0];
            }
        }
        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (array_key_exists('idmenu', $datos) and array_key_exists('menombre', $datos) and array_key_exists('medescripcion', $datos) and array_key_exists('idpadre', $datos) and array_key_exists('medeshabilitado', $datos)){
            $objeto = new Menu();
            $objeto->set($datos['idmenu'], $datos['menombre'], $datos['medescripcion'], $menuPadre, $datos['medeshabilitado']);
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idmenu']) ){
            $objeto = new Menu();
            $objeto->set($datos['idmenu'], null, null, null, null);
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
            if  (isset($datos['menombre']))
                 $where .= " and menombre = '".$datos['menombre']."'";
            if  (isset($datos['medescripcion']))
                $where .= " and medescripcion = '".$datos['medescripcion']."'";
            if  (isset($datos['idpadre']))
                $where .= " and idpadre = ".$datos['idpadre'];
            if  (isset($datos['medeshabilitado']))
                $where .= " and medeshabilitado = '".$datos['medeshabilitado']."'";
        }
        $objetos = Menu::listar($where);
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

    public function convertirObjArray($obj){
        $array = array();
        $array['idmenu'] = $obj->getId();
        $array['menombre'] = $obj->getMeNombre();
        $array['medescripcion'] = $obj->getMeDescripcion();
        $array['idpadre'] = $obj->getMenuPadre()->getId();
        $array['medeshabilitado'] = $obj->getMeDeshabilitado();
        return $array;
    }

    /** Retorna un array que contiene menus que no son submenus y estan habilitados
     * @return array */
    public function menusPadres(){
        $menus = $this->buscar(null);
        $menusPadres = array();
        foreach ($menus as $item) {
            if ($item->getMenuPadre() == null and ($item->getMeDeshabilitado() == null || $item->getMeDeshabilitado() == '0000-00-00 00:00:00')){
                array_push($menusPadres, $item);
            }
        }
        return $menusPadres;
    }

    /** Retorna un array de los submenus habilitados del menu con la id pasada en el parametro si tiene, si no tiene retorna array vacio.
     * @return array */
    public function subMenus($id){
        $datos['idpadre'] = $id;
        $menus = $this->buscar($datos);
        $menusHijos = array();
        if (count($menus)>0){
            foreach ($menus as $menu) {
                if ($menu->getMeDeshabilitado() == null || $menu->getMeDeshabilitado() == '0000-00-00 00:00:00'){
                    array_push($menusHijos, $menu);
                }
            }
        }
        return $menusHijos;
    }
}
?>