<?php
    $segura = true;
    $title = 'Pedidos';
    include_once 'estructura/cabecera.php';

    $id = 4; // id del menu cuenta
    include_once 'estructura/lateral.php';
    
    $data = data_submitted();
    if (isset($data['idcompra'])){
        $abmCompra = new AbmCompra();
        $compras = $abmCompra->buscar($data);
        if (count($compras)>0){
            $compra = $compras[0];
            $abmCompraItem = new AbmCompraitem();
            $compraItems = $abmCompraItem->buscar($data);
            $abmCompraEstado = new AbmCompraEstado();
            $compraEstado = $abmCompraEstado->buscar($data);
            if ($compraEstado[0]->getCeFechaFin() == null || $compraEstado[0]->getCeFechaFin() == '0000-00-00 00:00:00'){
                $fechaFin = '-';
            } else {
                $fechaFin = $compraEstado[0]->getCeFechaFin();
            }
        }
    }
    if ($rolActual->getId() == 3){
        $url = 'verPedidos.php';
    } else {
        $url = 'gestionarPedidos.php';
    }
?>

<!-- MODIFICAR DATOS DE LA CUENTA -->
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <h5>¡Este es el detalle de la compra de, <span style="color: green;"><?php echo $compra->getUsuario()->getUsNombre();?></span>!</h5>
            </div>
            <div class="col-12 mt-5">
                <h6>Informacion del usuario</h6>
                <p>
                    Nombre: <?php echo $compra->getUsuario()->getUsNombre();?><br>
                    Email: <?php echo $compra->getUsuario()->getUsMail();?><br>
                </p>
            </div>
            <div class="col-12 mt-5">
                <h6>Informacion del pedido</h6>
                <p>
                    Estado: <?php echo $compraEstado[0]->getCompraEstadoTipo()->getCetDescripcion();?><br>
                    Pedido realizado: <?php echo $compraEstado[0]->getCeFechaIni();?><br>
                    Pedido finalizado: <?php echo $fechaFin;?><br>
                </p>
            </div>
            <div class="col-12 mt-5">
                <h6>Articulos pedidos</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (count($compraItems)>0){
                                $num = 0;
                                $totalCarrito = 0;
                                foreach ($compraItems as $item) {
                                    $total = $item->getProducto()->getProPrecio()*$item->getCiCantidad();
                                    echo '<tr>
                                    <th>'.$num.'</th>
                                    <td>'.$item->getProducto()->getProNombre().'</td>
                                    <td>'.$item->getCiCantidad().'</td>
                                    <td>'.$item->getProducto()->getProPrecio().'</td>
                                    <td>'.$total.'</td>';
                                    echo '</tr>';
                                    $num++;
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
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-3">
                <p>Total a pagar: $<?php echo $totalCarrito;?></p>
            </div>
            <div class="col-12 mt-5">
                <a href="<?php echo $url;?>" class='btn btn-primary'>Volver</a>
            </div>
        </div>
    </div>
</div>







<!-- 3 cierres de div completando la estructura del menu lateral -->
</div>
</div>
</div>


<?php
    include_once 'estructura/pie.php';
?>