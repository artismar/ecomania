<?php
    include_once '../../config.php';
    $accion = true;
    $datos = data_submitted();
    if (isset($datos['idproducto'])){
        $abmProducto = new AbmProducto();
        $productos = $abmProducto->buscar($datos);
        if (count($productos) > 0){
            $producto = $productos[0];
            $imagen = $abmProducto->buscaImagen($producto->getId());
            $title = $producto->getProNombre();
            include_once '../estructura/cabecera.php';
?>

<div class="container">
    <div class="row">
        <div class="col m-5">
            <img class="img-fluid" src="../../image/<?php echo $imagen[1];?>" alt="<?php echo $producto->getProNombre();?>" style="width:400px">
        </div>
        <div class="col m-5">
            <div>
                <h3><?php echo $producto->getProNombre()?></h3>
            </div>
            <div class="mt-5">
                <p><?php echo $producto->getProDetalle()?></p>
            </div>
            <div class="mt-5">
                <h4>Precio: <span class="badge bg-success">$<?php echo $producto->getProPrecio()?></span></h4>
            </div>
            <div class="row mt-5">
                <form class="needs-validation" action="gestionCarrito.php" method="get" novalidate>
                    <input type="hidden" id="idproducto" name="idproducto" value="<?php echo $producto->getId()?>">
                    <label class="col-sm-2 col-form-label" for="cantidad">Cantidad: </label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control w-25" id="cantidad" name="cantidad" min="1" max="<?php echo $producto->getProCantStock()?>" step required>
                        <div class="invalid-feedback" id="uspass">Ingrese una cantidad exacta. Stock actual: <?php echo $producto->getProCantStock()?></div>
                    </div>
                    <input type="hidden" id="accion" name="accion" value="agregar">
                    <?php
                    if ($producto->getProCantStock()>5){
                        echo '<button href="gestionCarrito.php" class="btn btn-primary mt-3">Agregar al carrito</button>';
                    } elseif ($producto->getProCantStock()<=5 and $producto->getProCantStock()>0){
                        echo '<button href="gestionCarrito.php" class="btn btn-primary mt-3">Agregar al carrito</button>';
                        echo '<p class="text-danger">Queda poco stock</p>';
                    } elseif ($producto->getProCantStock() == 0){
                        echo '<button href="#" class="btn btn-primary disabled mt-3">Agregar al carrito</button>';
                        echo '<p class="text-danger">NO HAY STOCK</p>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
        } else{
            header("Location:../productos.php");
        }
    } else{
        header("Location:../productos.php");
    }
?>



<?php
    include_once '../estructura/pie.php';
?>