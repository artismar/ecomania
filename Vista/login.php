<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesion</title>
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
    $datos = data_submitted();
    $sesion = new Session();
    // Si la sesion esta iniciada y quiere ingresar al registro
    if ($sesion->activa()){
        echo '<div class="container-fluid text-center">
            <div class="alert alert-success mt-5" role="alert">Ya tienes una sesion activa, cierra sesion para ingresar al login.</div class>
            </div>';
    } else {
?>

<body class="text-center">
    
    

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
    <main class="form-signin mt-2">
        <form class='needs-validation' method="POST" action="accion/verificarLogin.php" novalidate>
            <a href="index.php"><img class="mb-3" src="img/logo.png" alt="Logo del sitio" width="72" height="72"></a>
            <h1 class="mb-4">Ingresar</h1>
            <div class="form-floating">
                <input type="email" class="form-control" id="usmail" name="usmail" placeholder=" " required>
                <label for="usmail">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="uspass" name='uspass' placeholder=" " required>
                <label for="uspass">Contraseña</label>
            </div>
            <div class="my-3">
                <label class="text-checkbox">
                    <input type="checkbox" value="rememberme"> Recordarme
                </label>
            </div>
            <div class="my-4">
                <button type="submit" class="w-100 btn btn-lg btn-primary">Sign in</button>
            </div>
        </form>
        <div class="row text-center pt-5">
            <div class="col">
                <p>¿No tenes cuenta? <a href="registrarse.php">Crea una aquí</a></p>
            </div>
        </div>
    </main>




<?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/validacion.js"></script>
</body>
</html>