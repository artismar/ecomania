<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <?php 
        if (!isset($accion)){ // Determinamos si es el header es de una pagina de la carpeta accion o vista y segun de donde sea, redireccionamos.
            include_once "../config.php";
            echo '<link rel="stylesheet" href="css/main.css">';
            echo '<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/themes/default/easyui.css">';
            echo '<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/themes/icon.css">';
            echo '<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/themes/color.css">';
            // echo '<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/demo/demo.css">';
            echo '<script type="text/javascript" src="js/jquery-easyui-1.6.6/jquery.min.js"></script>';
            echo '<script type="text/javascript" src="js/jquery-easyui-1.6.6/jquery.easyui.min.js"></script>';
        } else {
            include_once "../../config.php";
            echo '<link rel="stylesheet" href="../css/main.css">';
            echo '<link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/themes/default/easyui.css">';
            echo '<link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/themes/icon.css">';
            echo '<link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/themes/color.css">';
            // echo '<link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/demo/demo.css">';
            echo '<script type="text/javascript" src="../js/jquery-easyui-1.6.6/jquery.min.js"></script>';
            echo '<script type="text/javascript" src="../js/jquery-easyui-1.6.6/jquery.easyui.min.js"></script>';
        }
    ?>
</head>
<body>
    <?php
        $sesion = new Session();
        $products = $sesion->getProducts();
        if ($sesion->activa()){
            $usuario = $sesion->getUsuario();
            $roles = $sesion->getRoles();
        } else {
            if (isset($segura)){
                header('location:login.php?msjError=Tienes que iniciar sesion para ingresar a "'.$title.'".');
            }
        }

        // Ubicaciones
        if (!isset($accion)){
            $pts = '';
            $logo = 'img/logo.png';
            $logo1 = 'img/logo1.png';
            $registro = 'registrarse.php';
            $login = 'login.php';
            $cerrarSesion = 'accion/cerrarSesion.php';
            $cambioRolActual = 'accion/cambioRolActual.php';
            $carrito = 'carrito.php';

            // Carousel
            $carousel01 = 'img/carousel01.jpg';
            $carousel02 = 'img/carousel02.jpg';
            $carousel03 = 'img/carousel03.jpg';
        } else {
            $pts = '../';
            $logo = '../img/logo.png';
            $logo1 = '../img/logo1.png';
            $registro = '../registrarse.php';
            $login = '../login.php';
            $cerrarSesion = 'cerrarSesion.php';
            $cambioRolActual = 'cambioRolActual.php';
            $carrito = '../carrito.php';

            // Carousel
            $carousel01 = '../img/carousel01.jpg';
            $carousel02 = '../img/carousel02.jpg';
            $carousel03 = '../img/carousel03.jpg';
        }
    ?>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-secondary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $paginaInicio?>">
                <img src="<?php echo $logo?>" alt="" width="60" height="60">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    $abmMenu = new AbmMenu();
                    $abmMenuRol = new AbMMenuRol();
                    $menusPadres = $abmMenu->menusPadres(); // Buscamos menus que NO son submenus

                    foreach ($menusPadres as $itemPadre) {
                        $buscaId['idmenu'] = $itemPadre->getId();
                        $subMenus = $abmMenu->subMenus($buscaId['idmenu']); // Buscamos si el itemPadre tiene submenus para darle estilo distinto.
                        $menuSinRol = $abmMenuRol->buscar($buscaId); // Buscamos los menus que pueden acceder todos los usuarios sin tener rol para colocarlos en la cabecera.
                        if (count($menuSinRol) == 0){
                            if (count($subMenus) == 0){
                                echo '<li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="'.$pts.$itemPadre->getMeDescripcion().'">'.$itemPadre->getMeNombre().'</a>
                                        </li>';
                            } else {
                                echo '<li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="'.$pts.$itemPadre->getMeDescripcion().'" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.$itemPadre->getMeNombre().'</a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                foreach ($subMenus as $subMenu) {
                                        echo '<li><a class="dropdown-item" href="'.$pts.$subMenu->getMeDescripcion().'">'.$subMenu->getMeNombre().'</a></li>';
                                }
                                echo '</ul>
                                        </li>';
                            }
                        }
                    }
                    ?>
                </ul>
                        <?php
                        if ($sesion->activa()){
                            $rolActual = $sesion->getRolActual();
                            echo '<ul class="navbar-nav me-3">
                                    <li class="nav-item dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="fas fa-user"></i></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">';
                            if (count($roles) > 1) { // Mostrar la opcion de cambiar rol si el usuario tiene mas de 1 rol.
                                echo '<li class="text-center"><span class="text-muted fs-6"><i class="fas fa-sort-down"></i> Rol <i class="fas fa-sort-down"></i></span><br>'.$rolActual->getRoDescripcion().'<button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#seleccionRol"><i class="fas fa-sync-alt"></i></button></li>
                                        <li><hr class="dropdown-divider"></li>';
                            }
                            $buscaMenuRol['idrol'] = $rolActual->getId();
                            $menusDelRol = $abmMenuRol->buscar($buscaMenuRol); // Buscamos el menu padre vinculado al rol
                            if (count($menusDelRol) > 0){
                                foreach ($menusDelRol as $item) {
                                    if ($item->getMenu()->getMenuPadre() == null and ($item->getMenu()->getMeDeshabilitado() == null || $item->getMenu()->getMeDeshabilitado() == '0000-00-00 00:00:00')){
                                        if (!isset($accion)){
                                            echo '<li><a class="dropdown-item" href="'.$item->getMenu()->getMeDescripcion().'">'.$item->getMenu()->getMeNombre().'</a></li>';
                                        } else {
                                            echo '<li><a class="dropdown-item" href="../'.$item->getMenu()->getMeDescripcion().'">'.$item->getMenu()->getMeNombre().'</a></li>';
                                        }
                                    }
                                }
                            }
                            echo '<li><a class="dropdown-item" href="'.$cerrarSesion.'">Cerrar Sesion</a></li>
                                    </ul>
                                    </li>
                                    </ul>';
                        } else {
                            echo '<ul class="navbar-nav me-3">
                                <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="'.$login.'"><i class="fas fa-user"></i></a>
                                </li>
                                </ul>';
                        }
                        echo '<ul class="navbar-nav me-3">
                        <li class="nav-item">';
                        if (count($products)>0){
                            echo '<a href="'.$carrito.'" class="nav-link" aria-current="page"><i class="fas fa-shopping-cart"></i> <span class="top-0 start-100 translate-middle badge rounded-pill bg-danger">'.count($products).'</span></a>';
                        } else {
                            echo '<a href="'.$carrito.'" class="nav-link" aria-current="page"><i class="fas fa-shopping-cart"></i></a>';
                        }
                        echo '</li>
                        </ul>';
                        ?>
            </div>
            <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                </form>
        </div>
    </nav>

    <!-- MODAL ROLES -->
    <div class="modal fade" id="seleccionRol" tabindex="-1" aria-hidden="true" aria-labelledby="modalTitle">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Selecciona el rol a cambiar</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <div class="d-grid gap-2">
                            <?php
                                foreach ($roles as $rol) {
                                    if ($rol->getId() != $rolActual->getId()){
                                        echo '<a class="btn btn-primary" type="button" href="'.$cambioRolActual.'?id='.$rol->getId().'">'.$rol->getRoDescripcion().'</a>';
                                    } else {
                                        echo '<a class="btn btn-secondary disabled" type="button">'.$rol->getRoDescripcion().'</a>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>