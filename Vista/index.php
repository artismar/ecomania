<?php
    $title = 'Inicio';
    include_once 'estructura/cabecera.php';
?>

<!-- CAROUSEL -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo $carousel01?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo $carousel02?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo $carousel03?>" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- CARDS -->
<div class="container pt-5">
    <div class="row text-center justify-content-center align-items-center ">
        <div class="col-md">
            <div class="card text-white mb-3 bg-primary">
              <div class="card-header"><i class="fas fa-shipping-fast"></i></div>
              <div class="card-body">
                <h5 class="card-title">Envíos</h5>
                <p class="card-text">Llevamos tu pedido al instante si sos de Cipolletti o Neuquén.</p>
              </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card text-white mb-3 bg-primary">
              <div class="card-header"><i class="far fa-credit-card"></i></div>
              <div class="card-body">
                <h5 class="card-title">Pago</h5>
                <p class="card-text">Realiza tu pago con tarjeta de credito o debito.</p>
              </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card text-white mb-3 bg-primary">
              <div class="card-header"><i class="fas fa-lock"></i></div>
              <div class="card-body">
                <h5 class="card-title">Seguro</h5>
                <p class="card-text">Comprá con seguridad, tus datos siempre protegidos.</p>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- TEXTO PRE ARTICULOS ARTICULOS -->

<div class="container">
    <div class="row text-center m-5 text-muted">
        <div class="col mt-2">
            <h4>Pequeños hábitos, grandes cambios</h4>
            <p class="mt-3">¿Que habitos deseas cambiar hoy?</p>
        </div>
    </div>
</div>


<!-- ARTICULOS DESTACADOS -->
<div class="container mb-5">
  <div class="row row-cols-2 row-cols-md-3 g-4">
    <?php 
      include_once('accion/listarProductos.php');
      listarProductosDestacados();
    ?>
  </div>
</div>












<?php
    include_once 'estructura/pie.php';
?>