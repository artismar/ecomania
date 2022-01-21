<?php
    $segura = true;
    $title = 'Deposito';
    include_once 'estructura/cabecera.php';

    $id = 5; // id del menu deposito
    include_once 'estructura/lateral.php';

    $datos = data_submitted();
?>

<!-- AGREGA PRODUCTO -->
<div class="row">
    <div class="col">
        <h5>Agrega un producto nuevo.</h5>
        <p>
            Coloca los datos del nuevo producto.
        </p>
    </div>
    <div class="row">
        <form class="needs-validation" action="accion/agregarProducto.php" method="post" enctype="multipart/form-data" novalidate>
            <?php
                if (isset($datos['msjError'])){
                    $msj = $datos['msjError'];
                    echo '<div class="alert alert-danger" role="alert">'.$msj.'</div>';
                } elseif (isset($datos['msj'])){
                    $msj = $datos['msj'];
                    echo '<div class="alert alert-success" role="alert">'.$msj.'</div>';
                }
            ?>
            <div class="col-12 mb-3">
                <label for="pronombre" class="form-label">Nombre del producto: </label>
                <input type="text" class="form-control w-50" id="pronombre" name="pronombre" maxlength="50" pattern="[a-zA-Z ]{2,50}" required>
                <div class="invalid-feedback" id="pronombre">Debes colocar un nombre valido.</div>
            </div>
            <div class="col-12 mb-3">
                <label for="prodetalle" class="form-label">Descripcion del producto: </label>
                <textarea class="form-control" placeholder="..." id="prodetalle" name="prodetalle"></textarea>
                <div class="invalid-feedback" id="prodetalle">Debes colocar una descripcion valida.</div>
            </div>
            <div class="col-12 mb-3">
                <label for="procantstock" class="form-label">Cantidad stock: </label>
                <input type="number" class="form-control w-25" id="procantstock" name="procantstock" pattern="[0-9]" required>
                <div class="invalid-feedback" id="procantstock">Debes colocar un stock valido.</div>
            </div>
            <div class="col-12 mb-5">
                <label for="proprecio" class="form-label">Precio: </label> <br>
                <div class="input-group w-25">
                    <span class="input-group-text" id="basic-addon1">$</span>
                    <input type="number" class="form-control" id="proprecio" name="proprecio" aria-describedby="basic-addon1" pattern="[0-9]" required>
                </div>
                <div class="invalid-feedback" id="proprecio">Debes colocar un precio valido.</div>
            </div>
            <div class="mb-3">
                <label for="proimagen" class="form-label">Imagen: </label>
                <input class="form-control" type="file" id="proimagen" name="proimagen" accept=".jpg,.jpeg,.png" required>
                <div class="invalid-feedback" id="proimagen">Formatos validos: jpg/jpeg/png (limite 10MB).</div>
            </div>
            <div class="col-12 mb-3">
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        </form>
    </div>
</div>







<!-- 3 cierres de div completando la estructura del menu lateral -->
</div>
</div>
</div>


<?php
    include_once 'estructura/pie.php';
?>