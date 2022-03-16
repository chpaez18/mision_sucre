


<br>

<?php 


if($model->user()->rol_cod_rol == 1){
    $listado_aldeas = $model->searchArrayByQuery("select * from aldea order by cod_aldea");

}elseif ($model->user()->rol_cod_rol == 2) {

    $id_usuario = $model->user()->cod_usuario;
    
    $coordinador = $model->searchByQueryOne("select * from coordinador where usuario_cod_usuario = $id_usuario");

    $cod_aldea = $coordinador->aldea_cod_aldea;

    $listado_aldeas = $model->searchArrayByQuery("select * from aldea where cod_aldea = $cod_aldea");

    $nombre = "Aldea Asignada al Coordinador: " . $coordinador->nombre_coordinador . " " . $coordinador->apellido_coordinador;
}


if(isset($listado_aldeas) && count ($listado_aldeas)):

$frm = new HTML();
$count = count($listado_aldeas);

endif;
?>


<div class="contenido-index">


<?php if(Session::accesoViewEstricto(["1"])){ ?>
<p>
<div class="contenido-alineado-izquierda">
    <h3><?= $this->titulo; ?></h3>
</div>

<div class="contenido-alineado-derecha">
        <a href="<?php echo ROUTER::create_action_url("aldea/nuevo")?> "><button class="btn"><i class="fa fa-plus" aria-hidden="true"></i> <b>Agregar Aldea </b></button></a>

</div>  

</p>
<?php }else{?>
<div class="contenido-alineado-izquierda">
    <h3><?php
        if($model->user()->rol_cod_rol == 2){
            
            echo $nombre;
             
        }else{
            echo $this->titulo;
        }
    ?></h3>
</div>
<?php }?>


<br>
<br>

<center>

<?php if(isset($listado_aldeas) && count ($listado_aldeas)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th style="display: none">cod_aldea</th>
        <th>Nombre Aldea</th>
        <th>Ubicación</th>
        <th>Coordinador Asignado</th>
        <th>Eje</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td style="display: none"><?php echo $listado_aldeas[$i]["cod_aldea"]?></td>
            <td><?php echo $listado_aldeas[$i]["nombre_aldea"]?></td>
            <td><?php echo $listado_aldeas[$i]["ubicacion"]?></td>
            <td><?= ($model->getAldeaCord($listado_aldeas[$i]["cod_aldea"]) != NULL) ? $model->getAldeaCord($listado_aldeas[$i]["cod_aldea"]) : "No definido"?></td>
            <td><?php echo $model->getZonas($listado_aldeas[$i]["cod_aldea"]) ?></td>
            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="39%">
                <a href="<?php echo ROUTER::create_action_url("aldea/view", [$listado_aldeas[$i]["cod_aldea"]]) ?>"><button class="btn"><i class="fa fa-eye"></i><b> Ver</b></button></a>              
<?php if(Session::accesoViewEstricto(["1"])){ ?>
                <a href="<?php echo ROUTER::create_action_url("aldea/editar", [$listado_aldeas[$i]["cod_aldea"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a> 
<?php } ?>
                <a href="<?php echo ROUTER::create_action_url("aldea/asig_carrera", [$listado_aldeas[$i]["cod_aldea"]]) ?>"><button class="btn"><i class="fa fa-share"></i><b> Asig. Carrera</b></button></a> 
<?php if(Session::accesoViewEstricto(["1"])){ ?>
                <button id="boton_eliminar<?=$listado_aldeas[$i]["cod_aldea"]?>" class="btn-danger"><i class="icon-trash"></i><b>Eliminar</b></button>
            </td>

<script type="text/javascript">
$(document).ready(function() {

$("#datatables").on("click",".btn-danger", function(){
$('#boton_eliminar<?=$listado_aldeas[$i]["cod_aldea"]?>').click(function(){
    swal({
        title: "¿Está Seguro de querer eliminar este registro?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0275d8",
        confirmButtonText: "Si",
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#d9534f",
        closeOnConfirm: true
    }, function (isConfirm) {
        if (isConfirm) {
           window.location.href='<?= ROUTER::create_action_url("aldea/eliminar", [$listado_aldeas[$i]["cod_aldea"]])?>';
        } else {

         }
    });
});
})



});
</script>

<?php } ?>
        </tr>
        <?php } ?>
</tbody>

</table>

<br>

<?php else:?>
    <p><strong>¡No hay Aldeas registradas!</strong></p>

<?php endif;?>
</center>
<br>



</div>















