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
                <h1>¡Este es el detalle de la compra de <span style="color: green;"><?php echo $compra->getUsuario()->getUsNombre();?></span>!</h1>
            </div>
            <div class="col-12 mt-5">
                <h6>Informacion del usuario</h6>
                <p>
                    Nombre: <span class="infoPedido"><?php echo $compra->getUsuario()->getUsNombre();?></span><br>
                    Email: <span class="infoPedido"><?php echo $compra->getUsuario()->getUsMail();?></span><br>
                </p>
            </div>
            <div class="col-12 mt-5">
                <h6>Informacion del pedido</h6>
                <p>
                    Estado: <span class="infoPedido"><?php echo $compraEstado[0]->getCompraEstadoTipo()->getCetDescripcion();?></span><br>
                    Pedido realizado: <span class="infoPedido"><?php echo $compraEstado[0]->getCeFechaIni();?></span><br>
                    Pedido finalizado: <span class="infoPedido"><?php echo $fechaFin;?></span><br>
                </p>
            </div>
            <div class="col-12 mt-5">
                <h6>Pedido</h6>
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
                                $num = 1;
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
            <div class="row justify-content-end">
                <div class="col-2 mt-3 text-center">
                    <p id="infoTotal"><b>Total $<?php echo $totalCarrito;?></b></p>
                </div>
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