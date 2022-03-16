<?php 
$listado_carreras = $model->searchArrayByQuery("select * from carrera order by cod_carrera");

if(isset($listado_carreras) && count ($listado_carreras)):

$frm = new HTML();
$count = count($listado_carreras);

endif;
?>
<div class="contenido-index">

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>

<div class="contenido-alineado-derecha">
        <a href="<?php echo ROUTER::create_action_url("carrera/nuevo")?> "><button class="btn"><i class="fa fa-plus" aria-hidden="true"></i> <b> Agregar Carrera </b></button></a>
</div>

<br>
<br>

<center>

<?php if(isset($listado_carreras) && count ($listado_carreras)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th style="display: none">cod_carrera</th>
        <th>Nombre Carrera</th>
        <th>Tipo</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td style="display: none"><?php echo $listado_carreras[$i]["cod_carrera"]?></td>
            <td><?php echo $listado_carreras[$i]["nombre_carrera"]?></td>
            <td><?php echo $listado_carreras[$i]["tipo"]?></td>
            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="39%">

                <a href="<?php echo ROUTER::create_action_url("carrera/view", [$listado_carreras[$i]["cod_carrera"]]) ?>"><button class="btn"><i class="fa fa-eye"></i><b> Ver</b></button></a>

                <a href="<?php echo ROUTER::create_action_url("carrera/editar", [$listado_carreras[$i]["cod_carrera"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a>

                <a href="<?php echo ROUTER::create_action_url("carrera/asig_materia", [$listado_carreras[$i]["cod_carrera"]]) ?>"><button class="btn"><i class="fa fa-share"></i><b>Asig. Materia</b></button></a>                


                <button id="boton_eliminar<?=$i?>" class="btn-danger"><i class="icon-trash"></i><b>Eliminar</b></button>
            </td>
<script type="text/javascript">
$(document).ready(function() {
    
$("#datatables").on("click",".btn-danger", function(){
$('#boton_eliminar<?=$i?>').click(function(){
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
           window.location.href='<?= ROUTER::create_action_url("carrera/eliminar", [$listado_carreras[$i]["cod_carrera"]])?>';
        } else {

         }
    });
});
});


});
</script>


        </tr>
        <?php } ?>
</tbody>

</table>

<br>

<?php else:?>
    <p><strong>¡No hay Carreras registradas!</strong></p>

<?php endif;?>

</center>
<br>
</div>

