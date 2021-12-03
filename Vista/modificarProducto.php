<?php
    $segura = true;
    $title = 'Editar perfil';
    include_once 'estructura/cabecera.php';

    $id = 5; // id del menu deposito
    include_once 'estructura/lateral.php';

    $datos = data_submitted();
    if (isset($datos['idproducto'])){
        $abmProducto = new AbmProducto();
        $productos = $abmProducto->buscar($datos);
        if (count($productos)>0){
            $producto = $productos[0];
?>

<!-- MODIFICAR DATOS DEL PRODUCTO -->
<div class="row">
    <div class="col">
        <div class="row">
                <h5>¡Aqui puedes editar el producto seleccionado!</h5>
                <form class="needs-validation mt-5" action="accion/modificarPro.php" method="post" novalidate>
                    <?php
                        if (isset($datos['msjError'])){
                            $msj = $datos['msjError'];
                            echo '<div class="alert alert-danger" role="alert">'.$msj.'</div>';
                        } elseif (isset($datos['msj'])){
                            $msj = $datos['msj'];
                            echo '<div class="alert alert-success" role="alert">'.$msj.'</div>';
                        }
                    ?>
                    <input type="hidden" class="form-control" value="<?php echo $producto->getId()?>" id="idproducto" name="idproducto">
                    <div class="col-12 mb-3">
                        <label for="pronombre" class="form-label">Nombre: </label>
                        <input type="text" class="form-control w-50" value="<?php echo $producto->getProNombre()?>" id="pronombre" name="pronombre" pattern="[a-zA-Z ]{2,50}" required>
                        <div class="invalid-feedback" id="pronombre">Debes colocar un nombre valido.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="prodetalle" class="form-label">Descripcion: </label>
                        <textarea class="form-control" id="prodetalle" name="prodetalle"><?php echo $producto->getProDetalle()?></textarea>
                        <div class="invalid-feedback" id="prodetalle">Debes colocar una descripcion valida.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="procantstock" class="form-label">Cantidad stock: </label>
                        <input type="number" class="form-control w-25" id="procantstock" name="procantstock" value="<?php echo $producto->getProCantStock()?>" pattern="[0-9]" required>
                        <div class="invalid-feedback" id="procantstock">Debes colocar un stock valido.</div>
                    </div>
                    <div class="col-12 mb-5">
                        <label for="proprecio" class="form-label">Precio: </label> <br>
                        <div class="input-group w-25">
                            <span class="input-group-text" id="basic-addon1">$</span>
                            <input type="number" class="form-control" id="proprecio" name="proprecio" aria-describedby="basic-addon1" value="<?php echo $producto->getProPrecio()?>" pattern="[0-9]" required>
                        </div>
                        <div class="invalid-feedback" id="proprecio">Debes colocar un precio valido.</div>
                    </div>
                    <div class="mb-3">
                        <label for="proimagen" class="form-label">Nueva imagen: </label>
                        <input class="form-control" type="file" id="proimagen" name="proimagen" accept=".jpg,.jpeg,.png">
                        <div class="invalid-feedback" id="proimagen">Formatos validos: jpg/jpeg/png (limite 10MB).</div>
                    </div>
                    <div class="col-12 mb-3">
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">Eliminar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-hidden="true" aria-labelledby="modalTitle">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">¿Seguro deseas eliminar este producto?</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2 text-center">
                    <p>Estas por eliminar el siguiente producto:</p>
                    <p><span style="color: red;"><?php echo $producto->getProNombre()?></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="accion/eliminarPro.php?idproducto=<?php echo $producto->getId()?>">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<?php
        } else{
            echo '<div class="alert alert-danger" role="alert">Este producto no existe, actualiza la lista de productos y vuelve a seleccionarlo.</div>';
        }
    } else{
        echo '<div class="alert alert-danger" role="alert">Selecciona un producto valido en la lista para modificar.</div>';
    }
?>







<!-- 3 cierres de div completando la estructura del menu lateral -->
</div>
</div>
</div>


<?php
    include_once 'estructura/pie.php';
?>