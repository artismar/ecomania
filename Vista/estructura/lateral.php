
<!-- MENU LATERAL-->
<div class="container-fluid bg-light">
    <div class="row p-5">
        <!-- ITEMS IZQUIERDA | LADO IZQUIERDO -->
        <div class="col-md-2 mb-5">
            <div class="list-group">
                <?php
                        $subMenus = $abmMenu->subMenus($id);
                        if (count($subMenus) > 0){
                            foreach ($subMenus as $item) {
                                $buscaIdL['idmenu'] = $item->getId();
                                $menuDelRol = $abmMenuRol->buscar($buscaIdL);
                                foreach ($menuDelRol as $itemDelRol) {
                                    if ($itemDelRol->getRol()->getId() == $rolActual->getId())
                                        echo '<a type="button" class="list-group-item list-group-item-action" href="'.$item->getMeDescripcion().'">'.$item->getMeNombre().'</a>';  
                                }
                            }
                        }
                ?>
            </div>
        </div>
        <!-- FLECHA SEPARADOR | SEPARADOR DEL MENU IZQUIERDO Y DEL CONTENIDO DERECHO -->
        <div class="col-1">
            <hr width="1" size="500">
        </div>
        <div class="col-9">

        <!-- CONTENIDO DERECHO | SEGUIR ESTRUCTURA EN LA PAGINA CORRESPONDIENTE -->


        <!-- COLOCAR ESTOS 3 CIERRES DIV AL FINAL DE LA PAGINA CORRESPONDIENTE -->
<!--    </div>
     </div>
    </div>              -->
