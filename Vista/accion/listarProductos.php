<?php
    include_once '../config.php';
    $accion = true;


    function listarProductosDestacados(){
        $cant = 6; // CANTIDAD DE PRODUCTOS DESTACADOS A LISTAR
        $abmProductos = new AbmProducto();
        $productos = $abmProductos->buscar(null);
        $imagen = array();

        if ($cant > count($productos)){
            $cant = count($productos);
        }
        
        if (count($productos)>0){
            for ($i=0;$i<$cant;$i++) {  // JUNTAMOS PRODUCTOS ALEATORIOS
                $imagen = $abmProductos->buscaImagen($productos[$i]->getId(), 0);
                    echo '
                    <div class="col">
                        <div class="card text-center h-100" style="width:300px;">
                            <div><a href="accion/mostrarProducto.php?idproducto='.$productos[$i]->getId().'"><img src="../image/'.$imagen[0].'" class="card-img-top img-fluid" alt="..."></a></div>
                            <div class="card-body">
                                <a href="accion/mostrarProducto.php?idproducto='.$productos[$i]->getId().'" style="text-decoration: none;color:black;"><h5 class="card-title">'.$productos[$i]->getProNombre().'</h5></a>
                                <p class="card-text">$'.$productos[$i]->getProPrecio().'</p>
                            </div>';
                    if ($productos[$i]->getProCantStock() > 0){
                        echo '<div class="mb-3"><a class="btn btn-primary" href="accion/gestionCarrito.php?idproducto='.$productos[$i]->getId().'&cantidad=1&accion=agregar">Agregar al carrito</a></div>
                            </div>
                            </div>';
                    } else{
                        echo '<div class="mb-3"><a class="btn btn-primary disabled" href="#">Sin stock</a></div>
                            </div>
                            </div>';
                    }
            }
        } else {
            echo '<div class="alert alert-danger">Ups! No encontramos ningun producto.</div>';
        }
    }

    function listarProductos(){
        $abmProductos = new AbmProducto();
        $productos = $abmProductos->buscar(null);
        $imagen = array();

        if (count($productos)>0){
            for ($i=0;$i<count($productos);$i++) {  // JUNTAMOS PRODUCTOS ALEATORIOS
                $imagen = $abmProductos->buscaImagen($productos[$i]->getId(), 0);
                    echo '
                    <div class="col">
                        <div class="card text-center h-100" style="width:200px;">
                            <div><a href="accion/mostrarProducto.php?idproducto='.$productos[$i]->getId().'"><img src="../image/'.$imagen[0].'" class="card-img-top img-fluid" alt="'.$productos[$i]->getProNombre().'"></a></div>
                            <div class="card-body">
                            <a href="accion/mostrarProducto.php?idproducto='.$productos[$i]->getId().'" style="text-decoration: none;color:black;"><h5 class="card-title">'.$productos[$i]->getProNombre().'</h5><a/>
                                <p class="card-text">$'.$productos[$i]->getProPrecio().'</p>
                            </div>';
                    if ($productos[$i]->getProCantStock() > 0){
                        echo '<div class="mb-3"><a class="btn btn-primary" href="accion/gestionCarrito.php?idproducto='.$productos[$i]->getId().'&cantidad=1&accion=agregar">Agregar al carrito</a></div>
                            </div>
                            </div>';
                    } else{
                        echo '<div class="mb-3"><a class="btn btn-primary disabled" href="#">Sin stock</a></div>
                            </div>
                            </div>';
                    }
            }
        } else {
            echo '<div class="alert alert-danger">Ups! No encontramos ningun producto.</div>';
        }
    }
?>