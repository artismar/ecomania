<?php
class AbmUsuario{

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $objeto = null;
        if (!isset($datos['idusuario'])){
            $datos['idusuario'] = null;
        }
        // array_key_exists devuelve true si el valor del primer parametro coincide con alguna clave del array asociativo pasado en el segundo parametro.
        // isset devuelve true si la variable existe y no es null.
        if (array_key_exists('idusuario', $datos) and array_key_exists('usnombre', $datos) and array_key_exists('uspass', $datos) and array_key_exists('usmail', $datos) and array_key_exists('usdeshabilitado', $datos)){
            $objeto = new Usuario();
            $objeto->set($datos['idusuario'], $datos['usnombre'], $datos['uspass'], $datos['usmail'], $datos['usdeshabilitado']);
        }
        return $objeto;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $datos
     * @return object */
    private function cargarObjetoConClave($datos){
        $objeto = null;
        if(isset($datos['idusuario']) ){
            $objeto = new Usuario();
            $objeto->set($datos['idusuario'], null, null, null, null);
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
            if  (isset($datos['usnombre']))
                 $where .= " and usnombre = '".$datos['usnombre']."'";
            if  (isset($datos['uspass']))
                $where .= " and uspass = '".$datos['uspass']."'";
            if  (isset($datos['usmail']))
                $where .= " and usmail = '".$datos['usmail']."'";
            if  (isset($datos['usdeshabilitado']))
                $where .= " and usdeshabilitado = '".$datos['usdeshabilitado']."'";
        }
        $objetos = Usuario::listar($where);
        return $objetos;
    }

    /** Permite ingresar un registro.
     * @param array $datos
     * @return boolean */
    public function alta($datos){
        $alta = false;
        $datos['usdeshabilitado'] = null;
        $objeto = $this->cargarObjeto($datos);
        if ($objeto != null and $objeto->insertar()){
            $abmUsuarioRol = new AbmUsuarioRol(); // Agregamos rol al nuevo usuario como cliente id = 3
            $datosUsuarioRol['idusuario'] = $objeto->getId();
            $datosUsuarioRol['idrol'] = 3;
            if ($abmUsuarioRol->alta($datosUsuarioRol)){
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
            if (isset($datos['usnombre']) and isset($datos['usmail']) and isset($datos['usdeshabilitado'])){
                $datos['uspass'] = "";
                $objeto = $this->cargarObjeto($datos);
                if($objeto != null and $objeto->modificar()){
                    $modificar = true;
                }
            } elseif (isset($datos['uspass'])){
                $datos['usnombre'] = "";
                $datos['usmail'] = "";
                $datos['usdeshabilitado'] = "";
                $objeto = $this->cargarObjeto($datos);
                if($objeto != null and $objeto->modificarPass()){
                    $modificar = true;
                }
            }
        }
        return $modificar;
    }

    public function convertirObjArray($obj){
        $array = array();
        $array['idusuario'] = $obj->getId();
        $array['usnombre'] = $obj->getUsNombre();
        $array['uspass'] = $obj->getUsPass();
        $array['usmail'] = $obj->getUsMail();
        $array['usdeshabilitado'] = $obj->getUsDeshabilitado();
        return $array;
    }
}
?>