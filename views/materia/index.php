<?php 
//$listado_materias = Materia::find()->all();
$listado_materias = $model->searchArrayByQuery("select * from materia order by cod_materia asc");
//var_dump($listado_materias);die();


if(isset($listado_materias) && count ($listado_materias)):

$frm = new HTML();
$count = count($listado_materias);

endif;
?>
<div class="contenido-index">

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>

<div class="contenido-alineado-derecha">
<a href="<?php echo ROUTER::create_action_url("materia/nuevo")?> "><button class="btn"><i class="fa fa-plus" aria-hidden="true"></i> <b>Agregar Materia </b></button></a>
</div>

<br>
<br>
<center>


<?php if(isset($listado_materias) && count ($listado_materias)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th style="display: none">Cod_materia</th>
        <th>Código de la Materia</th>
        <th>Nombre Materia</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td style="display: none"><?php echo $listado_materias[$i]["cod_materia"]?></td>
            <td><?php echo $listado_materias[$i]["codigo"]?></td>
            <td><?php echo $listado_materias[$i]["nombre_materia"]?></td>

            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="39%">

                <a href="<?php echo ROUTER::create_action_url("materia/editar", [$listado_materias[$i]["cod_materia"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a> 

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
           window.location.href='<?= ROUTER::create_action_url("materia/eliminar", [$listado_materias[$i]["cod_materia"]])?>';
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
    <p><strong>¡No hay Materias registradas!</strong></p>

<?php endif;?>

</center>
<br>
</div>