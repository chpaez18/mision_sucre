<?php 
$listado_profesores = $model->searchArrayByQuery("select * from profesor order by cod_profesor");

if(isset($listado_profesores) && count ($listado_profesores)):

$frm = new HTML();
$count = count($listado_profesores);

endif;
?>
<div class="contenido-index">

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>

<div  style='display:inline;float:right'>
 <a href="<?php echo ROUTER::create_action_url("profesor/nuevo")?> "><button class="btn"><i class="fa fa-plus" aria-hidden="true"></i> <b>Agregar Profesor</b> </button></a>
</div>

<div  style='display:inline; float:right; margin-right:13px'>
        <a href="<?php echo ROUTER::create_action_url("profesor/reporte_general")?> "><button class="btn"><i class="fa fa-download" aria-hidden="true"></i> <b>Generar Reporte General</b></button></a>
</div>
<br>
<br>
<center>

<?php if(isset($listado_profesores) && count ($listado_profesores)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th>Número de Cédula</th>
        <th>Nombre del Profesor</th>
        <th>Apellido del Profesor</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td><?php echo $listado_profesores[$i]["ced_profesor"]?></td>
            <td><?php echo $listado_profesores[$i]["nombre_profesor"]?></td>
            <td><?php echo $listado_profesores[$i]["apellido_profesor"]?></td>
            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="39%">

                <a href="<?php echo ROUTER::create_action_url("profesor/view", [$listado_profesores[$i]["cod_profesor"]]) ?>"><button class="btn"><i class="fa fa-eye"></i><b> Ver</b></button></a>

                <a href="<?php echo ROUTER::create_action_url("profesor/editar", [$listado_profesores[$i]["cod_profesor"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a> 

                <a href="<?php echo ROUTER::create_action_url("profesor/asig_materia", [$listado_profesores[$i]["cod_profesor"]]) ?>"><button class="btn"><i class="fa fa-share"></i><b>Asig. Materia</b></button></a>

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
           window.location.href='<?= ROUTER::create_action_url("profesor/eliminar", [$listado_profesores[$i]["cod_profesor"]])?>';
        } else {

         }
    });
});
})


});
</script>

        </tr>
        <?php } ?>
</tbody>

</table>

<br>

<?php else:?>
    <p><strong>¡No hay Profesores registrados!</strong></p>

<?php endif;?>

</center>
<br>

</div>
















