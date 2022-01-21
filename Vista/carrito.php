<?php
    $title = 'Carrito';
    include_once 'estructura/cabecera.php';
    $datos = data_submitted();
?>

<div class="container m-5">
    <div class="row">
        <div class="col">
            <h4>Carrito compras</h4>
        </div>
    </div>
    <?php
        if (isset($datos['msjError'])){
            $msj = $datos['msjError'];
            echo '<div class="row text-center pt-2">
                <div class="col">
                <div class="alert alert-danger" role="alert">'.$msj.'</div class>
                </div>
                </div>';
        } elseif (isset($datos['msj'])){
            $msj = $datos['msj'];
            echo '<div class="row text-center pt-2">
                <div class="col">
                <div class="alert alert-success" role="alert">'.$msj.'</div class>
                </div>
                </div>';
        }
    ?>
    <div class="row">
        <div class="col-12">
            <?php
            if (count($products)==0){
                echo '<div class="alert">No tienes ningun producto agregado, <a href="productos.php" style="color:green;text-decoration:none;">Agregar productos</a></div>';
            }
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Total</th>
                        <th scope="col">X</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (count($products)>0){
                            $totalCarrito = 0;
                            foreach ($products as $producto) {
                                $total = $producto['producto']->getProPrecio()*$producto['cantidad'];
                                echo '<tr>
                                <th>'.$producto['producto']->getProNombre().'</th>
                                <td>'.$producto['cantidad'].'</td>
                                <td>$'.$producto['producto']->getProPrecio().'</td>
                                <td>$'.$total.'</td>
                                <td><a class="text-danger" href="accion/gestionCarrito.php?idproducto='.$producto['producto']->getId().'&accion=eliminar" style="text-decoration:none;">X</a></td>
                                </tr>';
                                $totalCarrito = $totalCarrito + $total;
                            }
                        } else{
                            echo '<tr>
                                <th>-</th>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                </tr>';
                                $totalCarrito = '0';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-12 mt-5">
            <div class="row mt-5 justify-content-center align-items-center">
                <div class="col-md-5 col-lg-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-success">Total a pagar</span>
                        <span class="badge bg-success rounded-pill"><?php echo count($products)?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total: </span>
                            <strong>$<?php echo $totalCarrito;?></strong>
                        </li>
                    </ul>
                </div>
            <div class="row mt-5 justify-content-center align-items-center">
                <div class="col-2">
                    <?php
                    if (count($products)>0){
                        echo '<a href="accion/gestionCarrito.php?accion=vaciar" class="btn btn-danger">Vaciar</a>
                        <a href="accion/gestionCarrito.php?accion=comprar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmar">Comprar</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CONFIRMAR -->
<div class="modal fade" id="confirmar" tabindex="-1" aria-hidden="true" aria-labelledby="modalTitle">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">¿Confirmar compra?</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <p>Una vez confirmada la compra podras gestionarla en tus pedidos, ingresando al menu de tu cuenta.</p>
                </div>
            </div>
            <div class="modal-footer">
                    <a href="accion/iniciarCompra.php" class="btn btn-success">Comprar</a>
            </div>
        </div>
    </div>
</div>


<?php
    include_once 'estructura/pie.php';
?>