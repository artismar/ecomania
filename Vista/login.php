<?php
    $title = 'Iniciar sesion';
    include_once 'estructura/cabecera.php';
    $datos = data_submitted();

    // Si la sesion esta iniciada y quiere ingresar al registro
    if ($sesion->activa()){
        echo '<div class="container-fluid text-center">
            <div class="alert alert-success mt-5" role="alert">Ya tienes una sesion activa, cierra sesion para ingresar al login.</div class>
            </div>';
    } else {
?>
<div class="container-fluid bg-light">
    <div class="row text-center pt-5">
        <div class="col">
            <p>¿No tenes cuenta? <a href="<?php echo $registro?>">¡Crea una aquí!</a></p>
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
        <div class="col m-5">
            <form class='needs-validation' method="POST" action="accion/verificarLogin.php" novalidate>
              <div class="mb-3">
                <label for="usmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="usmail" name='usmail' aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">Ej.: tunombre@gmail.com</div>
                <div class="invalid-feedback" id="usmail">Debe ser un email valido.</div>
              </div>
              <div class="mb-3">
                <label for="uspass" class="form-label">Password</label>
                <input type="password" class="form-control" id="uspass" name='uspass' required>
                <div class="invalid-feedback" id="uspass">Debes colocar una contraseña.</div>
              </div>
              <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
        </div>
    </div>
</div>











<?php
    }
    include_once 'estructura/pie.php';
?>