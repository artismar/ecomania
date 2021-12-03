<?php
    $segura = true;
    $title = 'Pedidos';
    include_once 'estructura/cabecera.php';

    $id = 4; // id del menu cuenta
    include_once 'estructura/lateral.php';

    $abmCompra = new AbmCompra();
    $abmCompraEstado = new AbmCompraEstado();
    $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
    $compras = $abmCompra->buscar(null);
    $data = data_submitted();
?>

<!-- MODIFICAR DATOS DE LA CUENTA -->
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <h5>¡Aqui puedes gestionar los pedidos, <span style="color: green;"><?php echo $usuario->getUsNombre()?></span>!</h5>
            </div>
            <?php
            if (isset($data['msjError'])){
                $msj = $data['msjError'];
                echo '<div class="row text-center pt-2">
                    <div class="col">
                    <div class="alert alert-danger" role="alert">'.$msj.'</div class>
                    </div>
                    </div>';
            } elseif (isset($data['msj'])){
                $msj = $data['msj'];
                echo '<div class="row text-center pt-2">
                    <div class="col">
                    <div class="alert alert-success" role="alert">'.$msj.'</div class>
                    </div>
                    </div>';
            }
            ?>
            <div class="col-12 mt-5">
                <h6>Pedidos</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ver pedido</th>
                            <th scope="col">Realizado por</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Estado</th>
                            <th scope="col"><i class="fas fa-check"></i></th>
                            <th scope="col"><i class="fas fa-shipping-fast"></i></th>
                            <th scope="col">X</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (count($compras)>0){
                                $num = 0;
                                foreach ($compras as $compra) {
                                    $buscaId['idcompra'] = $compra->getId();
                                    $estadoCompras = $abmCompraEstado->buscar($buscaId);
                                    $buscaIdTipo['idcompraestadotipo'] = $estadoCompras[0]->getCompraEstadoTipo()->getId();
                                    $compraEstadoTipo = $abmCompraEstadoTipo->buscar($buscaIdTipo);
                                    echo '<tr>
                                    <th>'.$num.'</th>
                                    <td><a href="detallePedido.php?idcompra='.$compra->getId().'">Ver detalles</a></td>
                                    <td>'.$compra->getUsuario()->getUsNombre().'</td>
                                    <td>'.$compra->getCoFecha().'</td>
                                    <td>'.$compraEstadoTipo[0]->getCetDescripcion().'</td>';
                                    if ($compraEstadoTipo[0]->getId() != 1 and $compraEstadoTipo[0]->getId() != 2){
                                        echo '<td><i class="fas fa-check"></i></td>';
                                        echo '<td><i class="fas fa-shipping-fast"></i></td>';
                                        echo '<td>X</td>';
                                    } elseif ($compraEstadoTipo[0]->getId() == 1) {
                                        echo '<td><a class="text-success" href="accion/gestionEstadosCompra.php?accion=aceptar&idcompra='.$compra->getId().'" style="text-decoration:none;"><i class="fas fa-check"></i></a></td>';
                                        echo '<td><i class="fas fa-shipping-fast"></i></td>';
                                        echo '<td><a class="text-danger" href="accion/gestionEstadosCompra.php?accion=cancelar&idcompra='.$compra->getId().'" style="text-decoration:none;">X</a></td>';
                                    } elseif ($compraEstadoTipo[0]->getId() == 2) {
                                        echo '<td><i class="fas fa-check"></i></td>';
                                        echo '<td><a class="text-success" href="accion/gestionEstadosCompra.php?accion=enviar&idcompra='.$compra->getId().'" style="text-decoration:none;"><i class="fas fa-shipping-fast"></i></a></td>';
                                        echo '<td><a class="text-danger" href="accion/gestionEstadosCompra.php?accion=cancelar&idcompra='.$compra->getId().'" style="text-decoration:none;">X</a></td>';
                                    }
                                    echo '</tr>';
                                    $num++;
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