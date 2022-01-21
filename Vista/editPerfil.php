<?php
    $segura = true;
    $title = 'Editar perfil';
    include_once 'estructura/cabecera.php';

    $id = 6; // id del menu cuenta
    include_once 'estructura/lateral.php';

    $datos = data_submitted();
?>

<!-- MODIFICAR DATOS DE LA CUENTA -->
<div class="row">
    <div class="col">
        <div class="row">
                <h5>¡Aqui puedes editar los datos de tu perfil, <span style="color: green;"><?php echo $usuario->getUsNombre()?></span>!</h5>
                <form class="needs-validation mt-5" action="accion/editarPerfil.php" method="post" novalidate>
                    <?php
                        if (isset($datos['msjError'])){
                            $msj = $datos['msjError'];
                            echo '<div class="alert alert-danger" role="alert">'.$msj.'</div>';
                        } elseif (isset($datos['msj'])){
                            $msj = $datos['msj'];
                            echo '<div class="alert alert-success" role="alert">'.$msj.'</div>';
                        }
                    ?>
                    <input type="hidden" class="form-control" value="<?php echo $usuario->getId()?>" id="idusuario" name="idusuario">
                    <input type="hidden" class="form-control" value="<?php echo $usuario->getUsDeshabilitado()?>" id="usdeshabilitado" name="usdeshabilitado">
                    <div class="col-12 mb-3">
                        <label for="usnombre" class="form-label">Nombre: </label>
                        <input type="text" class="form-control w-50" value="<?php echo $usuario->getUsNombre()?>" id="usnombre" name="usnombre">
                        <div class="invalid-feedback" id="usnombre">Debe ser un nombre valido.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="usmail" class="form-label">Email: </label>
                        <input type="email" class="form-control w-50" value="<?php echo $usuario->getUsMail()?>" id="usmail" name="usmail">
                        <div class="invalid-feedback" id="usmail">Debe ser un email valido.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>

                <!-- Modificar contra -->
                <form class="needs-validation mt-5" action="" method="post">
                    <input type="hidden" class="form-control" value="<?php $usuario->getId()?>" id="idusuario" name="idusuario">
                    <div class="col-12 my-5">
                        <h5><i class="fas fa-key"></i> | Modificar contraseña</h5>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="anteriorpass" class="form-label">Contraseña actual: </label>
                        <input type="password" class="form-control w-50" id="anteriorpass" name="anteriorpass">
                        <div class="invalid-feedback" id="anteriorpass">Debe ser una contraseña valida.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="uspass" class="form-label">Nueva contraseña: </label>
                        <input type="password" class="form-control w-50" id="uspass" name="uspass">
                        <div class="invalid-feedback" id="uspass">Debe ser una contraseña valida.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="uspass" class="form-label">Repetir nueva contraseña: </label>
                        <input type="password" class="form-control w-50" id="uspass1" name="uspass">
                        <div class="invalid-feedback" id="uspass">Debe ser una contraseña valida.</div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
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