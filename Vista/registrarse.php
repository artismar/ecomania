<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/themes/color.css">
    <link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.6.6/demo/demo.css">
    <script type="text/javascript" src="js/jquery-easyui-1.6.6/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-easyui-1.6.6/jquery.easyui.min.js"></script>
</head>

<?php
    include_once "../config.php";
    $sesion = new Session();
    // Si la sesion esta iniciada y quiere ingresar al login
    if ($sesion->activa()){
        echo '<div class="container-fluid text-center">
            <div class="alert alert-success mt-5" role="alert">Ya tienes una sesion activa, cierra sesion para ingresar al registro.</div class>
            </div>';
    } else {
?>
<body class="text">


<main class="form-signup mt-2">
    <!--FORMULARIO-->
    <form class="needs-validation" action="accion/ingresarUsuario.php" method="post" novalidate>
        <div class="text-center">
            <a href="index.php"><img class="mb-3" src="img/logo.png" alt="Logo del sitio" width="72" height="72"></a>
            <h1 class="mb-4">Registrarse</h1>
        </div>
        <div class="mb-3">
            <label for="usnombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="usnombre" name="usnombre" placeholder="Juan Perez" pattern="[a-zA-Z ]{3,50}" required>
        </div>
        <div class="mb-3">
            <label for="usmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="usmail" name="usmail" placeholder="tunombre@ejemplo.com" required>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="uspass" name="uspass" pattern="[a-zA-Z0-9]{6, 50}" required>
            <div class="invalid-feedback" id="uspass">Debes colocar una contraseña minimo 6 caracteres; caracteres validos (a-z/A-Z/0-9) No ingresar signos ni espacios.</div>
        </div>
        <div class="mb-4">
            <label for="pass" class="form-label">Repetir contraseña</label>
            <input type="password" class="form-control" id="uspass" name="uspass" pattern="[a-zA-Z0-9]{6,20}" required>
            <div class="invalid-feedback" id="uspass"></div>
        </div>
        <div class="mb-3">
            <label class="text-checkbox">
                <input type="checkbox" value="newsletter" id="newsletter"> Recibir emails sobre ofertas y/o nuevos productos.
            </label>
            <label class="text-checkbox mt-2">
                <input type="checkbox" value="politicaprivacidad" id="politicaprivacidad" required> Estoy de acuerdo con la <a href="#">politica de privacidad</a>.
            </label>
        </div>
        <div class="my-4 text-center">
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </div>
    </form>
</main>



<?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/validacion.js"></script>
</body>
</html>