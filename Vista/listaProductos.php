<?php
    $segura = true;
    $title = 'Deposito';
    include_once 'estructura/cabecera.php';

    $id = 5; // id del menu deposito
    include_once 'estructura/lateral.php';

    $abmProducto = new AbmProducto();
    $productos = $abmProducto->buscar(null);
    $datos = data_submitted();
?>

<!-- LISTA PRODUCTOS -->
<div class="row">
    <div class="col">
        <h5>Gestiona aqui los productos de la tienda.</h5>
        <p>
            Agrega, modifica o elimina productos, tambien, modifica su stock.
        </p>
        <?php
            if (isset($datos['msjError'])){
                $msj = $datos['msjError'];
                echo '<div class="alert alert-danger" role="alert">'.$msj.'</div>';
            } elseif (isset($datos['msj'])){
                $msj = $datos['msj'];
                echo '<div class="alert alert-success" role="alert">'.$msj.'</div>';
            }
                $cant = count($productos);
            if ($cant>0){
                echo '<p class="alert">Hay <span style="color: green;">'.$cant.'</span> producto(s) registrado(s) en la tienda.</p>';
            } else {
                echo '<p class="alert alert-danger">Ups no hay productos agregados a la tienda. <a type="button" class="btn btn-success" href="agregarProducto.php">Agregar producto</a></p>';
            }
        ?>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Precio</th>
                    <th scope="col"><a href="agregarProducto.php"><i class="fas fa-plus"></i></a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($cant>0){
                        $number = 1;
                        foreach ($productos as $producto) {
                            echo '<tr>
                            <th>'.$number.'</th>
                            <td>'.$producto->getProNombre().'</td>
                            <td>'.$producto->getProCantStock().'</td>
                            <td>$'.$producto->getProPrecio().'</td>
                            <td><a href="modificarProducto.php?idproducto='.$producto->getId().'"><i class="fas fa-edit"></i></a></td>
                            </tr>';
                            $number++;
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







<!-- 3 cierres de div completando la estructura del menu lateral -->
</div>
</div>
</div>


<?php
    include_once 'estructura/pie.php';
?>