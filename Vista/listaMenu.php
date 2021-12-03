<?php
    $segura = true;
    $title = 'Administracion | Gestion Menus';
    include_once 'estructura/cabecera.php';

    $id = 4; // id del menu administracion
    include_once 'estructura/lateral.php';

    $abmMenu = new AbmMenu();
    $abmMenuRol = new AbmMenuRol();
    $menus = $abmMenu->buscar(null);
    $menusRol = $abmMenuRol->buscar(null);
?>

<!-- LISTA PRODUCTOS -->
<div class="row">
    <div class="col">
        <h5>Gestiona aqui el menu de la tienda.</h5>
        <p>
            Agrega, modifica o elimina items del menu.
        </p>
    </div>
    <div class="row">
            <!-- TABLA -->
            <table id="dg" title="Gestionar menu" class="easyui-datagrid" style="width:700px;height:250px"
                url="accion/listarMenu.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                    <th field="idmenu" width="50">Id</th>
                    <th field="menombre" width="50">Nombre</th>
                    <th field="medescripcion" width="50">URL</th>
                    <th field="idpadre" width="50">Submenu De:</th>
                    <th field="medeshabilitado" width="50">Deshabilitado</th>
                    </tr>
                </thead>
            </table>
            <!-- TOOLBAR -->
            <div id="toolbar">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenu()">Nuevo Menu</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Editar Menu</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMenu()">Baja Menu</a>
            </div>
    </div>
</div>

 <!-- MODAL MENU -->
 <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Menu Informacion</h3>
        <div style="margin-bottom:10px">    
            <input name="menombre" id="menombre"  class="easyui-textbox" required="true" label="Nombre: " style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input  name="medescripcion" id="medescripcion"  class="easyui-textbox" required="true" label="URL: /" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <select name="idpadre" id="idpadre">
                <option value="null" autofocus></option>
            </select>
        </div>
        <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="medeshabilitado" name="medeshabilitado" value="medeshabilitado" label="Deshabilitar: ">
        </div>
        <!-- <button type="submit" class="btn">Ok</button> -->
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>





<!-- 3 cierres de div completando la estructura del menu lateral -->
</div>
</div>
</div>


<script type="text/javascript">
    var url;
    function newMenu(){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Menu');
        $('#fm').form('clear');
        url = 'accion/alta_menu.php';
    }

    function editMenu(){
        var row = $('#dg').datagrid('getSelected');
        console.log(row);
        if (row){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Menu');
            $('#fm').form('load', row);
            url = 'accion/edit_menu.php?idmenu='+row.idmenu;
        }
    }

    function saveMenu(){
            	//alert(" Accion");
                $('#fm').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        // console.log(result);
                        var result = eval('('+result+')');

                        // alert("Volvio Serviodr");   
                        if (!result.respuesta){
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                           
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload 
                        }
                    }
                });
            }

    function destroyMenu(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('Confirm','Seguro que desea eliminar el menu?', function(r){
                if (r){
                    $.post('accion/eliminar_menu.php?idmenu='+row.idmenu,{idmenu:row.id},
                        function(result){
                            // alert("Volvio Serviodr");   
                            if (result.respuesta){
                                
                            $('#dg').datagrid('reload');    // reload the  data
                        } else {
                            $.messager.show({    // show error message
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    },'json');
                }
            });
        }
    }

    $(function(){
        menusPadres();
    });

    function menusPadres(){
        $.ajax({
            url: 'accion/listarMenuPadres.php',
            type: 'POST',
            success: function(res){
                var js = JSON.parse(res);
                var select;
                for (var i=0;i<js.length;i++){
                    select += '<option value="'+js[i].idmenu+'">'+js[i].menombre+'</option>';
                }
            }
        });
    }

</script>



<?php
    include_once 'estructura/pie.php';
?>