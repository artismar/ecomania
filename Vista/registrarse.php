<?php
    $title = 'Registro';
    include_once 'estructura/cabecera.php';

    // Si la sesion esta iniciada y quiere ingresar al login
    if ($sesion->activa()){
        echo '<div class="container-fluid text-center">
            <div class="alert alert-success mt-5" role="alert">Ya tienes una sesion activa, cierra sesion para ingresar al registro.</div class>
            </div>';
            include_once 'estructura/pie.php';
    } else {
?>

<div class="container-fluid bg-light">
    <div class="row pt-5 justify-content-center align-items-center">
        <!--FORMULARIO-->
        <div class="col-6">
            <form class="needs-validation" action="accion/ingresarUsuario.php" method="post" novalidate>
                <div class="mb-3">
                    <label for="usnombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="usnombre" name="usnombre" placeholder="Ej.: Juan Perez" pattern="[a-zA-Z ]{3,50}" required>
                    <div class="invalid-feedback" id="usnombre">Debes colocar un nombre valido.</div>
                </div>
                <div class="mb-3">
                    <label for="usmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="usmail" name="usmail" placeholder="Ej.: tunombre@gmail.com" required>
                    <div class="invalid-feedback" id="usmail">Debes colocar un email valido.</div>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="uspass" name="uspass" pattern="[a-zA-Z0-9]{6,20}" required>
                    <div class="invalid-feedback" id="uspass">Debes colocar una contraseña entre 6-20 caracteres y caracteres validos (a-zA-Z0-9).</div>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Repetir contraseña</label>
                    <input type="password" class="form-control" id="uspass" name="uspass" pattern="[a-zA-Z0-9]{6,20}" required>
                    <div class="invalid-feedback" id="uspass">Debes colocar la misma contraseña.</div>
                </div>
                <div class="mb-3 me-auto">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
        <!--Linea vertical-->
        <div class="col-1 d-none d-xl-block">
            <hr width="1" size="500">
        </div>
        <div class="col-5 d-none d-xl-block">
            <img src="<?php echo $logo1?>" alt="" width="500px">
        </div>
    </div>
</div>

<?php
    include_once 'estructura/pie.php';
    }
?>