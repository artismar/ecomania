<?php
class Session{
    private $usuario;
    private $roles;
    private $rolActual;
    private $products;
    private $msjOperacion;

    public function __construct(){
        session_start();
    }

    public function getMsjOperacion(){
        return $this->msjOperacion;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    public function setRoles($roles){
        $this->roles = $roles;
    }
    public function setRolActual($rol){
        $this->rolActual = $rol;
    }
    public function setProducts($products){
        $this->products = $products;
    }
    public function setMsjOperacion($msjOperacion){
        $this->msjOperacion = $msjOperacion;
    }

    /** Actualiza los atributos con los valores dados.
     * @param string $usuario
     * @param string $pass */
    public function iniciar($usMail, $usPass){
        $_SESSION['usmail'] = $usMail;
        $_SESSION['uspass'] = $usPass;
    }

    /** Valida si la sesion actual tiene usuario y pass validos.
     * @return bool */
    public function validar(){
        $valido = false;
        $usuarios = new AbmUsuario();
        $datos['usmail'] = $_SESSION['usmail'];
        $usuario = $usuarios->buscar($datos);
        if (count($usuario) > 0){
            if ($usuario[0]->getUsPass() == $_SESSION['uspass']){
                $valido = true;
                unset($_SESSION['usmail']);
                unset($_SESSION['uspass']);
                $_SESSION['idusuario'] = $usuario[0]->getId();
                $this->iniciarRolActual();
            } else {
                session_destroy();
                $this->setMsjOperacion('Los datos ingresados son incorrectos.');
            }
        } else {
            session_destroy();
            $this->setMsjOperacion('El Email ingresado no esta registrado.');
        }
        return $valido;
    }

    /** Verifica si la sesion esta activa o no.
     * @return bool */
    public function activa(){
        $activa = false;
        if (isset($_SESSION['idusuario'])){
            $activa = true;
        }
        return $activa;
    }

    /** Devuelve el objeto del usuario logueado, si no hay usuario logueado devuelve null
     * @return object */
    public function getUsuario(){
        $userLog = null;
        $usuarios = new AbmUsuario();
        $datos['idusuario'] = $_SESSION['idusuario'];
        $usuario = $usuarios->buscar($datos);
        if (count($usuario) > 0){
            $userLog = $usuario[0];
            $this->setUsuario($userLog);
        }
        return $userLog;
    }

    /** Devuelve un array con los objetos roles del usuario.
     * @param object */
    public function getRoles(){
        $roles = array();
        $usuario = $this->getUsuario();
        if ($usuario != null){
            $abmUsuarioRol = new AbmUsuarioRol();
            $datos['idusuario'] = $usuario->getId();
            $usuarioRoles = $abmUsuarioRol->buscar($datos);
            if (count($usuarioRoles)>0){
                foreach ($usuarioRoles as $object) {
                    array_push($roles, $object->getRol());
                }
                $this->setRoles($roles);
            }
        }
        return $roles;
    }

    public function getProducts(){
        $abmProducto = new AbmProducto();
        $products = array();
        if (isset($_SESSION['products'])){
            $productos = $_SESSION['products'];
            foreach ($productos as $key => $value){
                    $producto = $abmProducto->buscar($value);
                    $cant = $value['cantidad'];
                    if (count($producto)>0 and $cant>0){
                        $products[$key] = array('producto' => $producto[0], 'cantidad' => $cant);
                    }
            }
        }
        return $products;
    }

    public function agregarProducts($idProducto, $cant){
        $products = $this->getProducts();
        $abmProducto = new AbmProducto();
        $datos['idproducto'] = $idProducto;
        $producto = $abmProducto->buscar($datos);
        $seRealizo = false;
        $existe = false;
        if (count($producto)>0){
            if ($cant <= $producto[0]->getProCantStock()){
                if (count($products)>0){
                    foreach ($products as $key => $value){
                            $cantTotal = $cant + $value['cantidad'];
                            if ($value['producto']->getId() == $idProducto){
                                $existe = true;
                                if ($producto[0]->getProCantStock() > $cantTotal){
                                    $value['cantidad'] = $value['cantidad'] + $cant;
                                    $_SESSION['products'][$key]['cantidad'] = $_SESSION['products'][$key]['cantidad'] + $cant;
                                    $seRealizo = true;
                                }
                            }
                    }
                }
                if (!$existe){
                    $_SESSION['products'][] = array('idproducto' => $idProducto, 'cantidad' => $cant);
                    $products[] = array('producto' => $producto[0], 'cantidad' => $cant);
                    $this->setProducts($products);
                    $seRealizo = true;
                }
            }
        }
        return $seRealizo;
    }

    public function eliminarProducts($idProducto){
        $products = $this->getProducts();
        $seRealizo = false;
        if (count($products)>0){
            foreach ($products as $key => $value) {
                if ($value['producto']->getId() == $idProducto){
                    unset($_SESSION['products'][$key]);
                    unset($products[$key]);
                    $seRealizo = true;
                }
            }
        }
        return $seRealizo;
    }

    public function vaciarCarrito(){
        $this->setProducts(null);
        unset($_SESSION['products']);
    }

    public function iniciarRolActual(){
        $abmUsuarioRol = new AbmUsuarioRol();
        $datos['idusuario'] = $this->getUsuario()->getId();
        $rolInicial = $abmUsuarioRol->getRolMasBajo($datos);
        if ($rolInicial != null){
            $_SESSION['idrolactual'] = $rolInicial->getId();
        }
    }

    public function realizoCompra(){
        date_default_timezone_set('America/Argentina/Buenos_Aires'); // Obtener fecha actual en argentina
        $products = $this->getProducts();
        $usuario = $this->getUsuario();
        $seRealizo = false;
        $hoy = getdate();
        $fechaActual = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];
        $abmCompra = new AbmCompra();
        $abmCompraItem = new AbmCompraItem();
        $compra = array('cofecha' => $fechaActual, 'idusuario' => $usuario->getId());
        if ($abmCompra->alta($compra, $products)){
            $seRealizo = true;
            $this->vaciarCarrito();
        }
        return $seRealizo;
    }

    public function cambiarRolActual($id){
        $usuario = $this->getUsuario();
        $abmUsuarioRol = new AbmUsuarioRol();
        if ($usuario != null){
            $buscaId['idusuario'] = $usuario->getId();
            $roles = $abmUsuarioRol->buscar($buscaId);
            if (count($roles) > 1){ // Verificamos que el usuario tenga mas de 1 rol.
                foreach ($roles as $rol){
                    if ($rol->getRol()->getId() == $id){
                        $_SESSION['idrolactual'] = $id;
                    }
                }
            }
        }
    }

        /** Devuelve el rol actual.
     * @param object */
    public function getRolActual(){
        $abmRol = new AbmRol();
        $rolActual = null;
        if (isset($_SESSION['idrolactual'])){
            $datos['idrol'] = $_SESSION['idrolactual'];
            $rol = $abmRol->buscar($datos);
            $usuario = $this->getUsuario();
            if ($usuario != null and count($rol)>0){
                $abmUsuarioRol = new AbmUsuarioRol();
                $datos['idusuario'] = $usuario->getId();
                $datos['idrol'] = $rol[0]->getId();
                $usuarioRoles = $abmUsuarioRol->buscar($datos);
                if (count($usuarioRoles)>0){
                    $rolActual = $rol[0];
                    $this->setRolActual($rolActual);
                }
            }
        }
        return $rolActual;
    }

    /** Cierra la sesion actual */
    public function cerrar(){
        session_unset();
        session_destroy();
        $this->setUsuario(null);
        $this->setRoles(null);
    }
}

?>