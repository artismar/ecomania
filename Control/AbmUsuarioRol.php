<?php
class AbmUsuarioRol{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        // Creamos objeto Usuario
        $abmUsuario = new AbmUsuario;
        $buscaUsuario['idusuario'] = $datos['idusuario'];
        $usuario = $abmUsuario->buscar($buscaUsuario);
        // Creamos objeto Rol
        $abmRol = new AbmRol;
        $buscaRol['idrol'] = $datos['idrol'];
        $rol = $abmRol->buscar($buscaRol);

        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (count($usuario)>0 and count($rol)>0){
            if (array_key_exists('idusuario', $datos) and array_key_exists('idrol', $datos)){
                $objeto = new UsuarioRol();
                $objeto->set($usuario[0], $rol[0]);
            }
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idusuario']) ){
            $objeto = new UsuarioRol();
            $objeto->set($datos['idusuario'], null);
        }
        return $objeto;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves.
     * @param array $datos
     * @return boolean */
    private function seteadosCamposClaves($datos){
        $existe = false;
        if (isset($datos['idusuario'])) // isset devuelve true si la variable existe y no es null.
            $existe = true;
        return $existe;
    }

    /** Busca los datos solicitados en la var y devuelve un array con los objetos.
     * @param array $datos
     * @return array */
    public function buscar($datos){
        $where = " true ";
        if ($datos != null){
            if  (isset($datos['idusuario']))
                $where .= " and idusuario = ".$datos['idusuario'];
            if  (isset($datos['idrol']))
                 $where .= " and idrol = ".$datos['idrol'];
        }
        $objetos = UsuarioRol::listar($where);
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
        $array['idusuario'] = $obj->getUsuario()->getId();
        $array['idrol'] = $obj->getRol()->getId();
        return $array;
    }

    /** Cuando un usuario con varios roles inicia sesion, este inicia con el rol mas bajo, obtenes desde aca el rol mas bajo del usuario
     * @return object 
     * @return null */
    public function getRolMasBajo($datos){
        $abmUsuarioRol = new AbmUsuarioRol();
        $usuarioRol = $abmUsuarioRol->buscar($datos);
        $rolMasBajo = null;
        if (count($usuarioRol) > 0){
            $idRolMasBajo = 0;
            foreach ($usuarioRol as $object) {
                if ($object->getRol()->getId() > $idRolMasBajo){ // Teniendo en cuenta que mientras mas alto el id del rol mas bajo son los permisos.
                    $idRolMasBajo = $object->getRol()->getId();
                    $rolMasBajo = $object->getRol();
                }
            }
        }
        return $rolMasBajo;
    }
}
?>